<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
            color: #333;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .status-aktif {
            color: #856404;
            background-color: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .status-kembali {
            color: #155724;
            background-color: #d4edda;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PEMINJAMAN BARANG</h1>
        <p>Generated on: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total Transaksi: {{ $transaksis->count() }}</p>
        @if(request('tanggal_dari') || request('tanggal_sampai'))
            <div class="date-range">
                Periode: 
                @if(request('tanggal_dari') && request('tanggal_sampai'))
                    {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d/m/Y') }}
                @elseif(request('tanggal_dari'))
                    Dari {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d/m/Y') }}
                @elseif(request('tanggal_sampai'))
                    Sampai {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d/m/Y') }}
                @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Kode Barang</th>
                <th style="width: 20%">Nama Peminjam</th>
                <th style="width: 18%">Waktu Pinjam</th>
                <th style="width: 18%">Waktu Kembali</th>
                <th style="width: 12%">Status</th>
                <th style="width: 12%">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaksi->kode_barang }}</td>
                <td>{{ $transaksi->nama_peminjam }}</td>
                <td>{{ $transaksi->waktu_pinjam->format('d/m/Y H:i') }}</td>
                <td>
                    @if($transaksi->waktu_kembali)
                        {{ $transaksi->waktu_kembali->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($transaksi->status == 'aktif')
                        <span class="status-aktif">Aktif</span>
                    @else
                        <span class="status-kembali">Kembali</span>
                    @endif
                </td>
                <td>
                    @if($transaksi->waktu_kembali)
                        {{ $transaksi->waktu_pinjam->diffInMinutes($transaksi->waktu_kembali) }} menit
                    @else
                        {{ $transaksi->waktu_pinjam->diffForHumans() }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistem Peminjaman Barang - Laravel {{ app()->version() }}</p>
    </div>
</body>
</html>