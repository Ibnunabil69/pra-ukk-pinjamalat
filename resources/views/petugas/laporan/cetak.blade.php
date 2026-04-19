<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header img {
            height: 70px;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        .info {
            margin-bottom: 10px;
        }

        .info span {
            margin-right: 15px;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
        }

        td {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        td.text-right {
            text-align: right;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 11px;
        }

        /* PRINT */
        @media print {
            @page {
                margin: 10mm;
            }

            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <img src="{{ asset('assets/logo-web.png') }}" alt="Logo">
        <h2>LAPORAN PEMINJAMAN ALAT</h2>
        <p>
            Periode:
            {{ $from ? \Carbon\Carbon::parse($from)->format('d-m-Y') : '-' }}
            s/d
            {{ $to ? \Carbon\Carbon::parse($to)->format('d-m-Y') : '-' }}
        </p>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th class="text-left">Peminjam</th>
                <th class="text-left">Alat</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-left">{{ $item->user->name }}</td>
                    <td class="text-left">{{ $item->alat->nama }}</td>
                    <td>{{ $item->alat->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $item->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                    <td class="text-right">
                        Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Total Data: {{ count($peminjamans) }}</p>
        <p>
            Total Denda:
            Rp {{ number_format($peminjamans->sum('denda'), 0, ',', '.') }}
        </p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
