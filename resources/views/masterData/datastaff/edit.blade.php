@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data / Edit Data Staff')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Data Staff')
@section('content')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<!--Bootstrap Select [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Data Staff</h3>
    </div>
    
    <form class="form-horizontal" action="/admin/data-staff/{{$staff->id}}" method="POST" id="edit">
        @csrf
        @method('put')
    </form>

    <div class="panel-body">
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">NIP:</label>
                <div class="col-sm-4">
                    <input type="number" placeholder="NIP" name="nip" form="edit"
                        class="form-control @error('nip') is-invalid @enderror" value="{{$staff->nip}}">
                    @error('nip') <div class="text-danger invalid-feedback mt-3">
                        Mohon isi NIP.
                    </div> @enderror
                </div>
                <label class="col-sm-2 control-label">Nama Staff:</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Nama Lengkap" name="name" form="edit"
                        class="form-control @error('name') is-invalid @enderror" value="{{$staff->name}}">
                    @error('name') <div class="text-danger invalid-feedback mt-3">
                        Mohon isi nama lengkap.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">Tanggal Lahir:</label>
                <div id="datepicker-edit-dob">
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <input type="text" class="form-control @error('dob') is-invalid @enderror"
                                placeholder="Tanggal Lahir" name="dob" value="{{$staff->dob}}" form="edit">
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
                        <input id="gender-1" class="magic-radio" type="radio" name="gender" value="Laki-laki" form="edit"
                            {{$staff->gender == 'Laki-laki' ? 'checked' : ''}}>
                        <label for="gender-1">Laki-laki</label>
                        <input id="gender-2" class="magic-radio" type="radio" name="gender" value="Perempuan" form="edit"
                            {{$staff->gender == 'Perempuan' ? 'checked' : ''}}>
                        <label for="gender-2">Perempuan</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="textarea-input-address">Alamat:</label>
                <div class="col-sm-10">
                    <textarea id="textarea-input-address" rows="2" class="form-control" form="edit"
                        placeholder="Alamat Lengkap" name="address">{{$staff->address}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">No Handphone:</label>
                <div class="col-sm-4">
                    <input type="number" placeholder="Nomor Handphone" name="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror"
                        value="{{$staff->phone_number}}" form="edit">
                    @error('phone_number') <div class="text-danger invalid-feedback mt-3">
                        {{$message}}
                    </div> @enderror
                </div>
                <label class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Alamat Email" name="email" form="edit"
                        class="form-control @error('email') is-invalid @enderror" value="{{$staff->email}}">
                    @error('email') <div class="text-danger invalid-feedback mt-3">
                        {{$message}}
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">Status Karyawan:</label>
                <div class="col-sm-4">
                    <div class="radio">
                        <!-- Inline radio buttons -->
                        <input id="employee_status_radio-1" class="magic-radio" type="radio" form="edit"
                            name="employee_status" value="Tetap" onclick="showContractOption()"
                            {{$staff->employee_status == 'Tetap' ? 'checked' : ''}}>
                        <label for="employee_status_radio-1">Tetap</label>
                        <input id="employee_status_radio-2" class="magic-radio" type="radio" form="edit"
                            name="employee_status" value="Kontrak" onclick="showContractOption()"
                            {{$staff->employee_status == 'Kontrak' ? 'checked' : ''}}>
                        <label for="employee_status_radio-2">Kontrak</label>
                        <input id="employee_status_radio-3" class="magic-radio" type="radio" form="edit"
                            name="employee_status" value="Probation" onclick="showContractOption()"
                            {{$staff->employee_status == 'Probation' ? 'checked' : ''}}>
                        <label for="employee_status_radio-3">Probation</label>
                    </div>
                </div>
                <span id="input-contract_duration">
                    <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                    <div class="col-sm-4">
                        <input type="number" placeholder="Lama kontrak dalam satuan bulan" form="edit"
                            name="contract_duration" id="contract_duration"
                            class="form-control @error('contract_duration') is-invalid @enderror" readonly>
                        @error('contract_duration') <div class="text-danger invalid-feedback mt-3">
                            Durasi kontrak harus diisi ketika "Status Karyawan" diisi "Kontrak".
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
                    <input id="employee_type_radio-1" class="magic-radio" type="radio" name="employee_type" form="edit"
                        value="Fulltime" {{$staff->employee_type == 'Fulltime' ? 'checked' : ''}}>
                    <label for="employee_type_radio-1">Fulltime</label>
                    <input id="employee_type_radio-2" class="magic-radio" type="radio" name="employee_type" form="edit"
                        value="Freelance" {{$staff->employee_type == 'Freelance' ? 'checked' : ''}}>
                    <label for="employee_type_radio-2">Freelance</label>
                    <input id="employee_type_radio-3" class="magic-radio" type="radio" name="employee_type" form="edit"
                        value="Magang" {{$staff->employee_type == 'Magang' ? 'checked' : ''}}>
                    <label for="employee_type_radio-3">Magang</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Status:</label>
            <div class="col-sm-10">
                <div class="radio">
                    <!-- Inline radio buttons -->
                    <input id="status_radio-1" class="magic-radio" type="radio" name="status" value="Aktif" form="edit"
                        {{$staff->status == 'Aktif' ? 'checked' : ''}}>
                    <label for="status_radio-1">Aktif</label>
                    <input id="status_radio-2" class="magic-radio" type="radio" name="status" value="Non-Aktif" form="edit"
                        {{$staff->status == 'Non-Aktif' ? 'checked' : ''}}>
                    <label for="status_radio-2">Non-Aktif</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="division_id">Divisi:</label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-info" name="division_id" form="edit">
                        @foreach ($divisions as $item)
                        <option value="{{$item->divisions_id}}"
                            {{$staff->division_id == $item->divisions_id ? 'selected' : ''}}>
                            {{$item->divisions_name}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 control-label" for="division_id">Jabatan:</label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-success" name="position_id" form="edit">
                        @foreach ($positions as $item)
                        <option value="{{$item->positions_id}}"
                            {{ $staff->position_id == $item->positions_id ? 'selected' : ''}}>
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
                    <select class="selectpicker" data-style="btn-purple" name="role_id" form="edit">
                        @foreach ($roles as $item)
                        <option value="{{$item->roles_id}}"
                            {{ $staff->role_id == $item->roles_id ? 'selected' : '' }}>
                            {{$item->roles_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Sisa Cuti Tahunan:</label>
            <div class="col-sm-4">
                <input type="number" placeholder="Sisa cuti diisi hanya dengan angka"
                    name="yearly_leave_remaining" form="edit"
                    class="form-control @error('yearly_leave_remaining') is-invalid @enderror"
                    value="{{$staff->yearly_leave_remaining}}">
                @error('yearly_leave_remaining') <div class="text-danger invalid-feedback mt-3">
                    Mohon isi sisa cuti hanya dengan angka.
                </div> @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="credit_card_bank">Bank:</label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-mint" name="credit_card_bank" form="edit">
                        <option value="BNI" {{$staff->credit_card_bank == 'BNI' ? 'selected' : ''}}>BNI</option>
                        <option value="BCA" {{$staff->credit_card_bank == 'BCA' ? 'selected' : ''}}>BCA</option>
                        <option value="BRI" {{$staff->credit_card_bank == 'BRI' ? 'selected' : ''}}>BRI</option>
                        <option value="BJB" {{$staff->credit_card_bank == 'BJB' ? 'selected' : ''}}>BJB</option>
                        <option value="Mandiri" {{$staff->credit_card_bank == 'Mandiri' ? 'selected' : ''}}>Mandiri</option>
                        <option value="Mandiri Syariah" {{$staff->credit_card_bank == 'Mandiri Syariah' ? 'selected' : ''}}>Mandiri Syariah</option>
                        <option value="BJB Syariah" {{$staff->credit_card_bank == 'BJB Syariah' ? 'selected' : ''}}>BJB Syariah</option>
                        @error('credit_card_bank') <div class="text-danger invalid-feedback mt-3">
                            Mohon pilih bank.
                        </div> @enderror
                    </select>
                </div>
                <label class="col-sm-2 control-label" for="credit_card_number">No. Rekening:</label>
                <div class="col-sm-4">
                    <input type="number" placeholder="Nomor Rekening tanpa Kode Bank"
                    name="credit_card_number" form="edit"
                    class="form-control @error('credit_card_number') is-invalid @enderror"
                    value="{{$staff->credit_card_number}}">
                    @error('credit_card_number') <div class="text-danger invalid-feedback mt-3">
                        Mohon isi sisa cuti hanya dengan angka.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="salary">Gaji Pokok:</label>
            <div class="col-sm-4">
                <input type="text" placeholder="Gaji Pokok" name="salary" id="salary" form="edit"
                    class="form-control @error('salary') is-invalid @enderror"
                    value="{{$staff->salary}}" onkeyup="format_rp()">
                @error('salary') <div class="text-danger invalid-feedback mt-3">
                    Mohon isi gaji pokok.
                </div> @enderror
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" form="edit">Simpan</button>
    </div>
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
            document.getElementById('contract_duration').value = '';
        } else {
            document.getElementById('input-contract_duration').style.display = 'block';
            if (document.getElementById('employee_status_radio-2').checked){
                document.getElementById('contract_duration').value = '12';
            } else {
                document.getElementById('contract_duration').value = '3';
            }
        }
    };

    function format_rp() {
        var angka = document.getElementById("salary").value;
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        document.getElementById("salary").value = 'Rp. ' + rupiah;
    }

    $(document).ready(function () {
        $('#datepicker-edit-dob .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            orientation: 'bottom',
            endDate: '0d'
        });
    });

    window.onload = showContractOption();
</script>
@endsection
@endsection
