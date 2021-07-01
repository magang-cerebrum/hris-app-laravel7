@extends('layouts/templateStaff')
@section('content-title','Data Staff Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Data Staff Divisi')

@section('head')
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .icon-dropdown {
        margin-right: 4px;
        text-align: center;
        width: 18px !important;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        vertical-align: middle;
    }

    #radio-btn {
        display: inline;
    }

    @media screen and (max-width: 600px) {
        #radio-btn {
            display: block;
        }

        #btn_mar {
            margin-bottom: 10px;
        }

        #label_radio {
            padding-left: 0;
        }
    }

</style>
@endsection

@section('content')
<div class="panel panel-primary panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Data Staff</h3>
    </div>
    
    <form action="{{url('/staff/data-staff/search')}}" method="get" id="search"></form>

    <div class="panel-body" style="padding-top: 20px">
        <div class="row mar-btm">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="radio mar-hor"  id="radio-btn">
                    <label for="" id="label_radio">Tipe Staff: </label>
                    <input id="toogle-nonaktif-radio-1" class="magic-radio" type="radio" name="lihat_selesai"
                        value="On" onclick="toogle_nonaktif()">
                    <label for="toogle-nonaktif-radio-1">Non-Aktif</label>
                    <input id="toogle-nonaktif-radio-2" class="magic-radio" type="radio" name="lihat_selesai"
                        value="Off" checked onclick="toogle_nonaktif()">
                    <label for="toogle-nonaktif-radio-2">Aktif</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" name="query" placeholder="Cari Staff (NIP, Nama)" class="form-control" autocomplete="off" form="search">
                    <span class="input-group-btn">
                        <button class="btn btn-mint" type="submit" form="search"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="masterdata-staff-active" class="table table-striped table-bordered" role="grid">
                <thead>
                    <tr role="row">
                        <th class="text-center" style="width: 5%;">No</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aktif as $row)
                    <tr>
                        <td class="text-center">{{($aktif->currentPage() * 10) - 10 + $loop->iteration}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-active-primary dropdown-toggle"
                                        data-toggle="dropdown" type="button">
                                        Aksi <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff"
                                                style="cursor: pointer" data-nip="{{$row->nip}}"
                                                data-name="{{$row->name}}" data-dob="{{$row->dob}}"
                                                data-address="{{$row->address}}"
                                                data-phone_number="{{$row->phone_number}}"
                                                data-gender="{{$row->gender}}" data-email="{{$row->email}}"
                                                data-profile_photo="{{$row->profile_photo}}"
                                                data-employee_status="{{$row->employee_status}}"
                                                data-employee_type="{{$row->employee_type}}"
                                                data-status="{{$row->status}}"
                                                data-contract_duration="{{$row->contract_duration}}"
                                                data-start_work_date="{{$row->start_work_date}}"
                                                data-end_work_date="{{$row->end_work_date}}"
                                                data-yearly_leave_remaining="{{$row->yearly_leave_remaining}}"
                                                data-division_name="{{$row->division_name}}"
                                                data-position_name="{{$row->position_name}}"
                                                data-role_name="{{$row->role_name}}"
                                                data-cc_number="{{$row->credit_card_number}}"
                                                data-salary="{{$row->salary}}">
                                                <i class="fa fa-info icon-dropdown"></i> Detail Staff
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$row->nip}}</td>
                        <td class="text-center">{{$row->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table id="masterdata-staff" class="table table-striped table-bordered" role="grid">
                <thead>
                    <tr role="row">
                        <th class="text-center" style="width: 5%;">No</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($naktif as $row)
                    <tr>
                        <td class="text-center">{{($naktif->currentPage() * 10) - 10 + $loop->iteration}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-active-primary dropdown-toggle"
                                        data-toggle="dropdown" type="button">
                                        Aksi <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff"
                                                style="cursor: pointer" data-nip="{{$row->nip}}"
                                                data-name="{{$row->name}}" data-dob="{{$row->dob}}"
                                                data-address="{{$row->address}}"
                                                data-phone_number="{{$row->phone_number}}"
                                                data-gender="{{$row->gender}}" data-email="{{$row->email}}"
                                                data-profile_photo="{{$row->profile_photo}}"
                                                data-employee_status="{{$row->employee_status}}"
                                                data-employee_type="{{$row->employee_type}}"
                                                data-status="{{$row->status}}"
                                                data-contract_duration="{{$row->contract_duration}}"
                                                data-start_work_date="{{$row->start_work_date}}"
                                                data-end_work_date="{{$row->end_work_date}}"
                                                data-yearly_leave_remaining="{{$row->yearly_leave_remaining}}"
                                                data-division_name="{{$row->division_name}}"
                                                data-position_name="{{$row->position_name}}"
                                                data-role_name="{{$row->role_name}}"
                                                data-cc_number="{{$row->credit_card_number}}"
                                                data-salary="{{$row->salary}}">
                                                <i class="fa fa-info icon-dropdown"></i> Detail Staff
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$row->nip}}</td>
                        <td class="text-center">{{$row->name}}
                            <div class="label label-danger">Non-Aktif</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <span class="text-muted" id="count-active">Jumlah Staff Aktif : {{$count_aktif}}</span>
        <div id="active-pagination" class="text-center">{{ $aktif->links() }}</div>
        <span class="text-muted" id="count-all">Jumlah Staff Tidak Aktif : {{$count_naktif}}</span>
        <div id="nactive-pagination" class="text-center">{{ $naktif->links() }}</div>
    </div>
</div>

@include('staff/datastaff/detail')

@endsection
