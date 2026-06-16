<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Servana</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 4px 0;
            color: #555;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #333;
            padding: 6px;
        }

        table.data th {
            background: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .print-button {
            margin-bottom: 20px;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print()">
            Print / Save as PDF
        </button>
    </div>

    <div class="header">
        <h2>Laporan Keuangan Servana</h2>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

        @if (request('start_date') || request('end_date'))
            <p>
                Periode:
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') : 'Awal' }}
                sampai
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') : 'Akhir' }}
            </p>
        @endif
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Pemasukan</strong></td>
                <td>Rp{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Pengeluaran</strong></td>
                <td>Rp{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Saldo</strong></td>
                <td>Rp{{ number_format($balance ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Nominal</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($transaction->transaction_date)->format('d-m-Y') }}</td>
                    <td>{{ $transaction->title }}</td>
                    <td>{{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $transaction->category)) }}</td>
                    <td class="text-right">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->creator->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">
                        Tidak ada data laporan keuangan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function () {
            // Kalau mau otomatis buka dialog print, aktifkan baris di bawah:
            // window.print();
        }
    </script>
</body>
</html>