@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tambah Tipe Potongan dan Tunjangan Gaji')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Tipe Potongan dan Tunjangan Gaji')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Potongan dan Tunjangan Gaji</h3>
        </div>
        
        <form action="{{url('/admin/cuts-allowances')}}" method="POST" id="create_type">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="type">Tipe :</label>
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-purple" name="type" id="type-changer" form="create_type">
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
                        <div class="col-sm-4">
                            <select class="selectpicker" data-style="btn-pink" name="category" id="category-changer" form="create_type">
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
                                name="name" placeholder="Informasi potongan/tunjangan" id="name"
                                value="{{old('name')}}" maxlength="25" onkeyup="limit_character(this.value)" form="create_type">
                            @error('name') <div class="text-danger invalid-feedback mt-3">Mohon isi nama <span id="category-name"></span>.</div>
                            @enderror
                            <div id="info" class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href="{{url('/admin/cuts-allowances')}}" class="btn btn-dark">Kembali ke Tipe Potongan dan Tunjangan</a>
            <button class="btn btn-mint" type="submit" form="create_type">Tambah</button>
        </div>
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
        });
        function limit_character(value){
            var category = document.getElementById('category-changer').value
            if (value.length == 25) {
                document.getElementById('info').innerHTML = 'Nama ' + category + ' tidak boleh melebihi 25 karakter!';
            }
        }
    </script>
@endsection
