@extends('template.layout_back')<!-- MENGAMBIL TEMPLATE -->

@section('title', 'history aktivitas') <!-- MENGISI TITLE HALAMAN -->

@section('content') <!-- CONTENT -->
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div>
                <h4 class="content-title mb-2">History Aktivitas</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> History Aktivitas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- CODE UNTUK TABLE -->
        <div class="row row-sm">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="pd-t-10 pd-s-10 pd-e-10 bg-white bd-b">
                        <div class="row">
                            <div class="col-md-6">
                                <p>data history</p>
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="d-flex my-auto btn-list justify-content-end">
                                    <!--BUTTON TAMBAH PENGGUNA-->
                                    <a class="modal-effect btn btn-sm btn-primary" data-bs-effect="effect-flip-Vertical"
                                    data-bs-toggle="modal" href="#modaldemo8"><i class="fe fe-package"></i> Tambah</a>
                                    <!--BUTTON EXPORT PDF-->
                                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-sm btn-secondary" data-bs-toggle="dropdown" type="button">Export<i class="fas fa-caret-down ms-1"></i></button>
                                    <div class="dropdown-menu tx-13">
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Pilih Export</h6>
                                        <a class="dropdown-item"   href="{{ route('data_produk.export_pdf') }}">PDF</a>
                                        <a class="dropdown-item"   href="{{ route('data_produk.export_excel') }}">Excel</a>
                                    </div>
                                    <!--BUTTON IMPORT-->
                                    <a class="modal-effect btn btn-sm btn-success" data-bs-effect="effect-flip-Vertical"
                                        data-bs-toggle="modal" href="#modal_import"><i
                                            class="fas fa-cloud-download-alt"></i> Import</a></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- message info -->
                        @include('components.message') <!-- UNTUK MEMANGGIL MESSAGE -->
                        <hr>
                        <div class="table-responsive">
                            <table id="basic-datatable"
                                class="border-top-0  table table-bordered table-striped text-nowrap border-bottom">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" class="border-bottom-0">No</th>
                                        <th style="text-align: center" class="border-bottom-0">User</th>
                                        <th style="text-align: center" class="border-bottom-0">Aktivitas</th>
                                        <th style="text-align: center" class="border-bottom-0">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataHistory as $dt)
                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: center">{{ $dt->user->nama_lengkap }}</td>
                                        <td>{{ $dt->aktivitas }}</td>
                                        <td style="text-align: center">{{ $dt->tanggal_aktivitas_indo }}</td>
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
@endsection
