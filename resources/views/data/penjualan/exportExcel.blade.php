<table>
    <thead>
    <tr>
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">No</th> <!-- kolom A -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Tanggal Penjualan</th> <!-- kolom B -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Total Harga</th> <!-- kolom C -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Nama Pelanggan</th> <!-- kolom D -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Status Pembelian</th> <!-- kolom E -->
    </tr>
    </thead>
    <tbody>
    @php $no=1; @endphp
    @if(count($data))
    @foreach($data as $dt)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $dt->tanggal_penjualan_indo ?? '' }}</td>
            <td>{{ $dt->total_harga ?? '' }}</td>
            <td>{{ $dt->pelanggan->nama_pelanggan ?? '' }}</td>
            <td>{{ $dt->status_pembelian ?? '' }}</td>
        </tr>
    @endforeach
    @endif
    </tbody>
</table>