@extends('layouts/templateStaff')
@section('title', 'Ticketing')
@section('content-title', 'Ticketing')
@section('content-subtitle', 'HRIS ' . $company_name)

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">History Ticketing</h3>
        </div>
        <div class="panel-body" style="padding-top: 20px">
            <div class="table-responsive">
                <table id="staff-ticketing"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"style="width: 5%">No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">Detail</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Kategori</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Status</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Diajukan pada</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                            colspan="1" aria-label="Position: activate to sort column ascending">Direspon pada</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketing as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">
                                    {{(($ticketing->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                <td class="text-center">
                                    <span id="detail_ticket" data-toggle="modal" data-target="#modal-detail-ticket"
                                        style="display: inline; margin: auto 5px" data-id="{{$row->id}}"
                                        data-name="{{$row->name}}" data-category="{{$row->category}}"
                                        data-message="{{$row->message}}" data-response="{{$row->response}}"
                                        data-status="{{$row->status}}" data-diajukan="{{$row->created_at}}">
                                        <a class="btn btn-info btn-icon btn-circle btn-sm add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Detail Ticket"
                                            type="button">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </span>
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
                                <td class="text-center">
                                    @if ($row->created_at == $row->updated_at)
                                        -
                                    @else
                                        {{indonesian_date($row->updated_at,true)}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button data-toggle="modal" data-target="#modal-input-ticket" class="btn btn-pink float-right" id="input-ticket">Input Ticket Baru</button>
        </div>
    </div>
    @include('staff/transactionticketing/modal')
@endsection
