@extends('layouts/templateAdmin')
@section('title','Sistem / Sistem Log HRIS')
@section('content-title','Laporan Log HRIS')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Data Tipe Cuti</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                @if (session('status'))
                <div class="alert alert-info alert-dismissable">
                    <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                    {{session('status')}}
                </div>
                @endif
                <div class="row">
                    <div class="col-sm-2">
                        <a href="{{route('createaachievementdates')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Data
                        </a>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-3 hidden">
                        <div class="form-group float-right">
                            <input type="text" name="cari-divisi" id="cari-divisi" class="form-control"
                                placeholder="Cari Divisi" />
                        </div>
                    </div>
                </div>
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Bulan</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Tahun</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            {{-- <td tabindex="0" class="sorting_1 text-center">{{(($data->currentPage() * 10) - 10) + $loop->iteration}}</td> --}}
                            {{-- <td tabindex="0" class="sorting_1 text-center">{{$row->id}}</td> --}}
                            <td class="text-center">{{$row->month}}</td>
                            <td class="text-center">{{$row->year}}</td>

                            <td class="text-center">
                                <a href="/admin/achievement/scoring"
                                    class="btn btn-primary btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Beri Score"
                                    type="button">
                                    <i class="fa fa-trophy"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
   
@endsection