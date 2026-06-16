<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MemberProfileController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        $orders = Order::with(['details.menu'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        $reservations = \App\Models\Reservation::with('table')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('member.profile', compact(
            'customer',
            'orders',
            'reservations'
        ));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $customer = Customer::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        DB::beginTransaction();

        try {
            $user->update([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            $customer->update([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            DB::commit();

            return redirect()->route('member.profile')
                ->with('success', 'Profile berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function invoice(Order $order)
    {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        if ($order->customer_id !== $customer->id) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        $order->load(['details.menu', 'customer', 'cashier']);

        return view('member.invoice', compact('order'));
    }
}