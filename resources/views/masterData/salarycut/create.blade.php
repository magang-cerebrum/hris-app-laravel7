@extends('layouts/templateAdmin')
@section('content-title','Master Data / Potongan Gaji / Tambah Potongan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('head')
<!--Bootstrap Select [ OPTIONAL ]-->
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
        <h3 class="panel-title">Form Tambah Potongan Gaji</h3>
    </div>
    <form class="form-horizontal" action="{{url('/admin/salary-cut')}}" method="POST">
        @csrf
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="type">Tipe Potongan:</label>
                    <div class="col-sm-4 mar-lft">
                        <select class="selectpicker" data-style="btn-purple" name="type" id="type-changer"
                            onchange="showIndividualCuts()">
                            <option value="Semua">Semua</option>
                            <option value="Perorangan">Perorangan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="information">Nama Potongan :</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Nama Potongan" name="information"
                        class="form-control @error('information') is-invalid @enderror" value="{{old('information')}}">
                    @error('information') <div class="text-danger invalid-feedback mt-3">
                        Nama potongan tidak boleh kosong.
                    </div> @enderror
                </div>
                <div class="all">
                    <label class="col-sm-2 control-label" for="nominal">Nominal :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="nominal" name="nominal"
                            class="form-control @error('nominal') is-invalid @enderror" value="{{old('nominal')}}"
                            onkeyup="format_rp()">
                        @error('nominal') <div class="text-danger invalid-feedback mt-3">
                            Nominal potongan tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group hidden individual">
                <label class="col-sm-2 control-label" for="range">Jangka Potongan:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('range_month') is-invalid @enderror"
                        name="range_month" id="jangka" placeholder="Jangka Bayar (dalam satuan bulan)"
                        value="{{old('range_month')}}" onkeyup="format_rp_s()">
                    @error('range_month') <div class="text-danger invalid-feedback mt-3">Mohon isi Jangka Bayar.</div>
                    @enderror
                </div>
                <label class="col-sm-2 control-label" for="s_nominal">Nominal per Bulan:</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Jumlah Nominal dalam Rupiah" id="s_nominal" name="s_nominal"
                        class="form-control @error('s_nominal') is-invalid @enderror" value="{{old('s_nominal')}}"
                        onkeyup="format_rp_s()">
                    @error('s_nominal') <div class="text-danger invalid-feedback mt-3">
                        Nominal potongan tidak boleh kosong.
                    </div> @enderror
                </div>
                <div class="text-success text-center" id="total_cut"></div>
            </div>
            <div class="form-group hidden individual">
                <div class="row">
                    <label class="col-sm-2 control-label" for="type">Staff :</label>
                    <div class="col-sm-6 mar-lft">
                        <select class="selectpicker" data-style="btn-primary" name="user_id" id="choose_staff">
                            <option value=""></option>
                            @foreach ($staff as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="text-danger invalid-feedback mt-3">Staff tidak boleh kosong jika
                            tipe potongan "Perorangan".</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit">Tambah</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<!--Bootstrap Select [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    function showIndividualCuts() {
        var type = document.getElementById("type-changer").value;
        if (type == 'Semua') {
            $(".individual").addClass("hidden");
            $(".all").removeClass("hidden");
        } else {
            $(".individual").removeClass("hidden");
            $(".all").addClass("hidden");
        }
    }

    $(document).ready(function () {
        $('#choose_staff').selectpicker({
            dropupAuto: false,
            liveSearch: true,
            liveSearchPlaceholder: 'Cari Staff'
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
        console.log(total);
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
        document.getElementById("total_cut").innerHTML = 'Total potongan gaji dalam jangka ' + jangka +
            ' bulan kedepan adalah Rp. ' + rupiah_t;
    }

</script>
@endsection
