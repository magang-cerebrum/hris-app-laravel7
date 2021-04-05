@extends('layouts/templateAdmin')
@section('title','Data Staff')
@section('content-title','Data Staff / Daftar Pengajuan WFH')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Pengajuan WFH Staff</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <a href="{{url('/admin/wfh/history')}}" class="btn btn-pink btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top"
                    data-original-title="Lihat Riwayat Pengajuan WFH" style="margin-bottom: 15px">
                    <i class="fa fa-history"></i>
                    Riwayat Pengajuan
                </a>
                @if (count($data) == 0)
            </div>
        </div>
        <div class="text-center">
            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
        </div>
        @else
        <form action="" method="POST" style="display: inline" id="form-approve-pending">
            @method('put')
            @csrf
            <button id="btn-approve" class="btn btn-primary btn-labeled add-tooltip" style="margin-top: -15px"
                type="button" data-toggle="tooltip" data-container="body" data-placement="top"
                data-original-title="Terima Pengajuan WFH" onclick="submit_approve()">
                <i class="btn-label fa fa-check"></i>
                Terima Data WFH Terpilih
            </button>
            <button id="btn-pending" class="btn btn-warning btn-labeled add-tooltip" style="margin-top: -15px"
                type="button" data-toggle="tooltip" data-container="body" data-placement="top"
                data-original-title="Pending Pengajuan WFH" onclick="submit_pending()">
                <i class="btn-label fa fa-spinner"></i>
                Pending Data WFH Terpilih
            </button>
    </div>
</div>
<div class="table-responsive">
    <table id="transaction-wfh" class="table table-striped table-bordered no-footer dtr-inline collapsed"
        role="grid" style="width: 100%;" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master">
                </th>
                <th class="sorting text-center" tabindex="0" style="width: 5%">Aksi</th>
                <th class="sorting text-center" tabindex="0">NIP</th>
                <th class="sorting text-center" tabindex="0">Nama</th>
                <th class="sorting text-center" tabindex="0">Mulai WFH</th>
                <th class="sorting text-center" tabindex="0">Akhir WFH</th>
                <th class="sorting text-center" tabindex="0">Keterangan Keperluan</th>
                <th class="sorting text-center" tabindex="0">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr class="sorting text-center" tabindex="0">
                <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}">
                </td>
                <td class="text-center">
                    <span id="reject" data-toggle="modal" data-target="#modal-reject"
                        style="display: inline; margin: auto 5px" data-id="{{$item->id}}" data-nip="{{$item->user_nip}}"
                        data-name="{{$item->user_name}}"
                        data-days="{{$item->days}}" data-datestart="{{$item->wfh_date_start}}"
                        data-dateend="{{$item->paid_leave_date_end}}" data-needs="{{$item->needs}}">
                        <a class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                            data-container="body" data-placement="top" data-original-title="Tolak Pengajuan WFH"
                            type="button">
                            <i class="fa fa-hand-stop-o"></i>
                        </a>
                    </span>
                </td>
                <td class="text-center">{{$item->user_nip}}</td>
                <td class="text-center">{{$item->user_name}}</td>
                <td class="text-center">{{indonesian_date($item->wfh_date_start)}}</td>
                <td class="text-center">{{indonesian_date($item->wfh_date_end)}}</td>
                <td class="text-center">{{$item->needs}}</td>
                <td class="text-center">{{$item->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </form>
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
@include('masterData/workFromHome/modal')
@endsection