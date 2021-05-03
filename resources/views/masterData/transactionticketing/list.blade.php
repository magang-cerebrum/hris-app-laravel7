@extends('layouts/templateAdmin')
@section('title','Sistem')
@section('content-title','Sistem / Ticketing')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            #option_tabel {
                margin-top: 10px;
                margin-bottom: 10px; 
            }
            #option_label {
                padding: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Ticketing</h3>
        </div>
        
        <form action="{{url('/admin/ticketing/search')}}" method="get" id="form_search"></form>
        <form action="/admin/ticketing/on-progress" method="POST" id="form-mul-onprog">
            @csrf
            @method('put')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-2">
                    <button id="btn-onprog" class="btn btn-primary  btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Jadikan On Progress" onclick="submit_on_progress()" form="form-mul-onprog">
                        <i class="btn-label fa fa-spinner"></i>
                        Jadikan On Progress
                    </button>
                </div>
                <div class="col-sm-6" id="option_tabel">
                    <div class="radio mar-hor">
                        <div class="col-sm-3">
                            <label for="" id="option_label">Tabel Tiketing: </label>
                        </div>
                        <div class="col-sm-3">
                            <input id="lihat_selesai_radio-1" class="magic-radio toogle_selesai" type="radio" name="lihat_selesai" form="form-mul-onprog"
                            value="On">
                            <label for="lihat_selesai_radio-1">Titeking Selesai</label>
                        </div>
                        <div class="col-sm-4">
                            <input id="lihat_selesai_radio-2" class="magic-radio toogle_selesai" type="radio" name="lihat_selesai" form="form-mul-onprog"
                            value="Off">
                            <label for="lihat_selesai_radio-2">Titeking Proses</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" form="form_search"
                                placeholder="Cari Ticket (Tanggal / Kategori / Status / Nama Pengirim)"
                                class="form-control" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="submit" id="btn-search" form="form_search"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mar-btm">
                <div class="table-responsive">
                    <table id="masterdata-ticketing-full"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 5%">No
                                </th>
                                <th class="text-center" style="width: 6%">
                                    All <input type="checkbox" id="check-all-full">
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">
                                    Aksi</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Nama Pengirim</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Kategori</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Status</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Diajukan pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($done as $row)
                                <tr>
                                    <td tabindex="0" class="sorting_1 text-center">
                                        {{($done->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="check-item-full" name="selectid_full[]"
                                            value="{{$row->id}}" form="form-mul-onprog">
                                    </td>
                                    <td class="text-center">
                                        <span id="detail_ticket" data-toggle="modal" data-target="#modal-detail-ticket"
                                            style="display: inline; margin: auto 5px" data-id="{{$row->id}}" 
                                            @if ($row->name == null)
                                                data-name="Anonim"
                                            @else
                                                data-name="{{$row->name}}"
                                            @endif
                                            data-category="{{$row->category}}"
                                            data-message="{{$row->message}}" data-response="{{$row->response}}"
                                            data-status="{{$row->status}}"
                                            data-diajukan="{{indonesian_date($row->created_at,true)}}"
                                            @if ($row->created_at == $row->updated_at)
                                                data-direspon="-"
                                            @else
                                                data-direspon="{{indonesian_date($row->updated_at,true)}}"
                                            @endif
                                            >
                                            <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                data-container="body" data-placement="top" data-original-title="Detail Ticket"
                                                type="button">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($row->name == null)
                                            Anonim
                                        @else
                                            {{$row->name}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->category == 'Keluhan')
                                            <span class="label label-primary">Keluhan</span>
                                        @elseif ($row->category == 'Masukan')
                                            <span class="label label-warning">Masukan</span>
                                        @elseif ($row->category == 'Bug Aplikasi')
                                            <span class="label label-danger">Bug Aplikasi</span>
                                        @elseif ($row->category == 'Kesalahan Informasi')
                                            <span class="label label-info">Kesalahan Informasi</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->status == 'Dikirimkan')
                                            <span class="label label-primary">Dikirimkan</span>
                                        @elseif ($row->status == 'On Progress')
                                            <span class="label label-warning">On Progress</span>
                                        @elseif ($row->status == 'Selesai')
                                            <span class="label label-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{indonesian_date($row->created_at,true)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="done-pagination" class="text-center">{{ $done->links() }}</div>
                    <table id="masterdata-ticketing"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 5%">No
                                </th>
                                <th class="text-center" style="width: 6%">
                                    All <input type="checkbox" id="check-all">
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">
                                    Aksi</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Nama Pengirim</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Kategori</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Status</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Diajukan pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticketing as $row)
                                <tr>
                                    <td tabindex="0" class="sorting_1 text-center">
                                        {{($ticketing->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                                    </td>
                                    <td class="text-center">
                                        <span id="detail_ticket" data-toggle="modal" data-target="#modal-detail-ticket"
                                            style="display: inline; margin: auto 5px" data-id="{{$row->id}}" 
                                            @if ($row->name == null)
                                                data-name="Anonim"
                                            @else
                                                data-name="{{$row->name}}"
                                            @endif
                                            data-category="{{$row->category}}" data-message="{{$row->message}}" data-response="{{$row->response}}"
                                            data-status="{{$row->status}}" data-diajukan="{{indonesian_date($row->created_at,true)}}"
                                            @if ($row->created_at == $row->updated_at)
                                                data-direspon="-"
                                            @else
                                                data-direspon="{{indonesian_date($row->updated_at,true)}}"
                                            @endif
                                            >
                                            <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                data-container="body" data-placement="top" data-original-title="Detail Ticket"
                                                type="button">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($row->name == null)
                                            Anonim
                                        @else
                                            {{$row->name}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->category == 'Keluhan')
                                            <span class="label label-primary">Keluhan</span>
                                        @elseif ($row->category == 'Masukan')
                                            <span class="label label-warning">Masukan</span>
                                        @elseif ($row->category == 'Bug Aplikasi')
                                            <span class="label label-danger">Bug Aplikasi</span>
                                        @elseif ($row->category == 'Kesalahan Informasi')
                                            <span class="label label-info">Kesalahan Informasi</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->status == 'Dikirimkan')
                                            <span class="label label-primary">Dikirimkan</span>
                                        @elseif ($row->status == 'On Progress')
                                            <span class="label label-warning">On Progress</span>
                                        @elseif ($row->status == 'Selesai')
                                            <span class="label label-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{indonesian_date($row->created_at,true)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="onprog-pagination" class="text-center">{{ $ticketing->links() }}</div>
            </div>
        </div>
    </div>
    @include('masterdata/transactionticketing/detail')
@endsection

