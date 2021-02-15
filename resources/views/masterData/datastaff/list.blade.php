@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Masterdata Data Staff')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-2">
                        <a href="{{url('/admin/data-staff/add')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px">
                            <i class="btn-label fa fa-user-plus"></i>
                            Tambah Data Staff
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <form action="/admin/data-staff" method="POST" id="form-mul-delete" style="margin-bottom:15px">
                            @csrf
                            @method('delete')
                            <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                                data-toggle="tooltip" data-container="body" data-placement="top"
                                data-original-title="Hapus Data" onclick="submit_delete()">
                                <i class="btn-label fa fa-trash"></i>
                                Hapus Data Terpilih
                            </button>
                            @error('selectid') <span style="display:inline;" class="text-danger invalid-feedback mt-3">
                                Maaf, tidak ada data terpilih untuk dihapus.</span> @enderror
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group float-right">
                            <input type="text" id="cari-staff" class="form-control" placeholder="Cari Staff berdasarkan NIP, Nama atau Divisi"
                            onkeyup="search_staff()">
                        </div>
                    </div>
                </div>
                
                <table id="masterdata-staff"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                style="width: 5%;">No</th>
                            <th class="text-center" style="width: 6%;">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Action" style="width: 15%;">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam masuk: activate to sort column ascending">NIP</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam Kerja: activate to sort column ascending">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">
                                {{-- if paginate on --}}
                                {{-- {{(($staff->currentPage() * 5) - 5) + $loop->iteration}}</td> --}} 
                                {{$loop->iteration}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="check-item @error('selectid') is-invalid @enderror"
                                    name="selectid[]" value="{{$row->id}}">
                            </td>
                            <td class="text-center">
                                <span id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff"
                                    style="display: inline; margin: auto 5px" data-nip="{{$row->nip}}"
                                    data-name="{{$row->name}}" data-dob="{{$row->dob}}" data-live_at="{{$row->live_at}}"
                                    data-phone_number="{{$row->phone_number}}" data-gender="{{$row->gender}}"
                                    data-email="{{$row->email}}" data-profile_photo="{{$row->profile_photo}}"
                                    data-employee_status="{{$row->employee_status}}"
                                    data-employee_type="{{$row->employee_type}}" data-status="{{$row->status}}"
                                    data-contract_duration="{{$row->contract_duration}}"
                                    data-start_work_date="{{$row->start_work_date}}"
                                    data-end_work_date="{{$row->end_work_date}}"
                                    data-yearly_leave_remaining="{{$row->yearly_leave_remaining}}"
                                    data-division_name="{{$row->division_name}}"
                                    data-position_name="{{$row->position_name}}"
                                    data-role_name="{{$row->role_name}}">
                                    <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Detail Staff"
                                        type="button">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </span>
                                <a href="/admin/data-staff/{{$row->id}}/edit"
                                    class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Edit Staff"
                                    type="button">
                                    <i class="fa fa-pencil-square"></i>
                                </a>
                            </td>
                            <td class="text-center">{{$row->nip}}</td>
                            <td class="text-center">{{$row->name}}</td>
                            <td class="text-center">{{$row->division_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </form>
                </table>
                {{-- if paginate on --}}
                {{-- <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <ul class="pagination">
                            {{ $staff->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5"></div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@include('masterdata/datastaff/detail')
@endsection
