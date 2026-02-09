<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        /* =========================
           Print Styles
           ========================= */
        @media print {
            /* Hapus margin/header/footer browser */
            @page {
                margin: 10mm; /* bisa sesuaikan */
            }

            body {
                -webkit-print-color-adjust: exact; /* agar warna tabel muncul */
            }

            /* sembunyikan elemen yang tidak ingin dicetak */
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <h2>Laporan Peminjaman<br>Periode: {{ \Carbon\Carbon::parse($from)->format('d-m-Y') }} s/d
        {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->alat->nama }}</td>
                    <td>{{ $item->alat->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $item->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
