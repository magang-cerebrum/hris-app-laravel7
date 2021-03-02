@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi')
@section('title','Master Data')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<style>
    #charts-achievement {
        width: 870px;
        height:450px;
    }
</style>
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Staff</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="form-group float-right">
                            <input type="text" id="cari-staff" class="form-control"
                                placeholder="Cari Staff" onkeyup="search_staff()">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="masterdata-chart-staff"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"colspan="1" 
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%">No</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">Aksi</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Nama Staff</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                                <td class="text-center">
                                    <span id="detail_staff_chart" data-toggle="modal" data-target="#modal-detail-staff-chart"
                                        style="display: inline; margin: auto 5px" data-name="{{$row->name}}" data-userid="{{$row->id}}">
                                        <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Detail Staff Chart"
                                            type="button">
                                            <i class="fa fa-bar-chart"></i>
                                        </a>
                                    </span>
                                </td>
                                <td class="text-center">{{$row->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('masterdata/achievement/chartmodal')
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    // live search
    function search_staff() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-staff");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-chart-staff");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 2; j < 3; j++ ){
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
@endsection
