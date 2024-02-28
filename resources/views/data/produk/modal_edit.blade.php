<div class="modal  fade" id="modaldemo8{{ $dt->id }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Form Update Data Produk</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('data_produk.update',$dt->id) }}" method="post" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <p class="mg-b-20">Harap untuk di isi semua!!</p>
                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Nama Produk</label>
                        </div>
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input class="form-control" placeholder="Enter your Nama Produk" name="nama_produk" value="{{ $dt->nama_produk }}" type="text">
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Harga</label>
                        </div>
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input class="form-control" placeholder="Enter your Harga Produk" name="harga" value="{{ $dt->harga }}" type="text">
                        
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Stok Produk</label>
                        </div>
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input class="form-control" placeholder="Enter your Stok Produk" type="number" name="stok" value="{{ $dt->stok }}">
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Foto Produk</label>
                        </div>
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input type="file" name="foto_produk" class="form-control" id="">
                            {{-- <input type="file" class="dropify" data-height="200" name="foto_produk"> --}}
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Foto Sebelumnya</label>
                        </div>
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <img width="100px" height="60px" class="rounded-5" src="@if($dt->foto_produk) {{asset('')}}image/foto_produk/{{$dt->foto_produk}} @else {{asset('')}}image/foto_kosong/no-image.png @endif" style="object-fit:cover"> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>