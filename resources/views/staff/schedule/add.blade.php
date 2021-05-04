@extends('layouts/templateStaff')
@section('title','Jadwal Kerja Divisi')
@section('content-title','Jadwal Kerja Divisi / Tambah Jadwal Kerja Divisi')
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
    <div class="panel panel-primary panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">{{'Form Tambah Jadwal Kerja Bulan '.$month.' - '.$year}}</h3>
        </div>
        
        <form action="{{ url('/staff/schedule/post')}}" method="POST" class="form-horizontal" id="form-bulan-tahun">
            @csrf
        </form>
        
        <div class="panel-body" style="padding-top: 20px">
            <input name="count" value="{{count($data_user)}}" form="form-bulan-tahun" hidden>
            <input name="month" value="{{$month}}" form="form-bulan-tahun" hidden>
            <input name="year" value="{{$year}}" form="form-bulan-tahun" hidden>
            <div class="row mar-btm">
                <div class="col-sm-2">
                    <button id="btn-delete" class="btn btn-primary btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Kirimkan Jadwal" form="form-bulan-tahun">
                        <i class="btn-label fa fa-send-o"></i>
                        Kirim Jadwal
                    </button>
                </div>
            </div>
            <div class="table-responsive" style="padding-bottom: 150px">
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Identitas</th>
                            @for ($i = 1; $i <= $count_day; $i++)
                                <th class="sorting text-center th-date" tabindex="0">{{'tanggal '.$i}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="sorting text-center" tabindex="0">
                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                            <th class="sorting text-center th-nip" tabindex="0">NIP</th>
                            <th class="sorting text-center th-name" tabindex="0">Nama</th>
                            @for ($i = 1; $i <= $count_day; $i++)
                                <td class="sorting text-center" tabindex="0">
                                    <input type="checkbox" id="{{'master_'.$i}}" checked>
                                </td>
                            @endfor
                        </tr>
                        @foreach ($data_user as $item_user)
                            <?php
                                $temp_paid_leave = array();
                                foreach ($data_paid_leave as $item_paid_leave) {
                                    if($item_paid_leave->user_id == $item_user->id) {
                                        array_push($temp_paid_leave, $item_paid_leave->date);
                                    }
                                }
                                $temp_wfh = array();
                                foreach ($data_wfh as $item_wfh) {
                                    if($item_wfh->user_id == $item_user->id) {
                                        array_push($temp_wfh, $item_wfh->date);
                                    }
                                }
                            ?>
                            <tr class="sorting text-center" tabindex="0">
                                <td class="sorting text-center" tabindex="0">
                                    {{$loop->iteration}}
                                    <input type="text" value="{{$item_user->id}}" name="{{'id_user_'.$loop->iteration}}" form="form-bulan-tahun" hidden>
                                </td>
                                <td class="text-center">{{$item_user->nip}}</td>
                                <td class="text-center">{{$item_user->name}}</td>
                                @for ($i = 1; $i <= $count_day; $i++)
                                    <?php
                                        $check_this_day = $year.'/'.$number_of_month.'/'.($i/10 < 1 ? '0'.$i : $i);
                                        $check_name_days = date('l', strtotime($check_this_day));
                                        $check_holiday = false;
                                        $check_paid_leave = false;
                                        $check_wfh = false;
                                        foreach ($data_holiday as $data) {
                                            if ($data->date == $year.'-'.$number_of_month.'-'.($i/10 < 1 ? '0'.$i : $i)){
                                                $check_holiday = true;
                                            }
                                        }
                                        foreach ($temp_paid_leave as $item_leave) {
                                            if ($item_leave == $year.'-'.$number_of_month.'-'.($i/10 < 1 ? '0'.$i : $i)){
                                                $check_paid_leave = true;
                                            }
                                        }
                                        foreach ($temp_wfh as $item_wfh) {
                                            if ($item_wfh == $year.'-'.$number_of_month.'-'.($i/10 < 1 ? '0'.$i : $i)){
                                                $check_wfh = true;
                                            }
                                        }
                                    ?>
                                    <td class="text-center">
                                        <select class="selectpicker {{'sub-master_'.$i}}" data-style="btn-success" style="width: 100%" name="{{'shift_'.$i.'_'.$loop->iteration}}" form="form-bulan-tahun">
                                            @foreach ($data_shift as $shift)
                                                <option value="{{$shift->id}}"
                                                    class="options-select {{'select-master_'.$i.'_'.$loop->iteration}} {{'option_'.$loop->iteration}}"
                                                    style="{{
                                                        (
                                                            $loop->iteration == 2 ? ($check_paid_leave == false ? "display: none" : "") :
                                                            ($loop->iteration == 3 ? "display: none" : 
                                                            ($loop->iteration == 4 ? ($check_wfh == false ? "display: none" : "") : ""))
                                                        )
                                                    }}"
                                                    {{($item_user->division_id == 5 ? 
                                                        ($check_paid_leave == true ? 
                                                            ($loop->iteration == 2 ? 'selected' : '')
                                                            :
                                                            ($check_wfh == true ? ($loop->iteration == 4 ? 'selected' : '') : 
                                                            ($loop->iteration == 5 ? 'selected' : ''))
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
                        $('.select-master_' + index + '_5').prop('selected', true);
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