@extends($data->role_id == 1 ? 'layouts/templateAdmin' : 'layouts/templateStaff')
@section('content-title','Profile User')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Profile Data Staff')
@section('content')

<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<!--Bootstrap Select [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-bold text-center">Profile User</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="POST">
            @csrf
            @method('put')
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
                                    value="{{$data->dob}}" readonly>
                            </div>
                        </div>
                        <label class="col-sm-2 control-label" for="textarea-input-live_at">Alamat:</label>
                        <div class="col-sm-4">
                            <textarea id="textarea-input-live_at" rows="2" class="form-control" placeholder="Alamat Lengkap" name="live_at" readonly>{{$data->live_at}}</textarea>
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
                        @if ($data->employee_status == 'Kontrak')
                        <span id="input-contract_duration">
                            <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Lama kontrak dalam satuan bulan"
                                    name="contract_duration" class="form-control" value="{{$data->contract_duration}}">
                            </div>
                        </span>
                        @endif
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
                            <input type="text" placeholder="Tanggal Mulai Bekerja" name="start_work_date" class="form-control" value="{{$data->start_work_date}}" readonly>
                        </div>
                        @if ($data->end_work_date != '')
                        <label class="col-sm-2 control-label">Tanggal Akhir Bekerja:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Tanggal Akhir Bekerja" name="end_work_date" class="form-control" value="{{$data->end_work_date}}" readonly>
                        </div>
                        @endif
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
                        <label class="col-sm-2 control-label" for="shift_id">Waktu Shift:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Shift" name="shift" class="form-control" value="{{$shifts[0]->name}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Sisa Cuti Tahunan:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Sisa cuti diisi hanya dengan angka"
                                name="yearly_leave_remaining" class="form-control" value="{{$data->yearly_leave_remaining}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="/admin/profile/edit" class="btn btn-mint" type="submit">Ubah Profil</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<!--Bootstrap Select [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>

<script>
    function showContractOption() {
        if (document.getElementById('employee_status_radio-1').checked) {
            document.getElementById('input-contract_duration').style.display = 'none';
        } else {
            document.getElementById('input-contract_duration').style.display = 'block';
        }
    };

    $(document).ready(function () {
        $('#datepicker-edit-dob .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-edit-mulai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-edit-selesai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
    });

</script>
@endsection
