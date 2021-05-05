@extends('layouts/templateStaff')
@section('title','Jadwal Kerja Divisi')
@section('content-title','Jadwal Kerja Divisi/ Pilih Staff untuk Jadwal Kerja')
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
            <h3 class="panel-title">Pilih Staff untuk Jadwal Kerja</h3>
        </div>
        
        <form action="{{ url('/staff/schedule/add-schedule')}}" method="GET" id="form-chek-user-month" class="form-horizontal"></form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-sm-12">
                    <button id="btn-post" class="btn btn-primary btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Buat Jadwal Kerja" onclick="submit_add()" form="form-chek-user-month">
                        <i class="btn-labeled fa fa-plus"></i>
                        Buat Jadwal Kerja
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
                                autocomplete="off" id="periode" form="form-chek-user-month" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-4" id="btn_search">
                    <div class="form-group float-right">
                        <input type="text" id="cari-divisi" class="form-control"
                            placeholder="Cari Staff" onkeyup="filter_schedule()" form="form-chek-user-month">
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
                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                            <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                            <th class="sorting text-center" tabindex="0">NIP</th>
                            <th class="sorting text-center" tabindex="0">Nama</th>
                            <th class="sorting text-center" tabindex="0">Divisi</th>
                            <th class="sorting text-center" tabindex="0">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="sorting text-center" tabindex="0">
                                <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->user_id}}" form="form-chek-user-month"></td>
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
            });
            $('#filter').selectpicker({
                dropupAuto: false
            });
        });

        // Sweetalert 2
        function submit_add(){

            event.preventDefault();
            var check_user = document.querySelector('.sub_chk:checked');
            var check_year = document.getElementById('periode').value;
            if (check_year != '' && check_user != null){
                    $('#form-chek-user-month').submit();
            }
            else if (check_year == '' && check_user == null) {
                Swal.fire({
                        title: 'Sepertinya ada kesalahan...',
                        text: "Mohon isi periode dan pilih staff terlebih dahulu...",
                        icon: 'error',
                });
                return false;
            }
            else if (check_year == '') {
                Swal.fire({
                        title: 'Sepertinya ada kesalahan...',
                        text: "Mohon isi periode terlebih dahulu...",
                        icon: 'error',
                });
                return false;
            }
            else if (check_user == null){
                Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Tidak ada staff yang dipilih untuk diatur jadwalnya!",
                    icon: 'error',
                });
                event.preventDefault();
                return false;
            }
        }

        //live search
        function filter_schedule() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("cari-divisi");
            filter = input.value.toUpperCase();
            table = document.getElementById("staff-filter-schedule");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                for (j = 2; j < 6; j++ ){
                        td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
@endsection