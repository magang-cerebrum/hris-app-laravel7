@extends('layouts/templateAdmin')
@section('title','Lembur')
@section('content-title','Data Staff / Lembur / Tambah Data Lembur')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<style>
    .table > tbody > tr > td,
    .table > tbody > tr > th,
    .table > thead > tr > td, 
    .table > thead > tr > th{
        vertical-align:middle;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
    .swal2-container {
        z-index: 10000 !important;
    }
</style>
@endsection

@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Pilih Staff untuk Lembur Periode "{{switch_month($month) . ' - ' . $year}}"</h3>
    </div>
    <div class="panel-body">
        @if(!$data->isEmpty())
        <table id="overtime-create" class="table table-striped table-bordered no-footer dtr-inline collapsed"
            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
            <thead>
                <tr role="row">
                    <th class="sorting_asc text-center" style="width: 8%;">No</th>
                    <th class="sorting_asc text-center" style="width: 8%;">Aksi</th>
                    <th class="sorting_asc text-center" style="width: 84%;">Nama</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">
                        <span id="create_overtime" data-toggle="modal" data-target="#modal-create-overtime"
                            style="display: inline;" data-id="{{$item->user_id}}" data-nip="{{$item->user_nip}}" 
                            data-name="{{$item->user_name}}" data-salary="{{$item->user_salary}}" data-user_hour="{{$item->user_hour}}">
                            <a class="btn btn-mint btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Tambahkan Data Lembur untuk {{$item->user_name}}"
                                type="button">
                                <i class="fa fa-plus"></i>
                            </a>
                        </span>
                    </td>
                    <td class="text-center">{{$item->user_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center text-danger text-bold">Ma'af, tidak ada data jadwal kerja ditemukan untuk periode {{switch_month($month) . ' - ' . $year}}</div>
        <div class="text-center mar-top">
            <a href="{{url('/admin/schedule/add')}}" class="btn btn-mint">Klik disini untuk menambahkan jadwal!</a>
        </div>
        @endif
    </div>
</div>
@include('masterdata/overtime/modalCreate')
@endsection