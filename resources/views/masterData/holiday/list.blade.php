@extends('layouts/templateAdmin')
@section('title', 'Hari Libur')
@section('content-title', 'Master Data / Daftar Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel">
    <!-- Striped Table -->
    <!--===================================================-->
    <div class="panel-body">
        <div class="table-responsive">
            <div class="row">
                <div class="col-sm-6 jobTambah">
                    <a href="{{url('/admin/holiday/add')}}" class="btn btn-primary btn-labeled"
                        style="margin-bottom:15px">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Hari Libur Merah
                    </a>
                </div>
            </div>
            <table id="masterdata-division"
            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
            cellspacing="0">
                <thead>
                    <tr role="row">
                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                        <th class="sorting text-center" tabindex="0">Keterangan</th>
                        <th class="sorting text-center" tabindex="0">Tanggal Awal</th>
                        <th class="sorting text-center" tabindex="0">Total Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                            <td class="text-center">{{$item->information}}</td>
                            <td class="text-center">{{$item->date}}</td>
                            <td class="text-center">{{$item->total_day}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--===================================================-->
    <!-- End Striped Table -->
</div>
@endsection