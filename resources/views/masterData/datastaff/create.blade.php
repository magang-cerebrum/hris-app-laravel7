@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data / Tambah Data Staff')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Data Staff')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
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

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Data Staff</h3>
        </div>
        
        <form action="/admin/data-staff" method="POST" id="form_create">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">NIP:</label>
                        <div class="col-sm-4">
                            <input type="number" placeholder="NIP" name="nip" form="form_create"
                                class="form-control @error('nip') is-invalid @enderror" value="{{old('nip')}}">
                            @error('nip') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi NIP.
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label">Nama Staff:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nama Lengkap" name="name" form="form_create"
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
                                        placeholder="Tanggal Lahir" name="dob" value="{{old('dob')}}" form="form_create">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                @error('dob') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                    tanggal lahir.</div> @enderror
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Jenis Kelamin:</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <input id="gender-1" class="magic-radio @error('gender') is-invalid @enderror" type="radio" form="form_create"
                                    name="gender" value="Laki-laki">
                                <label for="gender-1">Laki-laki</label>
                                <input id="gender-2" class="magic-radio @error('gender') is-invalid @enderror" type="radio" form="form_create"
                                    name="gender" value="Perempuan">
                                <label for="gender-2">Perempuan</label>
                            </div>
                            @error('gender') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                jenis kelamin.</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="textarea-input-address">Alamat:</label>
                        <div class="col-sm-10">
                            <textarea id="textarea-input-address" rows="2" class="form-control @error('address') is-invalid @enderror" form="form_create"
                                placeholder="Alamat Lengkap" name="address" value="{{old('address')}}" style="resize: none"></textarea>
                                @error('address') <div class="text-danger invalid-feedback mt-3">{{$message}}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">No Handphone:</label>
                        <div class="col-sm-4">
                            <input type="number" placeholder="Nomor Handphone" name="phone_number" form="form_create"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{old('phone_number')}}">
                            @error('phone_number') <div class="text-danger invalid-feedback mt-3">
                                {{$message}}
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Alamat Email" name="email" form="form_create"
                                class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                            @error('email') <div class="text-danger invalid-feedback mt-3">
                                {{$message}}
                            </div> @enderror
                        </div>
                    </div>
                </div>
                {{-- password & photo profile--}}
                <input type="hidden" name="password" class="form-control invisible" form="form_create"
                    value="<?=password_hash("cerebrum",PASSWORD_DEFAULT)?>">
                <input type="hidden" name="photo_profile" class="form-control invisible" form="form_create"
                    value="defaultL.jpg">
                {{-- ================== --}}
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Status Karyawan:</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <input id="employee_status_radio-1" class="magic-radio @error('employee_status') is-invalid @enderror" type="radio" form="form_create"
                                    name="employee_status" value="Tetap" onclick="showContractOption()">
                                <label for="employee_status_radio-1">Tetap</label>
                                <input id="employee_status_radio-2" class="magic-radio @error('employee_status') is-invalid @enderror" type="radio" form="form_create"
                                    name="employee_status" value="Kontrak" onclick="showContractOption()">
                                <label for="employee_status_radio-2">Kontrak</label>
                                <input id="employee_status_radio-3" class="magic-radio @error('employee_status') is-invalid @enderror" type="radio" form="form_create"
                                    name="employee_status" value="Probation" onclick="showContractOption()" checked>
                                <label for="employee_status_radio-3">Probation</label>
                            </div>
                            @error('employee_status') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                status karyawan.</div> @enderror
                        </div>
                        <span id="input-contract_duration">
                            <label class="col-sm-2 control-label">Durasi Kontrak:</label>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Lama kontrak dalam satuan bulan"
                                    name="contract_duration" id="contract_duration" form="form_create"
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
                            <input id="employee_type_radio-1" class="magic-radio @error('employee_type') is-invalid @enderror" type="radio" name="employee_type"
                                value="Fulltime" form="form_create">
                            <label for="employee_type_radio-1">Fulltime</label>
                            <input id="employee_type_radio-2" class="magic-radio @error('employee_type') is-invalid @enderror" type="radio" name="employee_type"
                                value="Freelance" form="form_create">
                            <label for="employee_type_radio-2">Freelance</label>
                            <input id="employee_type_radio-3" class="magic-radio @error('employee_type') is-invalid @enderror" type="radio" name="employee_type"
                                value="Magang" form="form_create">
                            <label for="employee_type_radio-3">Magang</label>
                        </div>
                        @error('employee_type') <div class="text-danger invalid-feedback mt-3">Mohon isi
                            tipe karyawan.</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status:</label>
                    <div class="col-sm-10">
                        <div class="radio">
                            <input id="status_radio-1" class="magic-radio" type="radio" name="status" value="Aktif" form="form_create" checked>
                            <label for="status_radio-1">Aktif</label>
                            <input id="status_radio-2" class="magic-radio" type="radio" name="status" value="Non-Aktif" form="form_create">
                            <label for="status_radio-2">Non-Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="division_id">Divisi:</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-info" name="division_id" form="form_create">
                                @foreach ($divisions as $item)
                                <option value="{{$item->division_id}}">{{$item->division_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-2 control-label" for="division_id">Jabatan:</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-success" name="position_id" form="form_create">
                                @foreach ($positions as $item)
                                <option value="{{$item->position_id}}" {{$item->position_name == 'Staff' ? 'selected' : ''}}>{{$item->position_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="division_id">Hak akses:</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-purple" name="role_id" form="form_create">
                                @foreach ($roles as $item)
                                <option value="{{$item->role_id}}" {{$item->role_name == 'Staff' ? 'selected' : ''}}>{{$item->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Sisa Cuti Tahunan:</label>
                        <div class="col-sm-4">
                            <input type="number" placeholder="Sisa cuti diisi hanya dengan jumlah hari"
                                name="yearly_leave_remaining" form="form_create"
                                class="form-control @error('yearly_leave_remaining') is-invalid @enderror"
                                value="{{old('yearly_leave_remaining')}}">
                            @error('yearly_leave_remaining') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi sisa cuti hanya dengan angka.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="credit_card_number">No. Rekening:</label>
                        <div class="col-sm-4">
                            <input type="number" placeholder="Nomor Rekening tanpa Kode Bank"
                            name="credit_card_number" form="form_create"
                            class="form-control @error('credit_card_number') is-invalid @enderror"
                            value="{{old('credit_card_number')}}">
                            @error('credit_card_number') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi nomor rekening hanya dengan angka.
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label" for="salary">Gaji Pokok:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Gaji Pokok" name="salary" id="salary" form="form_create"
                                class="form-control @error('salary') is-invalid @enderror"
                                value="{{old('salary')}}" onkeyup="format_rp()">
                            @error('salary') <div class="text-danger invalid-feedback mt-3">
                                Mohon isi gaji pokok.
                            </div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" form="form_create">Tambah</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
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
            $('#datepicker-input-dob .input-group.date').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                orientation: 'bottom',
                endDate: '0d'
            });
        });

        window.onload = showContractOption();
    </script>
@endsection
