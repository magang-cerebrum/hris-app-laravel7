@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Tambah Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <style>
        table .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 80px;
        }
        .th-nip {
            width: 10px;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="Off"], .bootstrap-select.btn-group .dropdown-toggle[title="Cuti"] {
            background-color: #f55145;
            border-color: #f44336 !important;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="Off"]:hover, .bootstrap-select.btn-group .dropdown-toggle[title="Cuti"]:hover {
            background-color: #f22314 !important;
            border-color: #f22314 !important;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="WFH"] {
            background-color: #294f75;
            border-color: #25476a !important;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="WFH"]:hover {
            background-color: #1c3550 !important;
            border-color: ##1c3550 !important;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="Sakit"] {
            background-color: #0ab1fc;
            border-color: #03a9f4 !important;
        }
        .bootstrap-select.btn-group .dropdown-toggle[title="Sakit"]:hover {
            background-color: #269abc !important;
            border-color: #1b6d85 !important;
        }
    </style>
@endsection

@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Jadwal Kerja</h3>
    </div>
    <div class="panel-body">
        <form action="{{ url('/admin/schedule/edit-post')}}" method="POST" style="display: inline;" class="form-horizontal" id="form-bulan-tahun">
            @csrf
            <div class="row mar-btm">
                <div class="col-sm-2">
                    <button id="btn-delete" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Kirimkan Jadwal Yang Telah Di Edit" onclick="submit_add()">
                        <i class="btn-label fa fa-send-o"></i>
                        Edit Jadwal
                    </button>
                </div>
            </div>
            <div class="table-responsive" style="padding-bottom: 170px">
            <table id="schedule-add"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%" width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" colspan="4">Identitas</th>
                        @for ($i = 1; $i <= 31; $i++)
                            <th class="sorting text-center th-date" tabindex="0">{{'tanggal '.$i}}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <tr class="sorting text-center" tabindex="0">
                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                        <th class="sorting text-center th-nip" tabindex="0">Periode</th>
                        <th class="sorting text-center th-nip" tabindex="0">NIP</th>
                        <th class="sorting text-center th-name" tabindex="0">Nama</th>
                        @for ($i = 1; $i <= 31; $i++)
                            <td class="sorting text-center" tabindex="0">
                                <input type="checkbox" id="{{'master_'.$i}}" checked>
                            </td>
                        @endfor
                    </tr>
                    @foreach ($data as $item)
                        <?php
                            $month = switch_month($item->month, false);
                        ?>
                        <tr class="sorting text-center" tabindex="0">
                            <td class="sorting text-center" tabindex="0">
                                {{$loop->iteration}}
                                <input type="text" value="{{$item->id}}" name="id" hidden>
                            </td>
                            <td class="text-center">{{$item->month.' - '.$item->year}}</td>
                            <td class="text-center">{{$item->user_nip}}</td>
                            <td class="text-center">{{$item->user_name}}</td>
                            @for ($i = 1; $i <= 31; $i++)
                                <?php
                                    $temp_name = 'shift_'.$i;
                                    $name_shift = $item->$temp_name;
                                    $check_this_day = $item->year.'/'.$month.'/'.($i/10 < 1 ? '0'.$i : $i);
                                    $name_days = change_name_day(date('l', strtotime($check_this_day)));
                                ?>
                                <td class="text-center">
                                    <span class="{{$name_shift == '' ? 'hidden' : ''}}">{{$name_days}}</span>
                                    <select class="selectpicker {{'sub-master_'.$i}} {{$name_shift == '' ? 'hidden' : ''}}" data-style="btn-success" style="width: 100%;" name="{{'shift_'.$i.'_'.$loop->iteration}}">
                                        @foreach ($data_shift as $shift)
                                        <option value="{{$shift->id}}"
                                            class="options-select {{'select-master_'.$i.'_'.$loop->iteration}} {{'option_'.$loop->iteration}}"
                                            style="{{
                                                (
                                                    (($name_shift != 'Cuti') && ($name_shift != 'WFH')) ? ($loop->iteration == 2 ? "display: none" : ($loop->iteration == 4) ? "display: none" : "") :
                                                    ($name_shift == 'Cuti' ? ($shift->name == $name_shift ? '': 'display: none') : ($name_shift == 'WFH' ? ($shift->name == $name_shift ? '': 'display: none'): ''))
                                                )
                                            }}"
                                            {{
                                                ($shift->name == $name_shift ? 'selected': '')
                                            }}
                                            {{-- 
                                            {{($item_user->division_id == 5 ? 
                                                ($check_paid_leave == true ? 
                                                    ($loop->iteration == 2 ? 'selected' : '')
                                                    :
                                                    ($check_wfh == true ? ($loop->iteration == 4 ? 'selected' : '') : ($loop->iteration == 5 ? 'selected' : ''))
                                                )
                                                :
                                                ($check_name_days != "Saturday" && $check_name_days != "Sunday" && $check_holiday == false ?
                                                    ($check_paid_leave == true ? 
                                                    ($loop->iteration == 2 ? 'selected' : '') : ($check_wfh == true ? 
                                                    ($loop->iteration == 4 ? 'selected' : '') : ($loop->iteration == 5 ? 'selected' : ''))
                                                    )
                                                    :
                                                    ($loop->iteration == 1 ? 'selected' : '')
                                                )
                                            )}}
                                            --}}
                                            >
                                            {{$shift->name}}
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
    <script type="text/javascript">
        $(document).ready(function () {
            for (let index = 1; index < 32; index++) {
                $('#master_'+ index).on('click', function(event) {
                    if($(this).is(':checked',true)) {
                        $('.select-master_' + index + '_2').prop('selected', true);
                    }
                    else {  
                        $('.select-master_' + index + '_1').prop('selected', true);
                    }
                    $(".sub-master_" + index).selectpicker('refresh');   
                });
            }

            
        });
    </script>
@endsection