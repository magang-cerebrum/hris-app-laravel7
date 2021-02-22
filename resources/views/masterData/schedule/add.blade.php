@extends('layouts/templateAdmin')
@section('title','Tambah Jadwal Kerja')
@section('content-title','Data Staff / Jadwal Kerja / Tambah Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        table .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 80px;
        }
        .th-nip {
            width: 10px;
        }
    </style>
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="table-responsive">
            <form action="{{ url('/admin/schedule/post')}}" method="POST" style="display: inline;" class="form-horizontal">
                @csrf
                <button id="btn-delete" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                    data-container="body" data-placement="top" data-original-title="Kirimkan Jadwal">
                    <i class="btn-label fa fa-send-o"></i>
                    Kirim Jadwal
                </button>
                <input name="count" value="{{count($data_user)}}" hidden>
                <div class="row mar-btm">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-1">
                        <label class="control-label" for="month">Bulan : </label>
                    </div>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-pink" style="width: 100%" name="month" >
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="juli">juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <label class="control-label" for="schedule">Tahun : </label>
                    </div>
                    <div class="col-sm-4">
                        <span class="input-group-addon">Tahun :</span>
                        <input id="year-input" type="text" class="form-control @error('year') is-invalid @enderror" placeholder="Tahun" name="year">
                        @error('year') <div class="text-danger invalid-feedback mt-3">
                            Tahun tidak boleh kosong.
                            </div> @enderror
                    </div>
                </div>
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Identitas</th>
                            @for ($i = 1; $i < 32; $i++)
                                <th class="sorting text-center th-date" tabindex="0">{{'tanggal '.$i}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="sorting text-center" tabindex="0">
                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                            <th class="sorting text-center th-nip" tabindex="0">NIP</th>
                            <th class="sorting text-center th-name" tabindex="0">Nama</th>
                            @for ($i = 1; $i < 32; $i++)
                                <td class="sorting text-center" tabindex="0"><input type="checkbox" id="{{'master_'.$i}}" checked></td>
                            @endfor
                        </tr>
                        @foreach ($data_user as $item_user)
                            <tr class="sorting text-center" tabindex="0">
                                <td class="sorting text-center" tabindex="0">
                                    {{$loop->iteration}}
                                    <input type="text" value="{{$item_user->id}}" name="{{'id_user_'.$loop->iteration}}" hidden>
                                </td>
                                <td class="text-center">{{$item_user->nip}}</td>
                                <td class="text-center">{{$item_user->name}}</td>
                                @for ($i = 1; $i < 32; $i++)
                                    <td class="text-center">
                                        <select class="selectpicker {{'sub-master_'.$i}}" data-style="btn-success" style="width: 100%" name="{{'shift_'.$i.'_'.$loop->iteration}}" >
                                            @foreach ($data_shift as $item_shift)
                                            <option value="{{$item_shift->id}}" class="options-select {{'select-master_'.$i.'_'.$loop->iteration}} {{'option_'.$loop->iteration}}" {{$loop->iteration == '2' ? 'selected' : ''}}>
                                                {{$item_shift->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            for (let index = 1; index < 32; index++) {
                $('#master_'+ index).on('click', function(event) {
                    if($(this).is(':checked',true)) {
                        $('.select-master_' + index + '_2').prop('selected', true);
                        // $(".sub-master_" + index).prop('disabled', false);  
                        console.log('pagi');
                    }
                    else {  
                        $('.select-master_' + index + '_1').prop('selected', true);
                        // $(".sub-master_" + index).prop('disabled', true);  
                        console.log('off');
                    }
                    $(".sub-master_" + index).selectpicker('refresh');
                });
                
            }
            
        });
    </script>
@endsection