@extends('layouts/templateStaff')
@section('title','Cuti Anggota Divisi')
@section('content-title','Cuti Anggota Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel panel-primary panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Riwayat Pengajuan Cuti Divisi</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{url('/staff/paid-leave/division/history')}}" class="btn btn-pink btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top"
                    data-original-title="Lihat Riwayat Pengajuan Cuti" style="margin-bottom: 15px">
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
                data-original-title="Terima Pengajuan Cuti" onclick="submit_approve()">
                <i class="btn-label fa fa-check"></i>
                Terima Cuti Terpilih
            </button>
            <button id="btn-pending" class="btn btn-warning btn-labeled add-tooltip" style="margin-top: -15px"
                type="button" data-toggle="tooltip" data-container="body" data-placement="top"
                data-original-title="Pending Pengajuan Cuti" onclick="submit_pending()">
                <i class="btn-label fa fa-spinner"></i>
                Pending Data Terpilih
            </button>
    </div>
</div>
<div class="table-responsive">
    <table id="transaction-paid-leave-staff" class="table table-striped table-bordered no-footer dtr-inline collapsed"
        role="grid" aria-describedby="dt-basic_info" cellspacing="0">
        <thead>
            <tr>
                <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master">
                </th>
                <th class="sorting text-center" tabindex="0" style="width: 5%">Aksi</th>
                <th class="sorting text-center" tabindex="0">Nama Staff</th>
                <th class="sorting text-center" tabindex="0">Tipe Cuti</th>
                <th class="sorting text-center" tabindex="0">Mulai Cuti</th>
                <th class="sorting text-center" tabindex="0">Akhir Cuti</th>
                <th class="sorting text-center" tabindex="0">Jumlah Hari Cuti</th>
                <th class="sorting text-center" tabindex="0">Keperluan</th>
                <th class="sorting text-center" tabindex="0">Keterangan</th>
                <th class="sorting text-center" tabindex="0">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr class="sorting text-center" tabindex="0">
                <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}"></td>
                <td class="text-center">
                    <span id="reject" data-toggle="modal" data-target="#modal-reject"
                        style="display: inline; margin: auto 5px" data-id="{{$item->id}}" data-nip="{{$item->user_nip}}"
                        data-name="{{$item->user_name}}" data-paidleaveleft="{{$item->user_leave_remaining}}"
                        data-days="{{$item->days}}" data-datestart="{{$item->paid_leave_date_start}}"
                        data-dateend="{{$item->paid_leave_date_end}}" data-needs="{{$item->needs}}">
                        <a class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                            data-container="body" data-placement="top" data-original-title="Tolak Pengajuan Cuti"
                            type="button">
                            <i class="fa fa-hand-stop-o"></i>
                        </a>
                    </span>
                </td>
                <td class="text-center">{{$item->user_name}}</td>
                <td class="text-center">{{$item->type_name}}</td>
                <td class="text-center">{{indonesian_date($item->paid_leave_date_start)}}</td>
                <td class="text-center">{{indonesian_date($item->paid_leave_date_end)}}</td>
                <td class="text-center">{{$item->days.' hari'}}</td>
                <td class="text-center">{{$item->needs}}</td>
                <td class="text-center">{{$item->informations}}</td>
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
@include('staff/transactionleave/modaldivision')
@endsection
