<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FinancialTransaction;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['cashier', 'customer'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::with('menuIngredients.ingredient')
            ->where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $members = Customer::where('is_member', true)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('menus', 'members'));
    }

    public function checkMember($memberCode)
    {
        $customer = Customer::where('member_code', $memberCode)
            ->where('is_member', true)
            ->first();

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Kode membership tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'member_code' => $customer->member_code,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:member,non_member',
            'member_code' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'quantities' => 'required|array',
            'payment_method' => 'required|in:cash,debit,qris,transfer',
        ]);

        $customer = null;
        $isMember = false;

        if ($request->customer_type === 'member') {
            if (! $request->member_code) {
                return back()
                    ->withErrors(['member_code' => 'Kode membership wajib diisi jika customer adalah member.'])
                    ->withInput();
            }

            $customer = Customer::where('member_code', $request->member_code)
                ->where('is_member', true)
                ->first();

            if (! $customer) {
                return back()
                    ->withErrors(['member_code' => 'Kode membership tidak ditemukan.'])
                    ->withInput();
            }

            $isMember = true;
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $items = [];

            foreach ($request->quantities as $menuId => $quantity) {
                $quantity = (int) $quantity;

                if ($quantity <= 0) {
                    continue;
                }

                $menu = Menu::with('menuIngredients.ingredient')->findOrFail($menuId);

                if ($menu->stock < $quantity) {
                    DB::rollBack();

                    return back()
                        ->withErrors(['stock' => 'Stok menu ' . $menu->name . ' tidak mencukupi.'])
                        ->withInput();
                }

                $itemSubtotal = $menu->price * $quantity;
                $subtotal += $itemSubtotal;

                $items[] = [
                    'menu' => $menu,
                    'quantity' => $quantity,
                    'price' => $menu->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            if (count($items) === 0) {
                DB::rollBack();

                return back()
                    ->withErrors(['menu' => 'Pilih minimal satu menu dengan jumlah lebih dari 0.'])
                    ->withInput();
            }

            $discountPercent = $isMember ? 5 : 0;
            $discountAmount = $isMember ? ($subtotal * 5 / 100) : 0;
            $totalAmount = $subtotal - $discountAmount;

            $order = Order::create([
                'cashier_id' => auth()->id(),
                'customer_id' => $customer?->id,
                'reservation_id' => null,
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_name' => $isMember ? $customer->name : $request->customer_name,
                'customer_phone' => $isMember ? $customer->phone : $request->customer_phone,
                'is_member' => $isMember,
                'subtotal' => $subtotal,
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
            ]);

            foreach ($items as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'note' => null,
                ]);

                // Decrement ingredient stocks instead of menu stock
                foreach ($item['menu']->menuIngredients as $menuIngredient) {
                    $ingredient = $menuIngredient->ingredient;
                    if ($ingredient) {
                        $consumedQuantity = $menuIngredient->quantity * $item['quantity'];
                        $ingredient->decrement('current_stock', $consumedQuantity);
                    }
                }
            }

            FinancialTransaction::create([
                'order_id' => $order->id,
                'type' => 'income',
                'category' => 'sales',
                'title' => 'Penjualan ' . $order->order_code,
                'amount' => $totalAmount,
                'transaction_date' => now()->toDateString(),
                'description' => $isMember
                    ? 'Transaksi penjualan member dengan diskon 5%.'
                    : 'Transaksi penjualan non-member.',
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Transaksi berhasil dibuat dan invoice berhasil ditampilkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(['cashier', 'customer', 'details.menu']);

        return view('orders.show', compact('order'));
    }
}