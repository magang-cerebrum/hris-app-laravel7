@extends('layouts/templateStaff')
@section('title','Cuti')
@section('content-title','Cuti / Riwayat Pengajuan Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel panel-primary panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Riwayat Pengajuan Cuti</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            @if (count($data) == 0)
            <div class="text-center">
                <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
            </div>
            @else
            <table id="transaction-paid-leave-staff"
                class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                aria-describedby="dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                        <th class="sorting text-center" tabindex="0">Tipe Cuti</th>
                        <th class="sorting text-center" tabindex="0">Mulai Cuti</th>
                        <th class="sorting text-center" tabindex="0">Akhir Cuti</th>
                        <th class="sorting text-center" tabindex="0">Jumlah Hari Cuti</th>
                        <th class="sorting text-center" tabindex="0">Keperluan</th>
                        <th class="sorting text-center" tabindex="0">Keterangan</th>
                        <th class="sorting text-center" tabindex="0">Status</th>
                        <th class="sorting text-center" tabindex="0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr class="sorting text-center" tabindex="0">
                        <td class="sorting text-center" tabindex="0">
                            {{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                        <td class="text-center">{{$item->type_name}}</td>
                        <td class="text-center">{{indonesian_date($item->paid_leave_date_start)}}</td>
                        <td class="text-center">{{indonesian_date($item->paid_leave_date_end)}}</td>
                        <td class="text-center">{{$item->days.' hari'}}</td>
                        <td class="text-center">{{$item->needs}}</td>
                        <td class="text-center">{{$item->informations}}</td>
                        <td class="text-center">{{$item->status}}</td>
                        <td class="text-center">
                            @if ($item->status == 'Diajukan' || $item->status == 'Pending')
                            <a href="/staff/paid-leave/{{$item->id}}/cancel" class="cancel-paid-leave btn btn-sm btn-danger btn-icon btn-circle add-tooltip"
                                data-toggle="tooltip" data-container="body" data-placement="left"
                                data-original-title="Cancel Pengajuan Cuti" type="button">
                                <i class="fa fa-times"></i>
                            </a>
                            @else
                            <button class="btn btn-sm btn-icon btn-circle" type="submit" disabled>
                                <i class="fa fa-times"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

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
@endsection
