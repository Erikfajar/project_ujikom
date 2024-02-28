@extends('template.layout_back')<!-- MENGAMBIL TEMPLATE -->

@section('title', 'dashboard')

@section('content')
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div>
                <h4 class="content-title mb-2">Hi, welcome back <u>{{ Auth::user()->username }}</u></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page"> Data Tables</li> --}}
                    </ol>
                </nav>
            </div>
        </div>


        <div class="row row-sm">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card overflow-hidden project-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                <div class="me-4 ht-60 wd-60 my-auto danger">
                                    <img src="{{ asset('') }}image/svg/akun.svg" width="100px" height="100px"
                                        class="ht-40 wd-60">
                                </div>

                            </div>
                            <div class="project-content">
                                <h6>data Pelanggan</h6>
                                <ul>
                                    <li>
                                        <strong>total</strong>
                                        <span>{{ $dtPelanggan }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card  overflow-hidden project-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                <div class="me-4 ht-60 wd-60 my-auto primary">
                                    <img src="{{ asset('') }}image/svg/box.svg" width="100px" height="100px"
                                        class="ht-40 wd-60">
                                </div>
                            </div>
                            <div class="project-content">
                                <h6>data Produk</h6>
                                <ul>
                                    <li>
                                        <strong>total</strong>
                                        <span>{{ $dtProduk }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card overflow-hidden project-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                <div class="me-4 ht-60 wd-60 my-auto success">
                                    <img src="{{ asset('') }}image/svg/calon.svg" width="100px" height="100px"
                                        class="ht-40 wd-60">
                                </div>
                            </div>
                            <div class="project-content">
                                <h6>data Penjualan</h6>
                                <ul>
                                    <li>
                                        <strong>total</strong>
                                        <span>{{ $dtPenjualan }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card overflow-hidden project-card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                <svg enable-background="new 0 0 512 512" class="me-4 ht-60 wd-60 my-auto warning"
                                    version="1.1" viewBox="0 0 512 512" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m259.2 317.72h-6.398c-8.174 0-14.824-6.65-14.824-14.824 1e-3 -8.172 6.65-14.822 14.824-14.822h6.398c8.174 0 14.825 6.65 14.825 14.824h29.776c0-20.548-13.972-37.885-32.911-43.035v-33.74h-29.777v33.739c-18.94 5.15-32.911 22.487-32.911 43.036 0 24.593 20.007 44.601 44.601 44.601h6.398c8.174 0 14.825 6.65 14.825 14.824s-6.65 14.824-14.825 14.824h-6.398c-8.174 0-14.824-6.65-14.824-14.824h-29.777c0 20.548 13.972 37.885 32.911 43.036v33.739h29.777v-33.74c18.94-5.15 32.911-22.487 32.911-43.035 0-24.594-20.008-44.603-44.601-44.603z" />
                                    <path
                                        d="m502.7 432.52c-7.232-60.067-26.092-111.6-57.66-157.56-27.316-39.764-65.182-76.476-115.59-112.06v-46.29l37.89-98.425-21.667-0.017c-6.068-4e-3 -8.259-1.601-13.059-5.101-6.255-4.559-14.821-10.802-30.576-10.814h-0.046c-15.726 0-24.292 6.222-30.546 10.767-4.799 3.487-6.994 5.081-13.041 5.081h-0.027c-6.07-5e-3 -8.261-1.602-13.063-5.101-6.255-4.559-14.821-10.801-30.577-10.814h-0.047c-15.725 0-24.293 6.222-30.548 10.766-4.8 3.487-6.995 5.081-13.044 5.081h-0.027l-21.484-0.017 36.932 98.721v46.117c-51.158 36.047-89.636 72.709-117.47 111.92-33.021 46.517-52.561 98.116-59.74 157.74l-9.304 77.285h512l-9.304-77.284zm-301.06-395.47c4.8-3.487 6.995-5.081 13.045-5.081h0.026c6.07 4e-3 8.261 1.602 13.062 5.101 6.255 4.559 14.821 10.802 30.578 10.814h0.047c15.725 0 24.292-6.222 30.546-10.767 4.799-3.487 6.993-5.081 13.041-5.081h0.026c6.068 5e-3 8.259 1.602 13.059 5.101 2.869 2.09 6.223 4.536 10.535 6.572l-21.349 55.455h-92.526l-20.762-55.5c4.376-2.041 7.773-4.508 10.672-6.614zm98.029 91.89v26.799h-83.375v-26.799h83.375zm-266.09 351.08 5.292-43.947c6.571-54.574 24.383-101.7 54.458-144.07 26.645-37.537 62.54-71.458 112.73-106.5h103.78c101.84 71.198 150.75 146.35 163.29 250.56l5.291 43.948h-444.85z" />
                                </svg>
                            </div>
                            <div class="project-content">
                                <h6>data Keuangan</h6>
                                <ul>
                                    <li>
                                        <strong>total</strong>
                                        <span>{{ $dtKeuangan }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role == 'administrator')
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header pt-4 pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-10 ">data akun User</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 text-muted mb-0"> Berikut adalah data semua akun user yang telah di buat <a
                                href="{{ route('data_user.index') }}">Lihat data</a> </p>
                    </div>
                    <div class="p-4">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="task-box primary mb-0">
                                        <p class="mb-0 tx-12">Administrator</p>
                                        <h3 class="mb-0">{{ $dtUserAdmin }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="task-box danger  mb-0">
                                        <p class="mb-0 tx-12">Petugas</p>
                                        <h3 class="mb-0">{{ $dtUserPetugas }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="task-stat pb-0">
                        <p style="margin-left: 3em">data terakhir registrasi akun</p>
                        @foreach ($dtTerakhirUser as $item)
                            <div class="d-flex tasks">
                                <div class="mb-0">
                                    <div class="h6 fs-15 mb-0"><i
                                            class="far fa-dot-circle text-primary me-2"></i>{{ $item->username }}</div>
                                    <span class="text-muted tx-11 ms-4">{{ $item->created_at }}</span>
                                </div>
                                <span class="float-end ms-auto">{{ $item->role }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="row row-sm">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="card overflow-hidden">
                    <div class="card-body pd-y-7 pt-3">
                        <div id="grafik_pelanggan_perbulan" style="width:100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="card overflow-hidden">
                    <div class="card-body pd-y-7 pt-3">
                        <div id="grafik_produk_perbulan" style="width:100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card overflow-hidden">
                    <div class="card-body pd-y-7 pt-3">
                        <div id="grafik_penjualan_perbulan" style="width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- SCRIPT UNTUK GRAFIK -->

    <script>
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });

        //GRAFIK BARU
        Highcharts.chart('grafik_pelanggan_perbulan', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik data Pelanggan'
            },
            subtitle: {
                text: 'grafik data input Pelanggan per bulan'
            },
            xAxis: {
                // type: 'category',
                // labels: {
                //     autoRotation: [-45, -90],
                //     style: {
                //         fontSize: '13px',
                //         fontFamily: 'Verdana, sans-serif'
                //     }
                // }
                type: 'category',
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    autoRotation: [-45, -90],
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'pelanggan'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Jumlah data : <b>{point.y:.1f} pelanggan</b>'
            },
            series: [{
                name: 'Population',
                colors: [
                    '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
                    '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',

                ],
                colorByPoint: true,
                groupPadding: 0,
                data: [
                    {!! $dataGrafikA !!}
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });

        // GRAFIK DATA PRODUK PERBULAN
        Highcharts.chart('grafik_produk_perbulan', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Grafik Jumlah Data Produk Per Bulan'
            },
            subtitle: {
                text: 'Tahun {{ date('Y') }}'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Jumlah Produk'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'data buku',
                data: [{!! $dataGrafikB !!}]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });

        // GRAFIK PENJUALAN
        Highcharts.chart('grafik_penjualan_perbulan', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Grafik Jumlah Data Penjualan Per Bulan'
            },
            subtitle: {
                text: 'Tahun {{ date('Y') }}'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Jumlah Penjualan'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'data buku',
                data: [{!! $dataGrafikC !!}]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>
@endsection
