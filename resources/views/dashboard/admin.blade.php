@extends('layouts/templateAdmin')
@section('title', 'Dashboard Admin')
@section('content-title', 'Selamat Datang Di Aplikasi HRIS')
@section('content-subtitle', '(Human Resource Information System)')
@section('head')
    <link href="{{asset("css/slider/slide.css")}}" rel="stylesheet">
@endsection
@section('content')
    @if (count($data_poster) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-carousel">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach ($data_poster as $item_poster)   
                                <li data-target="#myCarousel" data-slide-to="{{$loop->iteration}}" class="{{$loop->iteration  == 1 ? "active" : ""}}"></li>
                            @endforeach
                        </ol>
            
                        <!-- deklarasi carousel -->
                        <div class="carousel-inner" role="listbox">
                            @foreach ($data_poster as $item_poster)
                                <div class="item {{$loop->iteration  == 1 ? "active" : ""}}">
                                    <img src="{{ asset('img/poster/'.$item_poster->file)}}" alt="{{$item_poster->name}}">
                                </div>
                            @endforeach
                        </div>
            
                        <!-- membuat panah next dan previous -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row mt-10">
        <div class="col-md-4">
            <div class="panel panel-warning panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-checked-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_user_active)}}</p>
                    <p class="mar-no">Staff Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-remove-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_user_non_active)}}</p>
                    <p class="mar-no">Staff Non-Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-mint panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-inbox-into icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_ticket)}}</p>
                    <p class="mar-no">Ticket Belum Selesai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-10">
        <div class="col-md-6">
            <div class="panel media middle pad-all" style="min-height: 365px">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Pengajuan Cuti</h3>
                </div>
                @if (count($data_paid_leave) == 0)
                    <div class="text-center">
                        <h1 class="h3">Data Tidak Tersedia</h1>
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 230px">
                    </div>
                    @else
                        <div class="table-responsive">
                            <table id="masterdata-division"
                            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                            cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-center" tabindex="0">No</th>
                                        <th class="sorting text-center" tabindex="0">NIP</th>
                                        <th class="sorting text-center" tabindex="0">Nama</th>
                                        <th class="sorting text-center" tabindex="0">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_paid_leave as $item)
                                        <tr>
                                            <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$item->user_nip}}</td>
                                            <td class="text-center">{{$item->user_name}}</td>
                                            <td class="text-center">{{$item->needs}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <a href="{{url('/admin/paid-leave')}}" class="btn btn-primary btn-labeled"
                                            style="margin: 15px 0">
                                            Detail
                                    </a>
                                </div>
                                <div class="col-sm-5"></div>
                            </div>
                        </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel media middle pad-all" style="min-height: 365px">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Rekruitasi</h3>
                </div>
                @if (count($data_recruitment) == 0)
                    <div class="text-center">
                        <h1 class="h3">Data Tidak Tersedia</h1>
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 230px">
                    </div>
                    @else
                        <div class="table-responsive">
                            <table id="masterdata-division"
                            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                            cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-center" tabindex="0">No</th>
                                        <th class="sorting text-center" tabindex="0">Nama Lengkap</th>
                                        <th class="sorting text-center" tabindex="0">Pendidikan Terakhir</th>
                                        <th class="sorting text-center" tabindex="0">Posisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_recruitment as $item)
                                        <tr>
                                            <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$item->name}}</td>
                                            <td class="text-center">{{$item->last_education}}</td>
                                            <td class="text-center">{{$item->position}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <a href="{{url('/admin/recruitment')}}" class="btn btn-primary btn-labeled"
                                            style="margin: 15px 0">
                                            Detail
                                    </a>
                                </div>
                                <div class="col-sm-5"></div>
                            </div>
                        </div>
                @endif                
            </div>
        </div>
    </div>
@endsection
