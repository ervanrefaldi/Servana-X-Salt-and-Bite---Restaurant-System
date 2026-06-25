<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function create()
    {
        $customer = null;
        $isMember = false;
        $activeReservation = null;

        /*
        |--------------------------------------------------------------------------
        | Cek jika yang membuka halaman adalah member
        |--------------------------------------------------------------------------
        | Jika member sudah punya reservasi aktif, form tidak ditampilkan.
        */
        if (auth()->check() && auth()->user()->role === 'member') {
            $customer = Customer::where('user_id', auth()->id())->first();
            $isMember = true;

            if ($customer) {
                $activeReservation = Reservation::with('table')
                    ->where('customer_id', $customer->id)
                    ->whereDate('reservation_date', '>=', now()->toDateString())
                    ->whereNotIn('status', ['completed', 'no_show'])                    ->latest()
                    ->first();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Cek jika yang membuka halaman adalah customer biasa
        |--------------------------------------------------------------------------
        | Customer biasa tidak login, jadi reservasi aktif disimpan di session browser.
        */
        if (! $isMember && session()->has('guest_reservation_id')) {
            $activeReservation = Reservation::with('table')
                ->where('id', session('guest_reservation_id'))
                ->whereNull('customer_id')
                ->whereDate('reservation_date', '>=', now()->toDateString())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Jika reservasi lama sudah selesai, batal, atau tanggalnya sudah lewat,
            | session dihapus agar form reservasi muncul kembali.
            |--------------------------------------------------------------------------
            */
            if (! $activeReservation) {
                session()->forget('guest_reservation_id');
            }
        }

        $tables = Table::where('status', 'available')
            ->orderBy('capacity', 'asc')
            ->orderBy('table_number', 'asc')
            ->get();

        $reservations = Reservation::whereDate('reservation_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->get(['table_id', 'reservation_date', 'start_time', 'end_time']);

        return view('reservations.create', compact(
            'customer',
            'isMember',
            'tables',
            'reservations',
            'activeReservation'
        ));
    }

    public function store(Request $request)
    {
        $isMember = auth()->check() && auth()->user()->role === 'member';

        /*
        |--------------------------------------------------------------------------
        | Cegah member membuat reservasi baru jika masih ada reservasi aktif
        |--------------------------------------------------------------------------
        */
        if ($isMember) {
            $customer = Customer::where('user_id', auth()->id())->firstOrFail();

            $activeReservation = Reservation::where('customer_id', $customer->id)
                ->whereDate('reservation_date', '>=', now()->toDateString())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->first();

            if ($activeReservation) {
                return redirect()->route('reservations.create')
                    ->with('success', 'Anda masih memiliki reservasi aktif dengan kode: ' . $activeReservation->reservation_code);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Cegah customer biasa membuat reservasi baru jika session masih aktif
        |--------------------------------------------------------------------------
        */
        if (! $isMember && session()->has('guest_reservation_id')) {
            $activeReservation = Reservation::where('id', session('guest_reservation_id'))
                ->whereNull('customer_id')
                ->whereDate('reservation_date', '>=', now()->toDateString())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->first();

            if ($activeReservation) {
                return redirect()->route('reservations.create')
                    ->with('success', 'Anda masih memiliki reservasi aktif dengan kode: ' . $activeReservation->reservation_code);
            }

            session()->forget('guest_reservation_id');
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi umum
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:' . now()->addDay()->toDateString(),
            'start_time' => 'required',
            'guest_count' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $startTime = $request->start_time;
        if (strlen($startTime) == 5) {
            $startTime .= ':00';
        }
        $endTime = date('H:i:s', strtotime($startTime . ' +60 minutes'));

        /*
        |--------------------------------------------------------------------------
        | Reservasi Member
        |--------------------------------------------------------------------------
        */
        if ($isMember) {
            $customer = Customer::where('user_id', auth()->id())->firstOrFail();

            $request->validate([
                'table_id' => 'required|exists:tables,id',
            ]);

            $conflictingTableIds = Reservation::where('reservation_date', $request->reservation_date)
                ->where('start_time', '<', $endTime)
                ->where('end_time', '>', $startTime)
                ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
                ->pluck('table_id');

            $table = Table::where('id', $request->table_id)
                ->where('status', 'available')
                ->whereNotIn('id', $conflictingTableIds)
                ->first();

            if (! $table) {
                return back()
                    ->withErrors(['table_id' => 'Meja yang dipilih tidak tersedia.'])
                    ->withInput();
            }

            if ($table->capacity < $request->guest_count) {
                return back()
                    ->withErrors(['table_id' => 'Kapasitas meja tidak mencukupi jumlah tamu.'])
                    ->withInput();
            }

            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'table_id' => $table->id,
                'reservation_code' => $this->generateReservationCode(),
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'reservation_date' => $request->reservation_date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_guest' => $request->guest_count,
                'reservation_type' => 'member',
                'table_selection_type' => 'manual',
                'status' => 'pending',
                'note' => $request->note,
            ]);

            return redirect()->route('reservations.create')
                ->with('success', 'Reservasi berhasil dibuat. Kode reservasi Anda: ' . $reservation->reservation_code);
        }

        /*
        |--------------------------------------------------------------------------
        | Reservasi Customer Biasa
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
        ]);

        $conflictingTableIds = Reservation::where('reservation_date', $request->reservation_date)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->pluck('table_id');

        $tableQuery = Table::where('status', 'available')
            ->whereNotIn('id', $conflictingTableIds)
            ->where('capacity', '>=', (int) $request->guest_count)
            ->orderBy('capacity', 'asc')
            ->get();

        $table = null;
        if ($tableQuery->isNotEmpty()) {
            $bestCapacity = $tableQuery->first()->capacity;
            $table = $tableQuery->where('capacity', $bestCapacity)->random();
        }

        if (! $table) {
            return back()
                ->withErrors(['table_id' => 'Belum ada meja yang tersedia untuk jumlah tamu tersebut.'])
                ->withInput();
        }

        $reservation = Reservation::create([
            'customer_id' => null,
            'table_id' => $table->id,
            'reservation_code' => $this->generateReservationCode(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'reservation_date' => $request->reservation_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_guest' => $request->guest_count,
            'reservation_type' => 'non_member',
            'table_selection_type' => 'automatic',
            'status' => 'pending',
            'note' => $request->note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan reservasi customer biasa ke session
        |--------------------------------------------------------------------------
        | Jadi ketika dia membuka halaman /reservasi lagi,
        | yang muncul hanya kode reservasi, bukan form baru.
        */
        session()->put('guest_reservation_id', $reservation->id);

        return redirect()->route('reservations.create')
            ->with('success', 'Reservasi berhasil dibuat. Kode reservasi Anda: ' . $reservation->reservation_code);
    }

    public function success()
    {
        return view('reservations.success');
    }

    public function index(Request $request)
    {
        $now = now();
        $dateOnly = $now->format('Y-m-d');
        $timeOnly = $now->format('H:i:s');

        Reservation::where('status', 'pending')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'no_show']);

        Reservation::where('status', 'confirmed')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'completed']);

        $search = $request->search;

        $reservations = Reservation::with(['customer', 'table'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reservation_code', 'like', '%' . $search . '%')
                        ->orWhere('customer_name', 'like', '%' . $search . '%')
                        ->orWhere('customer_phone', 'like', '%' . $search . '%')
                        ->orWhere('reservation_type', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations', 'search'));
    }
    public function show(Reservation $reservation)
    {
        $reservation->load(['customer', 'table']);

        return view('reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,no_show',
        ]);

        $dateOnly = \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d');
        $reservationDateTime = \Carbon\Carbon::parse($dateOnly . ' ' . $reservation->start_time);
        
        if (now()->lessThan($reservationDateTime)) {
            return redirect()->route('reservations.index')
                ->with('error', 'Status reservasi tidak dapat diubah sebelum waktu reservasi tiba.');
        }

        if (in_array($reservation->status, ['no_show', 'completed'])) {
            return redirect()->route('reservations.index')
                ->with('error', 'Status reservasi yang sudah Selesai atau Tidak Datang tidak dapat diubah lagi.');
        }

        $reservation->update([
            'status' => $request->status,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }

    private function generateReservationCode()
    {
        do {
            $code = 'RSV-' . strtoupper(Str::random(6));
        } while (Reservation::where('reservation_code', $code)->exists());

        return $code;
    }
}