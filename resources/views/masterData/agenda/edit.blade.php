@extends('layouts/templateAdmin')
@section('content-title','Master Data / Agenda Kerja / Edit Agenda Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Agenda Kerja')

@section('head')
    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css' )}}" rel="stylesheet">
    <link href="{{ asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" )}}" rel="stylesheet">
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
            <h3 class="panel-title">Form Edit Agenda Kerja</h3>
        </div>

        <form action="/admin/agenda/{{$agenda->id}}" method="POST" id="edit_agenda">
            @csrf
            @method('put')
        </form>
        
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Judul Kegiatan:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Judul Kegiatan" name="title" value="{{$agenda->title}}"
                                class="form-control @error('title') is-invalid @enderror" form="edit_agenda">
                            @error('title') <div class="text-danger invalid-feedback mt-3">
                                Judul kegiatan tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="textarea-description">Deskripsi Kegiatan:</label>
                        <div class="col-sm-10">
                            <textarea id="textarea-description" rows="2"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Detail Deskripsi Kegiatan" name="description"
                                value="{{old('description')}}" form="edit_agenda">{{$agenda->description}}</textarea>
                            @error('description') <div class="text-danger invalid-feedback mt-3">
                                Deskripsi kegiatan tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Tanggal :</label>
                        <div id="datepicker-input-agenda">
                            <div class="col-sm-10">
                                <div class="input-group input-daterange">
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror"
                                        placeholder="Tanggal Mulai" name="start_date" id="start_date"
                                        value="{{explode(" ", $agenda->start_event)[0]}}" autocomplete="off" form="edit_agenda">
                                    <span class="input-group-addon">sampai</span>
                                    <input type="text" class="form-control @error('end_date') is-invalid @enderror"
                                        placeholder="Tanggal Berakhir" name="end_date" id="end_date"
                                        value="{{explode(" ", $agenda->end_event)[0]}}" autocomplete="off" form="edit_agenda">
                                </div>
                                @error('start_date') <div class="text-danger invalid-feedback mt-3">
                                    Tanggal mulai kegiatan tidak boleh kosong.
                                </div> @enderror
                                @error('end_date') <div class="text-danger invalid-feedback mt-3">
                                    Tanggal akhir kegiatan tidak boleh kosong.
                                </div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Waktu Mulai:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input id="timepicker-input-start" type="text" form="edit_agenda"
                                    class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{explode(" ", $agenda->start_event)[1]}}">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                            @error('start_time') <div class="text-danger invalid-feedback mt-3">
                                Jam mulai kegiatan tidak boleh kosong.
                            </div> @enderror
                        </div>
                        <label class="col-sm-2 control-label">Waktu Selesai:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input id="timepicker-input-end" type="text" form="edit_agenda"
                                    class="form-control @error('start_time') is-invalid @enderror" name="end_time" value="{{explode(" ", $agenda->end_event)[1]}}">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                            @error('end_time') <div class="text-danger invalid-feedback mt-3">
                                Jam selesai kegiatan tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Warna Kalendar:</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <input id="color_radio-1" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#1C3550" {{$agenda->calendar_color == '#1C3550' ? 'checked' : ''}}>
                                <label for="color_radio-1" class="color-radio">
                                    <div class="color-available" style="background-color: #1C3550"></div>
                                </label>
                                <input id="color_radio-2" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#0391D1" {{$agenda->calendar_color == '#0391D1' ? 'checked' : ''}}>
                                <label for="color_radio-2" class="color-radio">
                                    <div class="color-available" style="background-color: #0391D1"></div>
                                </label>
                                <input id="color_radio-3" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#79AF3A" {{$agenda->calendar_color == '#79AF3A' ? 'checked' : ''}}>
                                <label for="color_radio-3" class="color-radio">
                                    <div class="color-available" style="background-color: #79AF3A"></div>
                                </label>
                                <input id="color_radio-4" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#DB9A00" {{$agenda->calendar_color == '#DB9A00' ? 'checked' : ''}}>
                                <label for="color_radio-4" class="color-radio">
                                    <div class="color-available" style="background-color: #DB9A00"></div>
                                </label>
                                <input id="color_radio-5" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#F22314" {{$agenda->calendar_color == '#F22314' ? 'checked' : ''}}>
                                <label for="color_radio-5" class="color-radio">
                                    <div class="color-available" style="background-color: #F22314"></div>
                                </label>
                                <input id="color_radio-6" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#1F897F" {{$agenda->calendar_color == '#1F897F' ? 'checked' : ''}}>
                                <label for="color_radio-6" class="color-radio">
                                    <div class="color-available" style="background-color: #1F897F"></div>
                                </label>
                                <input id="color_radio-7" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#953CA4" {{$agenda->calendar_color == '#953CA4' ? 'checked' : ''}}>
                                <label for="color_radio-7" class="color-radio">
                                    <div class="color-available" style="background-color: #953CA4"></div>
                                </label>
                                <input id="color_radio-8" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#ED417B" {{$agenda->calendar_color == '#ED417B' ? 'checked' : ''}}>
                                <label for="color_radio-8" class="color-radio">
                                    <div class="color-available" style="background-color: #ED417B"></div>
                                </label>
                                <input id="color_radio-9" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#2B323A" {{$agenda->calendar_color == '#2B323A' ? 'checked' : ''}}>
                                <label for="color_radio-9" class="color-radio">
                                    <div class="color-available" style="background-color: #2B323A"></div>
                                </label>
                                <input id="color_radio-10" class="magic-radio" type="radio" name="calendar_color" form="edit_agenda"
                                    value="#FF8806" {{$agenda->calendar_color == '#FF8806' ? 'checked' : ''}}>
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
            <a href="{{url('/admin/agenda')}}" class="btn btn-dark">Kembali ke Data Agenda</a>
            <button class="btn btn-mint" type="submit" form="edit_agenda">Simpan</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js' )}}"></script>
    <script src="{{ asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js" )}}"></script>
    <script>
        $(document).ready(function () {
            $('#datepicker-input-agenda .input-daterange').datepicker({
                format: 'yyyy/mm/dd',
                orientation: 'top',
                autoclose: true,
                todayHighlight: true,
                startDate: '0d'
            });
            $('#timepicker-input-start').timepicker({
                showMeridian: false
            });
            $('#timepicker-input-end').timepicker({
                showMeridian: false
            });
            $('#timepicker-input-start').change(function () {
                var get = document.getElementById('timepicker-input-start').value;
                document.getElementById('timepicker-input-start').value = get + ':00';
            });
            $('#timepicker-input-end').change(function () {
                var get = document.getElementById('timepicker-input-end').value;
                document.getElementById('timepicker-input-end').value = get + ':00';
            });
        });
    </script>
@endsection
