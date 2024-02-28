@extends('template.layout_back')<!-- MENGAMBIL TEMPLATE -->

@section('title', 'data penjualan')

@section('content')
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div>
                <h4 class="content-title mb-2">Data Penjualan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Data Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- CODE UNTUK TABLE -->
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="pd-t-10 pd-s-10 pd-e-10 bg-white bd-b">
                        <div class="row">
                            <div class="col-md-6">
                                <p>data Penjualan</p>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex my-auto btn-list justify-content-end">
                                    <a href="{{ route('data_penjualan.create') }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-plus"></i> Tambah</a>
                                    <!--BUTTON EXPORT PDF-->
                                    <button aria-expanded="false" aria-haspopup="true"
                                        class="btn ripple btn-sm btn-secondary" data-bs-toggle="dropdown"
                                        type="button">Export<i class="fas fa-caret-down ms-1"></i></button>
                                    <div class="dropdown-menu tx-13">
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Pilih
                                            Export</h6>
                                        <a class="dropdown-item" href="{{ route('data_penjualan.export_pdf') }}">PDF</a>
                                        <a class="dropdown-item" href="{{ route('data_penjualan.export_excel') }}">Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- message info -->
                        @include('components.message') <!-- UNTUK MEMANGGIL MESSAGE -->
                        <hr>
                        <div class="table-responsive">
                            <table id="basic-datatable"
                                class="border-top-0  table table-bordered text-nowrap border-bottom">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" class="border-bottom-0">No</th>
                                        <th style="text-align: center" class="border-bottom-0">Tanggal Penjualan</th>
                                        <th style="text-align: center" class="border-bottom-0">Total Harga</th>
                                        <th style="text-align: center" class="border-bottom-0">Nama Pelanggan</th>
                                        <th style="text-align: center" class="border-bottom-0">Status Pembelian</th>
                                        <th style="text-align: center" class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $dt)
                                        <tr>
                                            <td style="text-align: center">{{ $loop->iteration }}</td>
                                            <td style="text-align: center">{{ $dt->tanggal_penjualan_indo }}</td>
                                            <td style="text-align: center">{{ $dt->formatRupiah('total_harga') }}</td>
                                            <td style="text-align: center">{{ $dt->pelanggan->nama_pelanggan }}</td>
                                            <td style="text-align: center">
                                                @if ($dt->status_pembelian == 'sudah')
                                                    <span class="badge bg-success-gradient">Sudah melakukan transaksi</span>
                                                @else
                                                    <span class="badge bg-danger-gradient">Belum melakukan transaksi</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($dt->status_pembelian == 'belum')
                                                    <!-- BUTTON TRANSAKSI BARANG -->
                                                    <a href="{{ route('pembelian', $dt->id) }}"
                                                        class="btn btn-sm btn-outline-warning"><i
                                                            class="fa fa-shopping-cart" data-bs-toggle="tooltip"
                                                            title="pembelian produk"></i></a>
                                                @endif
                                                <!-- BUTTON DETAIL PENJUALAN -->
                                                <a href="{{ route('detail_penjualan.show', $dt->id) }}"
                                                    class="btn btn-sm btn-outline-primary"><i class="fa fa-tags"
                                                        data-bs-toggle="tooltip" title="Detail Pembelian"></i></a>
                                                <!-- BUTTON TRANSAKSI -->
                                                <form onsubmit="return confirm('Yakin?')"
                                                    action="{{ route('transaksi', $dt->id) }}" class="d-inline"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger"><i
                                                            class="fas fa-dollar-sign" data-bs-toggle="tooltip"
                                                            title="Transaksi"></i></button>
                                                </form>
                                                <!-- BUTTON DELETE -->
                                                <form action="{{ route('data_penjualan.destroy', $dt->id) }}"
                                                    onsubmit="return confirm('yakin mau hapus data?Kalo anda menghapus data ini maka nanti otomatis data yang terkait akan ikut ke hapus')"
                                                    method="post" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                            class="fa fa-trash" data-bs-toggle="tooltip"
                                                            title="Delete"></i></button>

                                                    <!-- BUTTON EDIT -->
                                                    <a href="{{ route('data_penjualan.edit', $dt->id) }}"
                                                        class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"
                                                            data-bs-toggle="tooltip" title="Update"></i></a>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 
    @include('data.penjualan.modal_create') --}}

    <script>
        $(function() {
            // formelement
            $('.select2').select2({
                width: 'resolve'
            });
        });

        function sum() {
            var produk = document.getElementById('produk_id');
            var jumlahProduk = document.getElementById('jumlah_produk').value;

            // Mengambil opsi yang dipilih
            var selectedOption = produk.options[produk.selectedIndex];

            // Mengambil nilai data-harga dari opsi yang dipilih
            var hargaProduk = selectedOption.getAttribute('data-harga');

            var result = parseInt(hargaProduk) * parseInt(jumlahProduk);

            if (!isNaN(result)) {
                document.getElementById('sub_total').value = result;
            }
        }
    </script>
@endsection
