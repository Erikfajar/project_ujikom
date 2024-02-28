@extends('template.layout_back')<!-- MENGAMBIL TEMPLATE -->

@section('title', 'data detail penjualan')

@section('content')
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div>
                <h4 class="content-title mb-2">Data Detail Penjualan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Data Detail Penjualan</li>
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
                                <p><a href="{{ route('data_penjualan.index') }}" class="btn btn-sm btn-secondary"><< back</a></p>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex my-auto btn-list justify-content-end">
                                    <!--BUTTON EXPORT PDF-->
                                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-sm btn-secondary" data-bs-toggle="dropdown" type="button">Export<i class="fas fa-caret-down ms-1"></i></button>
                                    <div class="dropdown-menu tx-13">
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Pilih Export</h6>
                                        <a class="dropdown-item"   href="javascript:void(0);">PDF</a>
                                        <a class="dropdown-item"   href="javascript:void(0);">Excel</a>
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
                                        <th style="text-align: center" class="border-bottom-0">Nama Pelanggan</th>
                                        <th style="text-align: center" class="border-bottom-0">Produk</th>
                                        <th style="text-align: center" class="border-bottom-0">Jumlah Produk</th>
                                        <th style="text-align: center" class="border-bottom-0">Sub Total</th>
                                        <th style="text-align: center" class="border-bottom-0">Action</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailPenjualan as $dt)
                                        <tr>
                                            <td style="text-align: center">{{ $loop->iteration }}</td>
                                            <td style="text-align: center">{{ $dt->penjualan->pelanggan->nama_pelanggan }}</td>
                                            <td style="text-align: center">{{ $dt->produk->nama_produk }}</td>
                                            <td style="text-align: center">{{ $dt->jumlah_produk }}</td>
                                            <td style="text-align: center">{{ $dt->formatRupiah('sub_total') }}</td>
                                            <td style="text-align: center">
                                                @if ($dt->penjualan->status_pembelian == 'belum')
                                                     <!--BUTTON EDIT -->
                                                <a href="{{ route('detail_penjualan.edit',$dt->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"
                                                    data-bs-toggle="tooltip" title="Update"></i></a>
                                                  <!-- BUTTON DELETE -->
                                                  <form action="{{ route('detail_penjualan.destroy', $dt->id) }}" onsubmit="return confirm('yakin mau hapus data?')" method="post"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                            class="fa fa-trash" data-bs-toggle="tooltip"
                                                            title="Delete"></i></button>
                                                </form>
                                                @else
                                                <h4>-</h4>
                                                @endif
                                            </td>
                                          
                                        </tr>
                                        {{-- @include('data.detail_penjualan.modal_edit') --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
           $(function() {
            // SCRIPT UNTUK MENGGUNAKAN SELECT 2
            $('.select2').select2({
                width: 'resolve'
            });
        });
    </script>

@endsection
