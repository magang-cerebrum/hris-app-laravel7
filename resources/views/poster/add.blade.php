@extends('layouts/templateAdmin')
@section('title', 'Sistem')
@section('content-title', 'Poster / Tambah Data Poster')
@section('content-subtitle', 'HRIS '.$company_name)

@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Tambah Poster Dashboard</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url('/admin/poster/add')}}" method="POST" enctype="multipart/form-data"
            id="form_add">
            @csrf
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="hor-inputposterbaru">Nama Poster:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Nama Poster Baru" name="name" form="form_add"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama poster baru tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="file-upload">File Poster : </label>
                    <div class="col-sm-10">
                        <span class="btn btn-primary btn-file">
                            Pilih File ... <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" id="file-upload" form="form_add">
                        </span>
                        <span id="file-label" class="mar-lft"></span>
                        @error('file') <div class="text-danger invalid-feedback mt-3">
                            Anda belum memasukan file untuk dijadikan poster.
                        </div> @enderror
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" form="form_add">Tambah</button>
    </div>
    </form>
</div>
@endsection

@section('script')
    <script>
        $('#file-upload').change(function() {
            var file = $('#file-upload')[0].files[0].name;
            $('#file-label').text(file);
        });
    </script>
@endsection