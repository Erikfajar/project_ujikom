@if(session()->has('success')) <!-- ALERT UNTUK SUCCESS -->
<div class="alert alert-success" role="alert">
    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!!session('success')!!}</strong>
</div>
@endif
@if(session()->has('info')) <!-- ALERT UNTUK INFO/PEMBERITAHUAN -->
<div class="alert alert-info" role="alert">
    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!!session('info')!!}</strong>
</div>
@endif
@if(session()->has('failed')) <!-- ALERT UNTUK GAGAL/FAILED -->
<div class="alert alert-warning" role="alert">
    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!!session('failed')!!}</strong>
</div>
@endif
@if(session()->has('error')) <!-- ALERT UNTUK ERROR -->
<div class="alert alert-danger mg-b-0" role="alert">
    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!!session('error')!!}</strong>
</div>
@endif
@if ($errors->any()) <!-- ALERT UNTUK MENAMPILKAN ERROR DI VALIDASI -->
    <div class="pt-3">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif