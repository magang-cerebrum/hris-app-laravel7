@extends('layout/template')
@section('title','Tambah Jabatan')
@section('content')
<div class="boxed">
    <!--CONTENT CONTAINER-->
    <!--===================================================-->

    <div id="content-container">
        <div id="page-head">

            <div class="pad-all text-center">
                <h3>Tambah Jabatan</h3>
            </div>
        </div>


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Form Tambah Jabatan</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="/data/position" method="POST">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="hor-inputjabatanbaru">Nama Jabatan
                                    Baru:</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Jabatan Baru" name="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="text-danger invalid-feedback mt-3">
                                        Nama divisi baru tidak boleh kosong.
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
        </div>
    </div>
    @endsection
