@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data / Tambah Data Staff')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tambah Data Staff')
@section('content')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<!--Bootstrap Select [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-bold text-center">Form Tambah Data Staff</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/data-staff" method="POST">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">NIP:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="NIP" name="nip"
                                class="form-control @error('nip') is-invalid @enderror" value="{{old('nip')}}">
                            @error('nip') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi NIP.
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label">Nama Staff:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nama Lengkap" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi nama lengkap.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Tanggal Lahir:</label>
                        <div id="datepicker-input-dob">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control @error('dob') is-invalid @enderror"
                                        placeholder="Tanggal Lahir" name="dob" value="{{old('dob')}}">
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
                                <input id="gender-1" class="magic-radio" type="radio"
                                    name="gender" value="Laki-laki">
                                <label for="gender-1">Laki-laki</label>
                                <input id="gender-2" class="magic-radio" type="radio"
                                    name="gender" value="Perempuan">
                                <label for="gender-2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="textarea-input-live_at">Alamat:</label>
                        <div class="col-sm-10">
                            <textarea id="textarea-input-live_at" rows="2" class="form-control"
                                placeholder="Alamat Lengkap" name="live_at" value="{{old('live_at')}}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">No Handphone:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nomor Handphone" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{old('phone_number')}}">
                            @error('phone_number') <div class="text-danger invalid-feedback mt-3">
                                {{$message}}
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Alamat Email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                            @error('email') <div class="text-danger invalid-feedback mt-3">
                                {{$message}}
                            </div> @enderror
                        </div>
                    </div>
                </div>
                {{-- password & photo profile--}}
                <input type="hidden" name="password" class="form-control invisible"
                    value="<?=password_hash("cerebrum",PASSWORD_DEFAULT)?>">
                <input type="hidden" name="photo_profile" class="form-control invisible"
                    value="default.jpg">
                {{-- ================== --}}
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Status Karyawan:</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <!-- Inline radio buttons -->
                                <input id="employee_status_radio-1" class="magic-radio" type="radio"
                                    name="employee_status" value="Tetap" onclick="showContractOption()">
                                <label for="employee_status_radio-1">Tetap</label>
                                <input id="employee_status_radio-2" class="magic-radio" type="radio"
                                    name="employee_status" value="Kontrak" onclick="showContractOption()" checked>
                                <label for="employee_status_radio-2">Kontrak</label>
                            </div>
                        </div>
                        <span id="input-contract_duration">
                            <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Lama kontrak dalam satuan bulan"
                                    name="contract_duration"
                                    class="form-control @error('contract_duration') is-invalid @enderror">
                                @error('contract_duration') <div class="text-danger invalid-feedback mt-3">
                                    {{$message}}
                                </div> @enderror
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
                                value="Fulltime">
                            <label for="employee_type_radio-1">Fulltime</label>
                            <input id="employee_type_radio-2" class="magic-radio" type="radio" name="employee_type"
                                value="Freelance">
                            <label for="employee_type_radio-2">Freelance</label>
                            <input id="employee_type_radio-3" class="magic-radio" type="radio" name="employee_type"
                                value="Magang">
                            <label for="employee_type_radio-3">Magang</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status:</label>
                    <div class="col-sm-10">
                        <div class="radio">
                            <!-- Inline radio buttons -->
                            <input id="status_radio-1" class="magic-radio" type="radio" name="status" value="Aktif">
                            <label for="status_radio-1">Aktif</label>
                            <input id="status_radio-2" class="magic-radio" type="radio" name="status" value="Non-Aktif">
                            <label for="status_radio-2">Non-Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Tanggal Mulai Bekerja:</label>
                        <div id="datepicker-input-mulai-kerja">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <input type="text"
                                        class="form-control @error('start_work_date') is-invalid @enderror"
                                        placeholder="Tanggal Mulai Bekerja" name="start_work_date"
                                        value="{{old('start_work_date')}}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                @error('start_work_date') <div class="text-danger invalid-feedback mt-3">
                                    Mohon isi tanggal mulai bekerja.</div> @enderror
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Tanggal Akhir Bekerja:</label>
                        <div id="datepicker-input-selesai-kerja">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control @error('end_work_date') is-invalid @enderror"
                                        placeholder="Tanggal Akhir Bekerja" name="end_work_date"
                                        value="{{old('end_work_date')}}">
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
                                <option value="{{$item->division_id}}">{{$item->division_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-2 control-label" for="division_id">Jabatan:</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-success" name="position_id">
                                @foreach ($positions as $item)
                                <option value="{{$item->position_id}}">{{$item->position_name}}</option>
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
                                <option value="{{$item->role_id}}">{{$item->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-2 control-label" for="division_id">Waktu Shift:</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-pink" name="shift_id">
                                @foreach ($shifts as $item)
                                <option value="{{$item->shift_id}}">{{$item->shift_name}}</option>
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
                            value="{{old('yearly_leave_remaining')}}">
                        @error('yearly_leave_remaining') <div class="text-danger invalid-feedback mt-3">
                            Mohon isi sisa cuti hanya dengan angka.
                        </div> @enderror
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Tambah</button>
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
        $('#datepicker-input-dob .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-input-mulai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
        $('#datepicker-input-selesai-kerja .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true
        });
    });

</script>
@endsection
