@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Master Data / Data Staff')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .icon-dropdown{
            margin-right: 4px;
            text-align: center;
            width: 18px !important;
        }
        .table > tbody > tr > td,
        .table > tbody > tr > th, 
        .table > tfoot > tr > td, 
        .table > tfoot > tr > th, 
        .table > thead > tr > td, 
        .table > thead > tr > th{
            vertical-align:middle;
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
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Data Staff</h3>
        </div>

        <form action="{{url('/admin/data-staff/search')}}" method="get" id="search"></form>
        <form action="/admin/data-staff" method="POST" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-8">
                    <a href="{{url('/admin/data-staff/add')}}" class="btn btn-primary btn-labeled" id="btn_mar">
                        <i class="btn-label fa fa-user-plus"></i>
                        Tambah Data Staff
                    </a>
                    <button id="btn-delete btn_mar" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Hapus Data" onclick="submit_delete()" form="form-mul-delete">
                        <i class="btn-label fa fa-trash"></i>
                        Hapus Data Terpilih
                    </button>
                    @error('selectid') <span style="display:inline;" class="text-danger invalid-feedback mt-3">
                        Maaf, tidak ada data terpilih untuk dihapus.</span> @enderror
                    <div class="radio mar-hor"  id="radio-btn">
                        <label for="" id="label_radio">Tipe Staff: </label>
                        <input id="toogle-nonaktif-radio-1" class="magic-radio" type="radio" name="lihat_selesai"
                            value="On" onclick="toogle_nonaktif()" form="form-mul-delete">
                        <label for="toogle-nonaktif-radio-1">Non-Aktif</label>
                        <input id="toogle-nonaktif-radio-2" class="magic-radio" type="radio" name="lihat_selesai"
                            value="Off" checked onclick="toogle_nonaktif()" form="form-mul-delete">
                        <label for="toogle-nonaktif-radio-2">Aktif</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="query" placeholder="Cari Staff (NIP, Nama, Divisi)" class="form-control" autocomplete="off" form="search">
                        <span class="input-group-btn">
                            <button class="btn btn-mint" type="submit" form="search"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-staff-active"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                style="width: 5%;">No</th>
                            <th class="text-center" style="width: 6%;">
                                All <input type="checkbox" id="check-all-active">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Action" style="width: 15%;">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam masuk: activate to sort column ascending">NIP</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam Kerja: activate to sort column ascending">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aktif as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item-active @error('selectid_active') is-invalid @enderror"
                                        name="selectid_active[]" value="{{$row->id}}" form="form-mul-delete">
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn btn-dark btn-active-primary dropdown-toggle" data-toggle="dropdown" type="button">
                                                Aksi <i class="dropdown-caret"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff" style="cursor: pointer"
                                                        data-nip="{{$row->nip}}" data-name="{{$row->name}}"
                                                        data-dob="{{$row->dob}}" data-address="{{$row->address}}"
                                                        data-phone_number="{{$row->phone_number}}" data-gender="{{$row->gender}}"
                                                        data-email="{{$row->email}}" data-profile_photo="{{$row->profile_photo}}"
                                                        data-employee_status="{{$row->employee_status}}"
                                                        data-employee_type="{{$row->employee_type}}" data-status="{{$row->status}}"
                                                        data-contract_duration="{{$row->contract_duration}}"
                                                        data-start_work_date="{{$row->start_work_date}}"
                                                        data-end_work_date="{{$row->end_work_date}}"
                                                        data-yearly_leave_remaining="{{$row->yearly_leave_remaining}}"
                                                        data-division_name="{{$row->division_name}}"
                                                        data-position_name="{{$row->position_name}}"
                                                        data-role_name="{{$row->role_name}}"
                                                        data-cc_number="{{$row->credit_card_number}}"
                                                        data-salary="{{$row->salary}}"
                                                        data-ktp_number="{{$row->identity_card_number}}"
                                                        data-kk_number="{{$row->family_card_number}}"
                                                        data-npwp_number="{{$row->npwp_number}}"
                                                        data-bpjskes_number="{{$row->bpjs_healthcare_number}}"
                                                        data-bpjsket_number="{{$row->bpjs_employment_number}}">
                                                        <i class="fa fa-info icon-dropdown"></i> Detail Staff
                                                    </a>
                                                </li>
                                                <li><a href="/admin/data-staff/{{$row->id}}/edit" style="cursor: pointer"> 
                                                    <i class="fa fa-pencil-square icon-dropdown"></i> Edit Staff 
                                                </a></li>
                                                <li><a onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}')" style="cursor: pointer">
                                                    <i class="pli-close icon-dropdown"></i> Nonaktifkan Staff
                                                </a></li>
                                                <li><a onclick="reset_pass({{$row->id}},'{{$row->name}}')" style="cursor: pointer">
                                                    <i class="fa fa-unlock-alt icon-dropdown"></i> Reset Password Staff
                                                </a></li>
                                                <li>
                                                    @if ($row->employee_status == 'Tetap')
                                                        <a onclick="salary_increase({{$row->id}},'{{$row->name}}','{{$row->employee_status}}')" style="cursor: pointer">
                                                            <i class="pli-money-2 icon-dropdown"></i> Naikan Gaji Staff
                                                        </a>
                                                    @else
                                                        <a onclick="promote({{$row->id}},'{{$row->name}}','{{$row->employee_status}}')" style="cursor: pointer">
                                                            <i class="psi-arrow-up-2 icon-dropdown"></i> Promosikan Staff
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{$row->nip}}</td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center">{{$row->division_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table id="masterdata-staff"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                style="width: 5%;">No</th>
                            <th class="text-center" style="width: 6%;">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Action" style="width: 15%;">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam masuk: activate to sort column ascending">NIP</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam Kerja: activate to sort column ascending">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($naktif as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item @error('selectid') is-invalid @enderror"
                                        name="selectid[]" value="{{$row->id}}" form="form-mul-delete">
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn btn-dark btn-active-primary dropdown-toggle" data-toggle="dropdown" type="button">
                                                Aksi <i class="dropdown-caret"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff" style="cursor: pointer"
                                                        data-nip="{{$row->nip}}" data-name="{{$row->name}}"
                                                        data-dob="{{$row->dob}}" data-address="{{$row->address}}"
                                                        data-phone_number="{{$row->phone_number}}" data-gender="{{$row->gender}}"
                                                        data-email="{{$row->email}}" data-profile_photo="{{$row->profile_photo}}"
                                                        data-employee_status="{{$row->employee_status}}"
                                                        data-employee_type="{{$row->employee_type}}" data-status="{{$row->status}}"
                                                        data-contract_duration="{{$row->contract_duration}}"
                                                        data-start_work_date="{{$row->start_work_date}}"
                                                        data-end_work_date="{{$row->end_work_date}}"
                                                        data-yearly_leave_remaining="{{$row->yearly_leave_remaining}}"
                                                        data-division_name="{{$row->division_name}}"
                                                        data-position_name="{{$row->position_name}}"
                                                        data-role_name="{{$row->role_name}}"
                                                        data-cc_number="{{$row->credit_card_number}}"
                                                        data-salary="{{$row->salary}}"
                                                        data-ktp_number="{{$row->identity_card_number}}"
                                                        data-kk_number="{{$row->family_card_number}}"
                                                        data-npwp_number="{{$row->npwp_number}}"
                                                        data-bpjskes_number="{{$row->bpjs_healthcare_number}}"
                                                        data-bpjsket_number="{{$row->bpjs_employment_number}}">
                                                        <i class="fa fa-info icon-dropdown"></i> Detail Staff
                                                    </a>
                                                </li>
                                                <li><a href="/admin/data-staff/{{$row->id}}/edit" style="cursor: pointer"> 
                                                    <i class="fa fa-pencil-square icon-dropdown"></i> Edit Staff 
                                                </a></li>
                                                <li><a onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}')" style="cursor: pointer">
                                                    <i class="pli-yes icon-dropdown"></i> Aktifkan Staff
                                                </a></li>
                                                <li><a onclick="reset_pass({{$row->id}},'{{$row->name}}')" style="cursor: pointer">
                                                    <i class="fa fa-unlock-alt icon-dropdown"></i> Reset Password Staff
                                                </a></li>
                                                <li>
                                                    @if ($row->employee_status == 'Tetap')
                                                        <a onclick="salary_increase({{$row->id}},'{{$row->name}}','{{$row->employee_status}}')" style="cursor: pointer">
                                                            <i class="pli-money-2 icon-dropdown"></i> Naikan Gaji Staff
                                                        </a>
                                                    @else
                                                        <a onclick="promote({{$row->id}},'{{$row->name}}','{{$row->employee_status}}')" style="cursor: pointer">
                                                            <i class="psi-arrow-up-2 icon-dropdown"></i> Promosikan Staff
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{$row->nip}}</td>
                                <td class="text-center">{{$row->name}}
                                    <div class="label label-danger">Non-Aktif</div>
                                </td>
                                <td class="text-center">{{$row->division_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <span class="text-muted" id="count-active">Jumlah Staff Aktif dalam pencarian ({{$search}}) : {{count($aktif)}}</span>
            <div id="active-pagination" class="text-center">{{ $aktif->withQueryString()->links() }}</div>
            <span class="text-muted" id="count-all">Jumlah Staff Tidak Aktif dalam pencarian ({{$search}}) : {{count($naktif)}}</span>
            <div id="nactive-pagination" class="text-center">{{ $naktif->withQueryString()->links() }}</div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/data-staff')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Staff</a>
                </div>
            </div>
        </div>
    </div>

    @include('masterData/datastaff/detail')

@endsection
