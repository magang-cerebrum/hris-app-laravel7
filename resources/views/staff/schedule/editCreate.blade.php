@extends('layouts/templateStaff')
@section('title','Jadwal Kerja Divisi')
@section('content-title','Jadwal Kerja Divisi / Edit Jadwal / Pilih Staff untuk Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            #btn_search {
                margin-top: 10px
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-primary panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Pilih Staff Untuk Edit Jadwal Kerja</h3>
        </div>

        <form action="{{ url('/staff/schedule/edit-schedule')}}" method="GET" id="form-chek-user-month" class="form-horizontal"></form>
        
        <div class="panel-body" style="padding-top: 20px">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-sm-12">
                    <button id="btn-post" class="btn btn-primary btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Edit Jadwal Kerja" onclick="submit_add()" form="form-chek-user-month">
                        <i class="btn-labeled fa fa-pencil"></i>
                        Edit Jadwal Kerja
                    </button>
                    <span class="text-muted text-danger mar-hor">Pilih dahulu staff yang jadwalnya akan diatur melalui checkbox!</span>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-1 control-label" for="query">Periode : </label>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="periode" placeholder="Masukan Periode Jadwal Kerja" class="form-control"
                                autocomplete="off" id="periode" readonly onchange="filter_schedule()" form="form-chek-user-month">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-4" id="btn_search">
                    <div class="form-group float-right">
                        <input type="text" id="cari-divisi" class="form-control"
                            placeholder="Cari Staff" onkeyup="filter_schedule()">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="staff-filter-schedule"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sorting text-center" tabindex="0" style="width: 6%">Checkbox</th>
                            <th class="sorting text-center" tabindex="0">Periode</th>
                            <th class="sorting text-center" tabindex="0">NIP</th>
                            <th class="sorting text-center" tabindex="0">Nama</th>
                            <th class="sorting text-center" tabindex="0">Divisi</th>
                            <th class="sorting text-center" tabindex="0">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="sorting text-center" tabindex="0">
                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}" form="form-chek-user-month"></td>
                                <td class="text-center">{{$item->month.' - '.$item->year}}</td>
                                <td class="text-center">{{$item->user_nip}}</td>
                                <td class="text-center">{{$item->user_name}}</td>
                                <td class="text-center">{{$item->division_name}}</td>
                                <td class="text-center">{{$item->position_name}}</td>
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
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('js/helpers.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#master').on('click', function(e) {
                if($(this).is(':checked',true)) {
                    $(".sub_chk").prop('checked', true);  
                }
                else {  
                    $(".sub_chk").prop('checked',false);  
                }  
            });
            $('#pickadate .input-group.date').datepicker({
                format: 'mm/yyyy',
                autoclose: true,
                minViewMode: 'months',
                maxViewMode: 'years',
                startView: 'months',
                orientation: 'bottom',
                forceParse: false,
                startDate: '-1m',
                endDate: '+1m',
            });
            $('#filter').selectpicker({
                dropupAuto: false
            });
        });

        function submit_add(){
            event.preventDefault();
            var check_user = document.querySelector('.sub_chk:checked');
            if (check_user != null){
                    $('#form-chek-user-month').submit();
            }
            else {
                Swal.fire({
                        title: 'Sepertinya ada kesalahan...',
                        text: "Mohon pilih staff terlebih dahulu...",
                        icon: 'error',
                });
                return false;
            }
        }

        //live search
        function filter_schedule() {
            var input, filter, input_periode, periode, table, tr, td_periode, td_name, i, txt_periode_value, txt_name_value;
            input = document.getElementById("cari-divisi");
            filter = input.value.toUpperCase();

            input_periode = document.getElementById('periode').value;
            periode = periodic(input_periode);

            table = document.getElementById("staff-filter-schedule");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td_periode = tr[i].getElementsByTagName("td")[1];
                td_name = tr[i].getElementsByTagName("td")[3];

                if (td_periode) {
                    txt_periode_value = td_periode.textContent || td_periode.innerText;
                    txt_name_value = td_name.textContent || td_name.innerText;
                    if (filter != '' && input_periode != '') {
                        if ((txt_name_value.toUpperCase().indexOf(filter) > -1) && (txt_periode_value.indexOf(periode) > -1)) {
                            tr[i].style.display = "";
                            break;
                        }
                        else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if (filter != '') {
                        console.log('ada filter');
                        if (txt_name_value.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                        else {
                            tr[i].style.display = "none";
                        }
                    }
                    else if (input_periode != '') {
                        if (txt_periode_value.indexOf(periode) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                        else {
                            tr[i].style.display = "none";
                        }
                    }
                    else {
                        tr[i].style.display = "";
                    }
                }
            }
        }
    </script>
@endsection