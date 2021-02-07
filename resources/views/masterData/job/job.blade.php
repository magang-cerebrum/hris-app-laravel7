@extends('layout/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Lowongan Tersedia')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
        <div class="panel">
            <!-- Striped Table -->
            <!--===================================================-->
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{url('/admin/job/add')}}" class="btn btn-primary btn-labeled"
                                style="margin-bottom:15px">
                                <i class="btn-label fa fa-plus"></i>
                                Tambah Divisi
                            </a>
                        </div>
                    </div>
                    @if (count($dataJob) == 0)
                        <div class="text-center">
                            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                        </div>
                        @else
                            <table id="masterdata-division"
                            class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                            cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting text-center" tabindex="0">No</th>
                                        <th class="sorting text-center" tabindex="0">Nama Posisi</th>
                                        <th class="sorting text-center" tabindex="0">Deskripsi</th>
                                        <th class="sorting text-center" tabindex="0">Persyaratan</th>
                                        <th class="sorting text-center" tabindex="0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataJob as $item)
                                        <tr>
                                            <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                            <td class="text-center">{{$item->name}}</td>
                                            <td class="text-center">{{$item->descript}}</td>
                                            <td class="text-center">{{$item->required}}</td>
                                            <td class="text-center">
                                                <form action="/admin/job/{{$item->id}}" method="POST" style="display: inline; margin: auto 5px">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-pink btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Hapus Data">
                                                        <i class="fa fa-trash icon-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @endif
                </div>
            </div>
            <!--===================================================-->
            <!-- End Striped Table -->
    </div>
@endsection