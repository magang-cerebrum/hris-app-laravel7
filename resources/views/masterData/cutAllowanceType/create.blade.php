@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tambah Tipe Potongan dan Tunjangan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tipe Potongan dan Tunjangan Gaji')
@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Tambah Potongan dan Tunjangan Gaji</h3>
    </div>
    <form class="form-horizontal" action="{{url('/admin/cuts-allowances')}}" method="POST">
        @csrf
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="type">Tipe :</label>
                    <div class="col-sm-4 mar-lft">
                        <select class="selectpicker" data-style="btn-purple" name="type" id="type-changer">
                            <option value=" " selected></option>
                            <option value="Semua">Semua</option>
                            <option value="Perorangan">Perorangan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="type">Kategori :</label>
                    <div class="col-sm-4 mar-lft">
                        <select class="selectpicker" data-style="btn-pink" name="category" id="category-changer">
                            <option value=" " selected></option>
                            <option value="Potongan">Potongan</option>
                            <option value="Tunjangan">Tunjangan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="name">Nama <span id="category-name"></span>:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" placeholder="Informasi potongan/tunjangan"
                            value="{{old('name')}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">Mohon isi nama <span id="category-name"></span>.</div>
                        @enderror
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
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#category-changer').on('change',function () {
            var type = document.getElementById('category-changer').value
            $('#category-name').text(type)
        })
    })
</script>
@endsection
