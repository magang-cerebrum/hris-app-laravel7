@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift / Tambah Data Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')

@section('head')
    <link href="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css")}}" rel="stylesheet">
    <style>
        .color-radio {
            width: 50px;
            height: 18px;
            position: relative;
        }
        .color-available {
            width: 25px;
            height: 18px;
            position: absolute;
            right: 0;
        }
    </style>
@endsection

@section('content')
    <div class="panel  panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Shift</h3>
        </div>
        
        <form action="/admin/shift" method="POST" id="form_create">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Nama Shift
                            Baru:</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Nama Shift Baru" name="name" form="form_create"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="text-danger invalid-feedback mt-3">
                                Nama shift baru tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Jam Masuk:</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input id="timepicker-input-shift-masuk" type="text" class="form-control"
                                    name="start_working_time" form="form_create">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Jam Keluar:</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input id="timepicker-input-shift-keluar" type="text" class="form-control"
                                    name="end_working_time" form="form_create">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Warna Kalendar:</label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <input id="color_radio-1" class="magic-radio" type="radio" name="calendar_color"
                                    value="#1C3550" checked form="form_create">
                                <label for="color_radio-1" class="color-radio">
                                    <div class="color-available" style="background-color: #1C3550"></div>
                                </label>
                                <input id="color_radio-2" class="magic-radio" type="radio" name="calendar_color"
                                    value="#0391D1" form="form_create">
                                <label for="color_radio-2" class="color-radio">
                                    <div class="color-available" style="background-color: #0391D1"></div>
                                </label>
                                <input id="color_radio-3" class="magic-radio" type="radio" name="calendar_color"
                                    value="#79AF3A" form="form_create">
                                <label for="color_radio-3" class="color-radio">
                                    <div class="color-available" style="background-color: #79AF3A"></div>
                                </label>
                                <input id="color_radio-4" class="magic-radio" type="radio" name="calendar_color"
                                    value="#DB9A00" form="form_create">
                                <label for="color_radio-4" class="color-radio">
                                    <div class="color-available" style="background-color: #DB9A00"></div>
                                </label>
                                <input id="color_radio-5" class="magic-radio" type="radio" name="calendar_color"
                                    value="#F22314" form="form_create">
                                <label for="color_radio-5" class="color-radio">
                                    <div class="color-available" style="background-color: #F22314"></div>
                                </label>
                                <input id="color_radio-6" class="magic-radio" type="radio" name="calendar_color"
                                    value="#1F897F" form="form_create">
                                <label for="color_radio-6" class="color-radio">
                                    <div class="color-available" style="background-color: #1F897F"></div>
                                </label>
                                <input id="color_radio-7" class="magic-radio" type="radio" name="calendar_color"
                                    value="#953CA4" form="form_create">
                                <label for="color_radio-7" class="color-radio">
                                    <div class="color-available" style="background-color: #953CA4"></div>
                                </label>
                                <input id="color_radio-8" class="magic-radio" type="radio" name="calendar_color"
                                    value="#ED417B" form="form_create">
                                <label for="color_radio-8" class="color-radio">
                                    <div class="color-available" style="background-color: #ED417B"></div>
                                </label>
                                <input id="color_radio-9" class="magic-radio" type="radio" name="calendar_color"
                                    value="#2B323A" form="form_create">
                                <label for="color_radio-9" class="color-radio">
                                    <div class="color-available" style="background-color: #2B323A"></div>
                                </label>
                                <input id="color_radio-10" class="magic-radio" type="radio" name="calendar_color"
                                    value="#FF8806" form="form_create">
                                <label for="color_radio-10" class="color-radio">
                                    <div class="color-available" style="background-color: #FF8806"></div>
                                </label>
                            </div>
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
    <script src="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#timepicker-input-shift-masuk').timepicker({
                showMeridian: false
            });
            $('#timepicker-input-shift-keluar').timepicker({
                showMeridian: false
            });
            $('#timepicker-input-shift-masuk').change(function (){
                var get = document.getElementById('timepicker-input-shift-masuk').value;
                document.getElementById('timepicker-input-shift-masuk').value = get + ':00';
            });
            $('#timepicker-input-shift-keluar').change(function (){
                var get = document.getElementById('timepicker-input-shift-keluar').value;
                document.getElementById('timepicker-input-shift-keluar').value = get + ':00';
            });
        });
    
    </script>
@endsection
