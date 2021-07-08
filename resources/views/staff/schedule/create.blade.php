@extends('layouts/templateStaff')
@section('title','Jadwal Kerja Divisi')
@section('content-title','Jadwal Kerja Divisi/ Pilih Staff untuk Jadwal Kerja')
@section('content-subtitle','HRIS '.$company_name)

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
                cellspacing="0" hidden>
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
                    <tbody id="body_table"></tbody>
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

            var url = '/staff/schedule/add/ajax'

            $('#periode').on('change',function(){
                var periode = document.getElementById('periode').value;
                $.ajax({
                    url: url,
                    type : 'GET',
                    data : {
                        periode :periode
                    },
                    dataType:'json', 
                    success:function(response){
                        $('#staff-filter-schedule').show();
                        var iteration = 1;
                        var data_table = response.data;
                        data_table.map( item => {
                            var tbody = document.getElementById('body_table');
                            var tr = document.createElement('tr');
                            tr.setAttribute('class', 'sorting text-center');
                            tr.setAttribute('tabindex', '0');

                            var td_1 = document.createElement('td');
                            td_1.setAttribute('class', 'text-center');
                            var td_2 = document.createElement('td');
                            td_2.setAttribute('class', 'text-center');
                            var td_3 = document.createElement('td');
                            td_3.setAttribute('class', 'text-center');
                            var td_3 = document.createElement('td');
                            td_3.setAttribute('class', 'text-center');
                            var td_4 = document.createElement('td');
                            td_4.setAttribute('class', 'text-center');
                            var td_5 = document.createElement('td');
                            td_5.setAttribute('class', 'text-center');
                            var td_6 = document.createElement('td');
                            td_6.setAttribute('class', 'text-center');

                            var input = document.createElement('input');
                            input.setAttribute('type', 'checkbox');
                            input.setAttribute('class', 'sub_chk');
                            input.setAttribute('name', 'check[]');
                            input.setAttribute('value', item.user_id);
                            input.setAttribute('form', 'form-chek-user-month');

                            td_1.appendChild(document.createTextNode(iteration));
                            td_2.appendChild(input);
                            td_3.appendChild(document.createTextNode(item.user_nip));
                            td_4.appendChild(document.createTextNode(item.user_name));
                            td_5.appendChild(document.createTextNode(item.division_name));
                            td_6.appendChild(document.createTextNode(item.position_name));

                            tr.appendChild(td_1);
                            tr.appendChild(td_2);
                            tr.appendChild(td_3);
                            tr.appendChild(td_4);
                            tr.appendChild(td_5);
                            tr.appendChild(td_6);

                            tbody.appendChild(tr);

                            iteration++;
                        })
                    },
                    error : function (jXHR, textStatus, errorThrown) {
                        console.log(jXHR, textStatus, errorThrown)
                    }
                });
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