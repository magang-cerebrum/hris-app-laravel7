@extends('layouts/templateAdmin')
@section('content-title','Sistem / Pengaturan Aplikasi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Pengaturan Aplikasi')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        i.form-control-feedback {
            line-height: 33px !important;
            pointer-events: visible;
        }
        i.icon {
            line-height: 33px !important;
            pointer-events: visible;
        }
        .table > tbody > tr > td,
        .table > tbody > tr > th, 
        .table > tfoot > tr > td, 
        .table > tfoot > tr > th, 
        .table > thead > tr > td, 
        .table > thead > tr > th{
            vertical-align:middle;
            text-align: center
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Pengaturan Aplikasi</h3>
        </div>

        <form class="form-horizontal" action="{{url('/admin/setting')}}" method="POST" id="setting">
            @csrf
            <div class="panel-body">
                <div class="tab-base">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#general"><i class="fa fa-globe"></i>&nbsp; Umum</a></li>
                        {{-- <li><a data-toggle="tab" href="#salary"><i class="fa fa-money"></i>&nbsp; Penggajian</a></li> --}}
                        <li><a data-toggle="tab" href="#presence"><i class="fa fa-map-marker"></i>&nbsp; Lokasi</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="general" class="tab-pane fade in active">
                            <div class="form-group has-feedback">
                                <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control setting-form" name='company_name'
                                    id="Nama Perusahaan" placeholder="Nama Perusahaan" autocomplete="off"
                                    value="{{array_key_exists('Nama Perusahaan', $data) ? $data['Nama Perusahaan'] : ''}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="company_logo" class="col-sm-3 control-label">Logo Perusahaan : </label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control setting-form" id="Logo Perusahaan">
                                </div>
                            </div>
                            @if (array_key_exists('Logo Perusahaan', $data))
                                <div class="form-group">
                                    <label for="current_logo" class="col-sm-3 control-label">Logo Perusahaan saat ini : </label>
                                    <img class="brand-icon" name='company_logo' id="current_logo" src="{{ asset('img/' . $data['Logo Perusahaan'])}}" alt="Logo Perusahaan">
                                </div>
                            @endif
                        </div>
                        {{-- <div id="salary" class="tab-pane fade">
                            <div class="form-group">
                                <label for="payroll_date" class="col-sm-3 control-label">Tanggal Gajian : </label>
                                <div class="col-sm-2">
                                    <select class="selectpicker setting-select-form" data-live-search="true" data-width="100%"
                                        id="Tanggal Gajian" name='payroll_date'>
                                        @for ($i = 01; $i <= 28; $i++)
                                            <option value="{{($i / 10 < 1 ? '0' . $i : $i)}}" {{$data['Tanggal Gajian'] == $i ? 'selected' : ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        <div id="presence" class="tab-pane fade">
                            <div class="form-group has-feedback">
                                <label for="office_latitude" class="col-sm-3 control-label">Latitude : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control setting-form" name='office_latitude'
                                    id="Latitude Kantor" placeholder="Latitude Kantor" autocomplete="off"
                                    value="{{array_key_exists('Latitude Kantor', $data) ? $data['Latitude Kantor'] : ''}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="office_longitude" class="col-sm-3 control-label">Longitude : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control setting-form" name='office_longitude'
                                    id="Longitude Kantor" placeholder="Longitude Kantor" autocomplete="off"
                                    value="{{array_key_exists('Longitude Kantor', $data) ? $data['Longitude Kantor'] : ''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="button" id="submit-form-button"
                style="cursor: pointer" disabled> Simpan</button>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $(".setting-form").on("input", function() {
                $(this).css('border','1px solid #8bc34a');
                $(this).addClass('changed');
                if(!$(this).next().is('i')){
                    $('<i class="fa fa-exclamation-triangle form-control-feedback" title="Dirubah"></i>').insertAfter(this);
                }
                $('#submit-form-button').attr('disabled', false);
            });
            $(".setting-select-form").on("change", function() {
                $(this).css('border','1px solid #8bc34a');
                $(this).addClass('changed');
                $('#modal-button').attr('disabled', false);
            });
            $('#payroll_date').selectpicker({
                dropupAuto : false
            });

            $('#submit-form-button').on('click', function (event) {
                event.preventDefault;
                Swal.fire({
                    width: 600,
                    title: 'Konfirmasi',
                    text: 'Anda yakin ingin menyimpan perubahan pengaturan baru?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value == true) {
                            $('#setting').submit();
                    } else {
                        return false;
                    }} 
                );
            });
        });
    </script>
@endsection
