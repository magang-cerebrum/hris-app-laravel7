@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Grafik Nilai')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <style>
        #charts-achievement {
            width: 870px;
            height: 450px;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Staff</h3>
        </div>

        <form action="{{url('/admin/achievement/searchlist')}}" method="get" id="search"></form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-8"></div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="query" placeholder="Cari Staff" class="form-control" form="search"
                            autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-mint" type="submit" form="search"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-chart-staff"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending" style="width: 5%">No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending"
                                style="width: 5%">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Staff</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{($staff->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                <td class="text-center">
                                    <span id="detail_staff_chart" data-toggle="modal"
                                        data-target="#modal-detail-staff-chart"
                                        style="display: inline; margin: auto 5px" data-name="{{$row->name}}"
                                        data-userid="{{$row->id}}">
                                        <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top"
                                            data-original-title="Detail Staff Chart" type="button">
                                            <i class="fa fa-bar-chart"></i>
                                        </a>
                                    </span>
                                </td>
                                <td class="text-center">{{$row->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">{{ $staff->withQueryString()->links() }}</div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/achievement/charts')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Staff</a>
                </div>
            </div>
        </div>
    </div>
    @include('masterdata/achievement/chartmodal')
@endsection
