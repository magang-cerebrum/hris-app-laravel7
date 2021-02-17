@extends('layouts/templateAdmin')
@section('title','Data Staff')
@section('content-title','Data Staff / Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-sm-6 jobTambah">
                        <a href="{{url('/admin/schedule/add')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px">
                            Tambah Jadwal Kerja
                        </a>
                    </div>
                </div>
                <table id="masterdata-division"
                            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                            cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                        <th class="sorting text-center" tabindex="0" style="width: 6%">Aksi</th>
                                        <th class="sorting text-center" tabindex="0">Bulan</th>
                                        <th class="sorting text-center" tabindex="0">Tahun</th>
                                        <th class="sorting text-center" tabindex="0">NIP</th>
                                        <th class="sorting text-center" tabindex="0">Nama</th>
                                        @for ($i = 1; $i < 3; $i++)
                                            <th class="sorting text-center" tabindex="0">{{'tanggal '.$i}}</th>
                                        @endfor
                                        <th class="sorting text-center" tabindex="0">Total Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr class="sorting text-center" tabindex="0">
                                            <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                            <td class="text-center">Aksi</td>
                                            <td class="text-center">{{$item->month}}</td>
                                            <td class="text-center">{{$item->year}}</td>
                                            <td class="text-center">{{$item->user_nip}}</td>
                                            <td class="text-center">{{$item->user_name}}</td>
                                            <td class="text-center">{{$item->date}}</td>
                                            @if ($item->shift_id == 1)
                                                <td class="text-center">Pagi</td>
                                            @endif
                                            
                                            <td class="text-center">{{$item->shift_id}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
            </div>
        </div>
    </div>
@endsection