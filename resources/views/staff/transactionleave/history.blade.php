@extends('layouts/templateStaff')
@section('title','Masterdata Cuti')
@section('content-title','Data Staff / Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                @if (count($data) == 0)
                    <div class="text-center">
                        <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                    </div>
                    @else
                        <form action="{{ url('/staff/paid-leave/delete')}}" method="POST">
                            @method('delete')
                            @csrf
                            <table id="masterdata-division"
                            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                            cellspacing="0">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr class="sorting text-center" tabindex="0">
                                            <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                                            <td class="text-center">{{$item->type_name}}</td>
                                            <td class="text-center">{{$item->paid_leave_date_start}}</td>
                                            <td class="text-center">{{$item->paid_leave_date_end}}</td>
                                            <td class="text-center">{{$item->days.' hari'}}</td>
                                            <td class="text-center">{{$item->needs}}</td>
                                            <td class="text-center">{{$item->informations}}</td>
                                            <td class="text-center">{{$item->status}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
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