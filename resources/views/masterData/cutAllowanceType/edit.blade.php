@extends('layouts/templateAdmin')
@section('content-title','Master Data / Edit Tipe Potongan dan Tunjangan Gaji')
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

        <form action="{{url('/admin/cuts-allowances/'.$cutallowancetype->id)}}" method="POST" id="edit_type">
            @csrf
            @method('put')
        </form>
        
        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="type">Tipe :</label>
                        <div class="col-sm-4 mar-lft">
                            <select class="selectpicker" data-style="btn-purple" name="type" id="type-changer" form="edit_type">
                                <option value=" "></option>
                                <option value="Semua" {{$cutallowancetype->type == 'Semua' ? 'selected' : ''}}>Semua</option>
                                <option value="Perorangan" {{$cutallowancetype->type == 'Perorangan' ? 'selected' : ''}}>Perorangan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="type">Kategori :</label>
                        <div class="col-sm-4 mar-lft">
                            <select class="selectpicker" data-style="btn-pink" name="category" id="category-changer" form="edit_type">
                                <option value=" "></option>
                                <option value="Potongan" {{$cutallowancetype->category == 'Potongan' ? 'selected' : ''}}>Potongan</option>
                                <option value="Tunjangan" {{$cutallowancetype->category == 'Tunjangan' ? 'selected' : ''}}>Tunjangan</option>
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
                                value="{{$cutallowancetype->name}}" maxlength="25" onkeyup="limit_character(this.value)" form="edit_type">
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
            <button class="btn btn-mint" type="submit" form="edit_type">Ubah</button>
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
        })
        function limit_character(value){
            var category = document.getElementById('category-changer').value
            if (value.length == 25) {
                document.getElementById('info').innerHTML = 'Nama ' + category + ' tidak boleh melebihi 25 karakter!';
            }
        }
    </script>
@endsection
