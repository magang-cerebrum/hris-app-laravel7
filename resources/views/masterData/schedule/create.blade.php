@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Pilih Staff untuk Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Pilih Staff untuk Jadwal Kerja</h3>
    </div>
    <div class="panel-body">
            <form action="{{ url('/admin/schedule/add-schedule')}}" method="POST" style="display: inline" id="form-check-user-month" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-sm-8">
                        <button id="btn-post" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                            data-container="body" data-placement="top" data-original-title="Buat Jadwal Kerja" onclick="submit_add()">
                            <i class="btn-labeled fa fa-plus"></i>
                            Buat Jadwal Kerja
                        </button>
                        <span class="text-muted text-danger mar-hor">Pilih dahulu staff yang jadwalnya akan diatur melalui checkbox!</span>
                    </div>
                    
                </div>
                <div class="row mar-btm">
                    <label class="col-sm-1 control-label" for="filter">Divisi : </label>
                    <div class="col-sm-3">
                        <select class="selectpicker" data-style="btn-info" id="filter" onchange="filter_division()">
                            <option value=" "></option>
                            @foreach ($data_division as $division)
                            <option value="{{$division->name}}">{{$division->name}}</option>
                            @endforeach
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
                                    autocomplete="off" id="periode" readonly>
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
                            <th class="sorting text-center" tabindex="0">NIP</th>
                            <th class="sorting text-center" tabindex="0">Nama</th>
                            <th class="sorting text-center" tabindex="0">Divisi</th>
                            <th class="sorting text-center" tabindex="0">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="sorting text-center" tabindex="0">
                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->user_id}}"></td>
                                <td class="text-center">{{$item->user_nip}}</td>
                                <td class="text-center">{{$item->user_name}}</td>
                                <td class="text-center">{{$item->division_name}}</td>
                                <td class="text-center">{{$item->position_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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
        });
        $('#filter').selectpicker({
            dropupAuto: false
        });
        $('.sub_chk').on('click', function(){
            var currentRows = $(this).closest("tr");
            var valueRowsName = currentRows.find("td:eq(2)").text();
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
        var check_year = document.getElementById('periode').value;
        if (check_year != '' && check_user != null){
                $('#form-check-user-month').submit();
        }
        else if (check_year == '' && check_user == null) {
            Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Mohon isi tahun dan pilih staff terlebih dahulu...",
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
    function filter_division() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("filter");
        filter = input.value.toUpperCase();
        if(filter == ' '){$("#masterdata-filter-schedule").addClass("hidden");}
        else{$("#masterdata-filter-schedule").removeClass("hidden");}
        table = document.getElementById("masterdata-filter-schedule");
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