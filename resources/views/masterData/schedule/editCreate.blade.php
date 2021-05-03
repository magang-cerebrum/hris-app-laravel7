@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Edit Jadwal / Pilih Staff untuk Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Pilih Staff Untuk Edit Jadwal Kerja</h3>
        </div>
        
        <form action="{{ url('/admin/schedule/edit-schedule')}}" method="POST" id="form-check-user-month" class="form-horizontal">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row">
                <div class="col-sm-8">
                    <button id="btn-post" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Buat Jadwal Kerja" onclick="submit_add()" form="form-check-user-month">
                        <i class="btn-labeled fa fa-pencil"></i>
                        Edit Jadwal Kerja
                    </button>
                    <span class="text-muted text-danger mar-hor">Pilih dahulu staff yang jadwalnya akan diatur melalui checkbox!</span>
                </div>    
            </div>
            <div class="row mar-btm">
                <label class="col-sm-1 control-label" for="filter">Divisi : </label>
                <div class="col-sm-3">
                    <select class="selectpicker" data-style="btn-info" id="filter" onchange="filter_division()" form="form-check-user-month">
                        <option value=" "></option>
                        <option value="Devtech">Devtech</option>
                        <option value="Sales">Sales</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Academic">Academic</option>
                        <option value="Quality Control">Quality Control</option>
                        <option value="Operation">Operation</option>
                    </select>
                </div>
                <label class="col-sm-1 control-label" for="query">Periode : </label>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="periode" placeholder="Masukan Periode Jadwal Kerja" class="form-control"
                                autocomplete="off" id="periode" readonly onchange="filter_division()" form="form-check-user-month">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-filter-schedule"
                class="table table-striped table-bordered no-footer dtr-inline collapsed hidden"
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
                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}" form="form-check-user-month"></td>
                                <td class="text-center">{{$item->month.' - '.$item->year}}</td>
                                <td class="text-center">{{$item->user_nip}}</td>
                                <td class="text-center">{{$item->user_name}}</td>
                                <td class="text-center">{{$item->division_name}}</td>
                                <td class="text-center">{{$item->position_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="informations">
                    <label class="control-label" for="info">Staff terpilih : </label>
                    <span class="text-danger" id="info"></span>
                </div>
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
        var queue = new Array();
        $(document).ready(function () {
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
            $('.sub_chk').on('click', function(){
                var currentRows = $(this).closest("tr");
                var valueRowsName = currentRows.find("td:eq(3)").text();
                if($(this).is(':checked',true)) {
                    queue.push(valueRowsName+', ');
                } else {
                    queue.splice(queue.indexOf(valueRowsName+', '), 1);
                }
                $('#info').html(queue);
                console.log(queue);
            });
        });

        // Sweetalert 2
        function submit_add(){
            event.preventDefault();
            var check_user = document.querySelector('.sub_chk:checked');
            if (check_user != null){
                    $('#form-check-user-month').submit();
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
        function filter_division() {
            var input, filter, input_periode, periode, table, tr, td_periode, td_divisi, i, txt_periode_value, txt_divisi_value;
            input = document.getElementById("filter");
            filter = input.value;

            input_periode = document.getElementById('periode').value;
            periode = periodic(input_periode);

            if (filter != ' ' && input_periode != '') {
                $("#masterdata-filter-schedule").removeClass("hidden");
                table = document.getElementById("masterdata-filter-schedule");
                tr = table.getElementsByTagName("tr");
                for (i = 1; i < tr.length; i++) {
                    td_periode = tr[i].getElementsByTagName("td")[1];
                    td_divisi = tr[i].getElementsByTagName("td")[4];

                    txt_periode_value = td_periode.textContent || td_periode.innerText;
                    txt_divisi_value = td_divisi.textContent || td_divisi.innerText;

                    if ((txt_divisi_value.indexOf(filter) > -1) && (txt_periode_value.indexOf(periode) > -1)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            else if (filter != ' ') {
                $("#masterdata-filter-schedule").removeClass("hidden");
                table = document.getElementById("masterdata-filter-schedule");
                tr = table.getElementsByTagName("tr");
                for (i = 1; i < tr.length; i++) {
                    td_divisi = tr[i].getElementsByTagName("td")[4];

                    txt_divisi_value = td_divisi.textContent || td_divisi.innerText;

                    if (txt_divisi_value.indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            else if (input_periode != '') {
                $("#masterdata-filter-schedule").removeClass("hidden");
                table = document.getElementById("masterdata-filter-schedule");
                tr = table.getElementsByTagName("tr");
                for (i = 1; i < tr.length; i++) {
                    td_periode = tr[i].getElementsByTagName("td")[1];

                    txt_periode_value = td_periode.textContent || td_periode.innerText;

                    if (txt_periode_value.indexOf(periode) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            else {
                $("#masterdata-filter-schedule").addClass("hidden");
            }
        }
    </script>
@endsection