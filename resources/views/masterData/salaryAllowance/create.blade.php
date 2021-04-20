@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Tunjangan Gaji / Tambah Tunjangan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tunjangan Gaji')
@section('head')
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
        <h3 class="panel-title">Form Tambah Tunjangan Gaji</h3>
    </div>
    
    <form class="form-horizontal" action="{{url('/admin/salary-allowance')}}" method="POST" id="create">
        @csrf
    </form>

    <div class="panel-body">
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="type">Tipe Tunjangan:</label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-purple" name="type" id="type-changer" form="create"
                        onchange="showIndividualCuts()">
                        <option value="Semua" checked>Semua</option>
                        <option value="Perorangan">Perorangan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="information">Nama Tunjangan:</label>
                <div class="col-sm-10">
                    <select class="selectpicker @error('information') is-invalid @enderror" data-style="btn-pink" name="information" id="information" form="create">
                        <option id="null" value=" "></option>
                        @foreach ($data_type as $item)
                        <option class="{{$item->type}}" value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    <div id="info" class="text-danger">Tidak ada data tipe tunjangan tersedia. <a href="{{url('/admin/cuts-allowances/add')}}">Klik disini untuk menambahkan tipe tunjangan!</a></div>
                    @error('information') <div class="text-danger invalid-feedback mt-3">
                        Nama Tunjangan tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="global">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="nominal">Nominal :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="nominal" name="nominal" form="create"
                            class="form-control @error('nominal') is-invalid @enderror" value="{{old('nominal')}}"
                            onkeyup="format_rp()">
                        @error('nominal') <div class="text-danger invalid-feedback mt-3">
                            Nominal Tunjangan tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="individual hidden disabled">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="type">Staff :</label>
                    <div class="col-sm-6">
                        <select class="selectpicker" data-style="btn-primary" name="user_id" id="choose_staff"
                            data-live-search="true" data-live-search-placeholder="Cari Staff" form="create">
                            <option value=" "></option>
                            @foreach ($staff as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="text-danger invalid-feedback mt-3">Staff tidak boleh kosong
                            jika
                            tipe Tunjangan "Perorangan".</div> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="range">Jangka Tunjangan:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('range_month') is-invalid @enderror" form="create"
                            name="range_month" id="jangka" placeholder="Jangka Bayar (dalam satuan bulan)"
                            value="{{old('range_month')}}" onkeyup="format_rp_s()">
                        @error('range_month') <div class="text-danger invalid-feedback mt-3">Mohon isi Jangka Bayar.</div>
                        @enderror
                    </div>
                    <label class="col-sm-2 control-label" for="s_nominal">Nominal per Bulan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="s_nominal" name="s_nominal" form="create"
                            class="form-control @error('s_nominal') is-invalid @enderror" value="{{old('s_nominal')}}"
                            onkeyup="format_rp_s()">
                        @error('s_nominal') <div class="text-danger invalid-feedback mt-3">
                            Nominal tunjangan tidak boleh kosong.
                        </div> @enderror
                    </div>
                    <div class="text-success text-center" id="total_cut"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" id="submit-button" form="create">Tambah</button>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    function showIndividualCuts() {
        var type = document.getElementById("type-changer").value;
        if (type == 'Semua') {
            $(".individual").addClass("hidden disabled");
            $(".global").removeClass("hidden disabled");
            $('.Semua').show();
            $('.Perorangan').hide();
            var check = $('.Semua').length;
            if (check > 0) {
                $('#info').hide();
                document.getElementById('submit-button').disabled = false;
            } else {
                $('#info').show();
                document.getElementById('submit-button').disabled = true;
            }
        } else {
            $(".individual").removeClass("hidden disabled");
            $(".global").addClass("hidden disabled");
            $('.Semua').hide();
            $('.Perorangan').show();
            var check = $('.Perorangan').length;
            if (check > 0) {
                $('#info').hide();
                document.getElementById('submit-button').disabled = false;
            } else {
                $('#info').show();
                document.getElementById('submit-button').disabled = true;
            }
        }
        $('select[name=information]').val(' ');
        $('select[name=user_id]').val(' ');
        $('.selectpicker').selectpicker('refresh');
    }

    $(document).ready(function () {
        $('#choose_staff').selectpicker({
            dropupAuto: false
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

    function format_rp_s() {
        var angka = document.getElementById("s_nominal").value;
        var jangka = document.getElementById("jangka").value;
        var number_string = angka.replace(/[^,\d]/g, '').toString();
        var total = number_string * jangka;
        
        //format rp start from here
        split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        //format rp TOTAL start from here
        var number_string_t = total.toString().replace(/[^,\d]/g, '');
        split_t = number_string_t.split(','),
            sisa_t = split_t[0].length % 3,
            rupiah_t = split_t[0].substr(0, sisa_t),
            ribuan_t = split_t[0].substr(sisa_t).match(/\d{3}/gi);

        if (ribuan_t) {
            separator_t = sisa_t ? '.' : '';
            rupiah_t += separator_t + ribuan_t.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        rupiah_t = split_t[1] != undefined ? rupiah_t + ',' + split_t[1] : rupiah_t;

        document.getElementById("s_nominal").value = 'Rp. ' + rupiah;
        document.getElementById("total_cut").innerHTML = 'Total Tunjangan gaji dalam jangka ' + jangka +
            ' bulan kedepan adalah Rp. ' + rupiah_t;
    }

    window.onload = showIndividualCuts();
</script>
@endsection