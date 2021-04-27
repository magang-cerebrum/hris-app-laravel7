@extends('layouts/templateStaff')
@section('title','Gaji')
@section('content-title','Gaji Staff / Daftar Gaji Staff')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">{{'Daftar Gaji '.$name}}</h3>
        </div>
        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <label class="col-sm-1 control-label" for="query">Periode : </label>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="periode" placeholder="Cari Periode Gaji" class="form-control"
                                autocomplete="off" id="periode" readonly onchange="filter_periode()">
                        </div>
                    </div>
                </div>
            </div>
            @if(!$data->isEmpty())
            <div class="table-responsive">
                <table id="salary-result" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            @if ($data[0] == null)
                            <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data gaji ditemukan!</th>
                            @else
                            <th class="sorting_asc text-center">File Slip Gaji</th>
                            <th class="sorting_asc text-center">Nama</th>
                            <th class="sorting_asc text-center">Divisi</th>
                            <th class="sorting_asc text-center">Periode</th>
                            <th class="sorting_asc text-center">Total Jam Kerja Seharusnya</th>
                            <th class="sorting_asc text-center">Total Jam Kerja</th>
                            <th class="sorting_asc text-center">Total Keterlambatan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            @if ($item->status == "Accepted")
                                <tr>
                                    <?php
                                        $string_time_work = split_time($item->total_work_time);
                                        $string_time_late = split_time($item->total_late_time);
                                        $default_salary = rupiah($item->default_salary);
                                        $total_fine = rupiah($item->total_fine);
                                        $total_salary_allowance = rupiah($item->total_salary_allowance);
                                        $total_salary_cut = rupiah($item->total_salary_cut);
                                        $total_salary = rupiah($item->total_salary);
                                    ?>
                                    <td class="text-center">
                                        <a href="{{ asset('/file_slip/'.$item->file_salary)}}" target="blank">
                                            <button type="button" class="btn btn-pink btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="top"
                                                data-original-title="Buka CV">
                                                <i class="fa fa-file icon-lg"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td class="text-center">{{$item->user_name}}</td>
                                    <td class="text-center">{{$item->division}}</td>
                                    <td class="text-center">{{$item->month . ' - ' . $item->year}}</td>
                                    <td class="text-center">{{$item->total_default_hour.' Jam'}}</td>
                                    <td class="text-center">{{$string_time_work}}</td>
                                    <td class="text-center">{{$string_time_late}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-danger text-bold">Ma'af anda belum memiliki data gaji</div>
            @endif
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{ asset('js/helpers.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#pickadate .input-group.date').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            minViewMode: 'months',
            maxViewMode: 'years',
            startView: 'months',
            orientation: 'bottom',
            forceParse: false,
            endDate: '0m',
        });
    });

    function filter_periode(){
        var value = document.getElementById('periode').value;
        var periode = periodic(value);
        if (value != '') {
            var table = document.getElementById('salary-result');
            var tr = table.getElementsByTagName('tr');
            for (i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[3];
                var td_value = td.textContent || td.innerText;
                if (td_value.indexOf(periode) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    };
</script>
@endsection