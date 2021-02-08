@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Selamat Datang Di Aplikasi HRIS')
@section('content-subtitle', '(Human Resource Information System)')
@section('content')
    <div class="row mt-10">
        <div class="col-md-4">
            <div class="panel panel-warning panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-checked-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-remove-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Non-Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-mint panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-clock icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Hadir</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-10">
        <div class="col-md-6">
            <div class="panel media middle pad-all" style="min-height: 340px">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Pengajuan Cuti</h3>
                </div>
                <div class="text-center">
                    <h1 class="h3">Data Tidak Tersedia</h1>
                    <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 230px">
                </div>
                {{-- <div class="table-responsive">
                    <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                    cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting text-center" tabindex="0">No</th>
                                <th class="sorting text-center" tabindex="0">Nama Staff</th>
                                <th class="sorting text-center" tabindex="0">Divisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataJob as $item)
                                <tr>
                                    <td class="sorting text-center" tabindex="0">1</td>
                                    <td class="text-center">Data Entry</td>
                                    <td class="text-center">Dummy</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
        {{-- <div class="col-md-1"></div> --}}
        <div class="col-md-6 panel">
            <div class="panel media middle pad-all" style="min-height: 340px">
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