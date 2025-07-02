<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Transaksi Peminjaman Barang</h2>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Peminjam</th>
                <th>Waktu Pinjam</th>
                <th>Waktu Kembali</th>
                <th>Status</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->kode_barang }}</td>
                    <td>{{ $transaksi->nama_peminjam }}</td>
                    <td>{{ $transaksi->waktu_pinjam->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($transaksi->waktu_kembali)
                            {{ $transaksi->waktu_kembali->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $transaksi->status }}</td>
                    <td>
                        @if ($transaksi->waktu_kembali)
                            {{ $transaksi->waktu_pinjam->diffForHumans($transaksi->waktu_kembali, true) }}
                        @else
                            {{ $transaksi->waktu_pinjam->diffForHumans() }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>