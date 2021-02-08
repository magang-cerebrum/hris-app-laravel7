@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Daftar Rekruitasi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
        <div class="panel">
            <!-- Striped Table -->
            <!--===================================================-->
            <div class="panel-body">
                <div class="table-responsive">
                    @if (count($data) == 0)
                        <div class="text-center">
                            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                        </div>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tempat Tanggal Lahir</th>
                                        <th>Domisili</th>
                                        <th>No Telfon</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pendidikan Terakhir</th>
                                        <th>Posisi</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->dob}}</td>
                                            <td>{{$item->live_at}}</td>
                                            <td>{{$item->phone_number}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->gender}}</td>
                                            <td>{{$item->last_education}}</td>
                                            <td>{{$item->position}}</td>
                                            <td>
                                                <a href="{{ asset('/cv_upload/'.$item->file_cv)}}" target="blank">
                                                    <button class="btn btn-primary btn-lg btn-block">Cv</button>
                                                </a>
                                                <a href="{{ asset('/portofolio_upload/'.$item->file_portofolio)}}" target="blank">
                                                    <button class="btn btn-primary btn-lg btn-block">Portofolio</button>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="/admin/recruitment/{{$item->id}}" method="POST" style="display: inline; margin: auto 5px">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-pink btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Hapus Rekruitasi">
                                                        <i class="fa fa-trash icon-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
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
            <!--===================================================-->
            <!-- End Striped Table -->
    </div>
@endsection