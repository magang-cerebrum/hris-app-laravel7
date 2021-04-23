@extends($data->role_id == 1 ? 'layouts/templateAdmin' : 'layouts/templateStaff')
@section('content-title','Profile User')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Profile Data Staff')
@section('content')
<div class="panel panel-bordered {{$data->role_id == 1 ? 'panel-danger' : 'panel-primary'}}">
    <div class="panel-heading">
        <h3 class="panel-title">Profile User</h3>
    </div>
    <form class="form-horizontal">
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">NIP:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="NIP" name="nip" class="form-control" value="{{$data->nip}}"
                            readonly>
                    </div>
                    <label class="col-sm-2 control-label">Nama User:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Lengkap" name="name" class="form-control"
                            value="{{$data->name}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal Lahir:</label>
                    <div id="datepicker-edit-dob">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Tanggal Lahir" name="dob"
                                value="{{indonesian_date($data->dob)}}" readonly>
                        </div>
                    </div>
                    <label class="col-sm-2 control-label" for="textarea-input-address">Alamat:</label>
                    <div class="col-sm-4">
                        <textarea id="textarea-input-address" rows="2" class="form-control" placeholder="Alamat Lengkap" name="address" readonly>{{$data->address}}</textarea>
                    </div>
                    <label class="col-sm-2 control-label">Jenis Kelamin:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Jenis Kelamin" name="genderr"
                            value="{{$data->gender}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">No Handphone:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nomor Handphone" name="phone_number" class="form-control"
                            value="{{$data->phone_number}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Email:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Alamat Email" name="email" class="form-control"
                            value="{{$data->email}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Status Karyawan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Status Karyawan" name="employee_status" class="form-control"
                            value="{{$data->employee_status}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Lama kontrak dalam satuan bulan"
                            name="contract_duration" class="form-control {{$data->employee_status == 'Tetap' ? 'text-info text-bold' : ''}}" value="{{$data->employee_status == 'Kontrak' || $data->employee_status == 'Probation' ? $data->contract_duration : 'Karyawan berstatus tetap'}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Tipe Karyawan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Tipe Karyawan" name="employee_type" class="form-control" value="{{$data->employee_type}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label text-center">Foto Profil:</label>
                            <div class="col-sm-4 text-center offset">
                                <img class="img-lg" src="{{asset('img/profile-photos/'.$data->profile_photo)}}" alt="Foto Profil Tidak Tersedia">
                            </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal Mulai Bekerja:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Tanggal Mulai Bekerja" name="start_work_date" class="form-control" value="{{indonesian_date($data->start_work_date)}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Tanggal Akhir Bekerja:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Tanggal Akhir Bekerja" name="end_work_date" class="form-control {{$data->employee_status == 'Tetap' ? 'text-info text-bold' : ''}}" value="{{$data->end_work_date != '' ? indonesian_date($data->end_work_date) : 'Karyawan berstatus tetap'}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="division_id">Divisi:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Divisi" name="divisi" class="form-control" value="{{$divisions[0]->name}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="position_id">Jabatan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Jabatan" name="jabatan" class="form-control" value="{{$positions[0]->name}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="role_id">Hak akses:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Hak Akses" name="role" class="form-control" value="{{$roles[0]->name}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Sisa Cuti Tahunan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Sisa cuti diisi hanya dengan angka"
                            name="yearly_leave_remaining" class="form-control" value="{{$data->yearly_leave_remaining}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Nomor Rekening:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nomor Rekening Bank" name="credit_card_number" class="form-control" value="{{$data->credit_card_number}}" readonly>
                    </div>
                    @if($data->user_id == 1)
                    <label class="col-sm-2 control-label">Gaji Pokok:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Tanggal Akhir Bekerja" name="end_work_date" class="form-control {{$data->employee_status == 'Tetap' ? 'text-info text-bold' : ''}}" value="{{$data->end_work_date != '' ? indonesian_date($data->end_work_date) : 'Karyawan berstatus tetap'}}" readonly>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            @if (Auth::user()->role_id == 1)
            <a href="{{url('/admin/profile/edit')}}" class="btn btn-mint" type="button">Ubah Profil</a>
            @else
            <a href="{{url('/staff/profile/edit')}}" class="btn btn-mint" type="button">Ubah Profil</a>
            @endif
        </div>
    </form>
</div>
@endsection
