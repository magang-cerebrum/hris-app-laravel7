@extends('layouts/templateStaff')
@section('title','WFH Anggota Divisi')
@section('content-title','WFH Anggota Divisi')
@section('content-subtitle','HRIS '.$company_name)

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        #btn_paid_leave {
            display: inline;
        }
        #row_btn {
            margin-bottom: 15px;
        }
        @media screen and (max-width: 600px) {
            #btn_paid_leave {
                display: block;
                margin-bottom: 10px;
            }
            #row_btn {
                margin-bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-primary panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Pengajuan WFH Divisi</h3>
        </div>

        <form action="" method="POST" id="form-approve-pending">
            @method('put')
            @csrf
        </form>
        
        <div class="panel-body" style="padding-top: 20px">
            <div class="row" id="row_btn">
                <div id="btn_paid_leave">
                    <a href="{{url('/staff/wfh/division/history')}}" class="btn btn-pink btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Lihat Riwayat Pengajuan WFH">
                        <i class="fa fa-history"></i>
                        Riwayat Pengajuan WFH
                    </a>
                </div>
                @if (count($data) != 0)
                    <div id="btn_paid_leave">
                        <button id="btn-approve" class="btn btn-primary btn-labeled add-tooltip"
                            type="button" data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Terima Pengajuan WFH" onclick="submit_approve()" form="form-approve-pending">
                            <i class="btn-label fa fa-check"></i>
                            Terima WFH Terpilih
                        </button>
                    </div>
                    <div id="btn_paid_leave">
                        <button id="btn-pending" class="btn btn-warning btn-labeled add-tooltip"
                            type="button" data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Pending Pengajuan WFH" onclick="submit_pending()" form="form-approve-pending">
                            <i class="btn-label fa fa-spinner"></i>
                            Pending Data Terpilih
                        </button>
                    </div>
                @endif
            </div>
            <div class="row mar-btn">
                @if (count($data) == 0)
                    <div class="text-center">
                        <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="transaction-wfh-staff" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="dt-basic_info" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                    <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master">
                                    </th>
                                    <th class="sorting text-center" tabindex="0" style="width: 5%">Aksi</th>
                                    <th class="sorting text-center" tabindex="0">Nama Staff</th>
                                    <th class="sorting text-center" tabindex="0">Mulai wfh</th>
                                    <th class="sorting text-center" tabindex="0">Akhir wfh</th>
                                    <th class="sorting text-center" tabindex="0">Jumlah Hari wfh</th>
                                    <th class="sorting text-center" tabindex="0">Keperluan</th>
                                    <th class="sorting text-center" tabindex="0">Keterangan</th>
                                    <th class="sorting text-center" tabindex="0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="sorting text-center" tabindex="0">
                                        <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                                        <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}" form="form-approve-pending"></td>
                                        <td class="text-center">
                                            <span id="reject" data-toggle="modal" data-target="#modal-reject"
                                                style="display: inline; margin: auto 5px" data-id="{{$item->id}}" data-nip="{{$item->user_nip}}"
                                                data-name="{{$item->user_name}}"
                                                data-days="{{$item->days}}" data-datestart="{{$item->wfh_date_start}}"
                                                data-dateend="{{$item->wfh_date_end}}" data-needs="{{$item->needs}}">
                                                <a class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                    data-container="body" data-placement="top" data-original-title="Tolak Pengajuan WFH"
                                                    type="button">
                                                    <i class="fa fa-hand-stop-o"></i>
                                                </a>
                                            </span>
                                        </td>
                                        <td class="text-center">{{$item->user_name}}</td>
                                        <td class="text-center">{{indonesian_date($item->wfh_date_start)}}</td>
                                        <td class="text-center">{{indonesian_date($item->wfh_date_end)}}</td>
                                        <td class="text-center">{{$item->days.' hari'}}</td>
                                        <td class="text-center">{{$item->needs}}</td>
                                        <td class="text-center">{{$item->informations}}</td>
                                        <td class="text-center">{{$item->status}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="margin-top: -50px">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-2">
                            <ul class="pagination">
                                {{ $data->links() }}
                            </ul>
                        </div>
                        <div class="col-sm-5"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('staff/workFromHome/modalDivision')
@endsection
