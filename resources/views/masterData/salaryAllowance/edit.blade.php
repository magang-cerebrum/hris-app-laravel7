@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Tunjangan Gaji / Edit Tunjangan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tunjangan Gaji')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <style>
        #total_cut {
            margin-top: 40px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Edit Tunjangan Gaji</h3>
        </div>

        <form class="form-horizontal" action="{{url('/admin/salary-allowance/'.$allowance->id)}}" method="POST" id="edit">
            @csrf
            @method('put')
        </form>
        
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Nama Tunjangan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Tunjangan" name="information" form="edit"
                            class="form-control @error('information') is-invalid @enderror"
                            value="{{$allowance->information}}" readonly>
                        @error('information') <div class="text-danger invalid-feedback mt-3">
                            Nama Tunjangan tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
            @if ($allowance->type == 'Semua')
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="nominal">Nominal :</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="nominal" name="nominal" form="edit"
                                class="form-control @error('nominal') is-invalid @enderror" value="{{$allowance->nominal}}"
                                onkeyup="format_rp()">
                            @error('nominal') <div class="text-danger invalid-feedback mt-3">
                                Nominal Tunjangan tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
            @else
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Untuk periode:</label>
                        <div id="datepicker-edit-range">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control @error('month') is-invalid @enderror"
                                        placeholder="bulan-tahun" name="periode" form="edit"
                                        value="{{switch_month($allowance->month,false).'-'.$allowance->year}}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                @error('month') <div class="text-danger invalid-feedback mt-3">Mohon isi periode.</div>
                                @enderror
                            </div>
                        </div>
                        <label class="col-sm-2 control-label" for="s_nominal">Nominal per Bulan:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="nominal" name="nominal" form="edit"
                                class="form-control @error('nominal') is-invalid @enderror" value="{{$allowance->nominal}}"
                                onkeyup="format_rp()">
                            @error('nominal') <div class="text-danger invalid-feedback mt-3">
                                Nominal Tunjangan tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="type">Staff :</label>
                        <div class="col-sm-6 mar-lft">
                            <select class="selectpicker" data-style="btn-primary" name="user_id" id="choose_staff" data-live-search="true" data-live-search-placeholder="Cari Staff" form="edit">
                                <option value=""></option>
                                @foreach ($staff as $item)
                                    <option value="{{$item->id}}" {{$item->id == $allowance->user_id ? 'selected' : ''}}>
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="text-danger invalid-feedback mt-3">Staff tidak boleh kosong jika
                                tipe Tunjangan "Perorangan".</div> @enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" form="edit">Update</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#choose_staff').selectpicker({
                dropupAuto: false
            });
            $('#datepicker-edit-range .input-group.date').datepicker({
                format: 'mm-yyyy',
                autoclose: true,
                orientation: 'bottom',
                minViewMode: 'months',
                startView: 'months'
            });
        });

        function format_rp() {
            var angka = document.getElementById("nominal").value;
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
            document.getElementById("nominal").value = 'Rp. ' + rupiah;
        }
    </script>
@endsection
