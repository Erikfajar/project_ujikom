<table>
    <thead>
    <tr>
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">No</th> <!-- kolom A -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Username</th> <!-- kolom B -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Email</th> <!-- kolom C -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Nama Lengkap</th> <!-- kolom D -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Role</th> <!-- kolom E -->
        <th style="font-weight:bold;text-align:center;background:#f4f4f4;border:1px solid #000000;">Alamat</th> <!-- kolom F -->
    </tr>
    </thead>
    <tbody>
    @php $no=1; @endphp
    @if(count($data))
    @foreach($data as $dt)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $dt->username ?? '' }}</td>
        <td>{{ $dt->email ?? '' }}</td>
        <td>{{ $dt->nama_lengkap ?? '' }}</td>
        <td>{{ $dt->role ?? '' }}</td>
        <td>{{ $dt->alamat ?? '' }}</td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>