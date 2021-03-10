@extends($data->role_id == 1 ? 'layouts/templateAdmin' : 'layouts/templateStaff')
@section('content-title','Profile User')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Edit Data Staff')
@section('content')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<!--Bootstrap Select [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
@endsection

<div class="panel panel-bordered {{$data->role_id == 1 ? 'panel-danger' : 'panel-primary'}}">
    <div class="panel-heading">
        <h3 class="panel-title">Edit Profile User</h3>
    </div>
    <form class="form-horizontal" method="POST"
        action="{{($data->role_id == 1 ? '/admin/profile/'.$data->id : '/staff/profile/'.$data->id)}}">
        @csrf
        @method('put')
        <div class="panel-body">
            <input type="hidden" name="password" class="form-control invisible" value="{{$data->password}}">
            <input type="hidden" name="profile_photo" class="form-control invisible"
                value="{{$data->profile_photo}}">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Nama Staff:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Lengkap" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{$data->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Mohon isi nama lengkap.
                        </div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal Lahir:</label>
                    <div id="datepicker-editprof-dob">
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control @error('dob') is-invalid @enderror"
                                    placeholder="Tanggal Lahir" name="dob" value="{{$data->dob}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            @error('dob') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                tanggal lahir.</div> @enderror
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Jenis Kelamin:</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <!-- Inline radio buttons -->
                            <input id="employee_type_radio-1" class="magic-radio" type="radio" name="gender"
                                value="Laki-laki" {{$data->gender == 'Laki-laki' ? 'checked' : ''}}>
                            <label for="employee_type_radio-1">Laki-laki</label>
                            <input id="employee_type_radio-2" class="magic-radio" type="radio" name="gender"
                                value="Perempuan" {{$data->gender == 'Perempuan' ? 'checked' : ''}}>
                            <label for="employee_type_radio-2">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="textarea-input-live_at">Alamat:</label>
                    <div class="col-sm-10">
                        <textarea id="textarea-input-live_at" rows="2" class="form-control"
                            placeholder="Alamat Lengkap" name="live_at">{{$data->live_at}}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">No Handphone:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nomor Handphone" name="phone_number"
                            class="form-control @error('phone_number') is-invalid @enderror"
                            value="{{$data->phone_number}}">
                        @error('phone_number') <div class="text-danger invalid-feedback mt-3">
                            {{$message}}
                        </div> @enderror
                    </div>
                    <label class="col-sm-2 control-label">Email:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Alamat Email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{$data->email}}">
                        @error('email') <div class="text-danger invalid-feedback mt-3">
                            {{$message}}
                        </div> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label text-center">Foto Profil:</label>
                    <div class="col-sm-4 text-center offset">
                        <img src="{{asset('img/profile-photos/'.$data->profile_photo)}}" alt="Foto Profil Tidak Tersedia">
                    </div>
                </div>
            </div>
            @if ($data->role_id == 1)
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Status Karyawan:</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <!-- Inline radio buttons -->
                            <input id="employee_status_radio-1" class="magic-radio" type="radio"
                                name="employee_status" value="Tetap" onclick="showContractOption()"
                                {{$data->employee_status == 'Tetap' ? 'checked' : ''}}>
                            <label for="employee_status_radio-1">Tetap</label>
                            <input id="employee_status_radio-2" class="magic-radio" type="radio"
                                name="employee_status" value="Kontrak" onclick="showContractOption()"
                                {{$data->employee_status == 'Kontrak' ? 'checked' : ''}}>
                            <label for="employee_status_radio-2">Kontrak</label>
                        </div>
                    </div>
                    <span id="input-contract_duration">
                        <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Lama kontrak dalam satuan bulan"
                                name="contract_duration"
                                class="form-control @error('contract_duration') is-invalid @enderror"
                                value="{{$data->contract_duration}}">
                            @error('contract_duration') <div class="text-danger invalid-feedback mt-3">
                                Mohon hanya isi durasi kontrak dengan angka daalam hitungan perbulan.
                            </div> @enderror
                            <small class="text-muted">Tidak perlu diisi jika staff berstatus
                                tetap.</small>
                        </div>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tipe Karyawan:</label>
                <div class="col-sm-10">
                    <div class="radio">
                        <!-- Inline radio buttons -->
                        <input id="employee_type_radio-1" class="magic-radio" type="radio" name="employee_type"
                            value="Fulltime" {{$data->employee_type == 'Fulltime' ? 'checked' : ''}}>
                        <label for="employee_type_radio-1">Fulltime</label>
                        <input id="employee_type_radio-2" class="magic-radio" type="radio" name="employee_type"
                            value="Freelance" {{$data->employee_type == 'Freelance' ? 'checked' : ''}}>
                        <label for="employee_type_radio-2">Freelance</label>
                        <input id="employee_type_radio-3" class="magic-radio" type="radio" name="employee_type"
                            value="Magang" {{$data->employee_type == 'Magang' ? 'checked' : ''}}>
                        <label for="employee_type_radio-3">Magang</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Status:</label>
                <div class="col-sm-10">
                    <div class="radio">
                        <!-- Inline radio buttons -->
                        <input id="status_radio-1" class="magic-radio" type="radio" name="status" value="Aktif"
                            {{$data->status == 'Aktif' ? 'checked' : ''}}>
                        <label for="status_radio-1">Aktif</label>
                        <input id="status_radio-2" class="magic-radio" type="radio" name="status" value="Non-Aktif"
                            {{$data->status == 'Non-Aktif' ? 'checked' : ''}}>
                        <label for="status_radio-2">Non-Aktif</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal Mulai Bekerja:</label>
                    <div id="datepicker-editprof-mulai-kerja">
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text"
                                    class="form-control @error('start_work_date') is-invalid @enderror"
                                    placeholder="Tanggal Mulai Bekerja" name="start_work_date"
                                    value="{{$data->start_work_date}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            @error('start_work_date') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi tanggal mulai bekerja.</div> @enderror
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Tanggal Akhir Bekerja:</label>
                    <div id="datepicker-editprof-selesai-kerja">
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control @error('end_work_date') is-invalid @enderror"
                                    placeholder="Tanggal Akhir Bekerja" name="end_work_date"
                                    value="{{$data->end_work_date}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            @error('end_work_date') <div class="text-danger invalid-feedback mt-3">
                                {{$message}}</div> @enderror
                            <small class="text-muted">Tidak perlu diisi jika staff masih
                                bekerja.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="division_id">Divisi:</label>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-info" name="division_id">
                            @foreach ($divisions as $item)
                            <option value="{{$item->divisions_id}}"
                                {{$data->division_id == $item->divisions_id ? 'selected' : ''}}>
                                {{$item->divisions_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-sm-2 control-label" for="division_id">Jabatan:</label>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-success" name="position_id">
                            @foreach ($positions as $item)
                            <option value="{{$item->positions_id}}"
                                {{ $data->position_id == $item->positions_id ? 'selected' : ''}}>
                                {{$item->positions_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="division_id">Hak akses:</label>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-purple" name="role_id">
                            @foreach ($roles as $item)
                            <option value="{{$item->roles_id}}"
                                {{ $data->role_id == $item->roles_id ? 'selected' : '' }}>
                                {{$item->roles_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Sisa Cuti Tahunan:</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Sisa cuti diisi hanya dengan angka"
                        name="yearly_leave_remaining"
                        class="form-control @error('yearly_leave_remaining') is-invalid @enderror"
                        value="{{$data->yearly_leave_remaining}}">
                    @error('yearly_leave_remaining') <div class="text-danger invalid-feedback mt-3">
                        Mohon isi sisa cuti hanya dengan angka.
                    </div> @enderror
                </div>
            </div>
            @endif
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit">Simpan</button>
        </div>
    </form>
</div>
@section('script')
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
        $('#datepicker-editprof-dob .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-editprof-mulai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-editprof-selesai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
    });
</script>
@endsection
@endsection
