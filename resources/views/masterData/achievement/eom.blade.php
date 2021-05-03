@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Karyawan Terbaik')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("css/footable.core.css")}}">
    <style>
        .hiddenRow{
            padding: 0 !important;
        }
    </style>
@endsection

@section('content') 
    <div class="panel panel-bordered panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Pemilihan Karyawan Terbaik</h3>
        </div>

        <form action="/admin/achievement/eom/chosed" method="POST" id="eom">@csrf</form>

        <div class="panel-body" style="padding-top: 20px">
            <div id="pickadate">
                <div class="input-group date">
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button" style="z-index: 2">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                    <input type="text" name="date" id="first_periode" form="eom" placeholder="Pilih Tanggal" 
                        class="form-control" autocomplete="off" readonly>
                </div>
            </div> 
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th>Divisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisions as $divisionsItems)
                        <tr>
                            <td>
                                <a href="#collapseRow{{$loop->iteration}}" data-toggle="collapse" data-id="">{{$divisionsItems->name}}</a>
                            </td>    
                        </tr>
                        <tr>
                            <td class="hiddenRow">
                                <div class="accordian-body collapse" id="collapseRow{{$loop->iteration}}">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr class="danger">
                                                <th class="text-center">Nama Karyawan :</th>
                                                <th class="text-center">Score Achievement :</th>
                                                <th class="text-center">Score Performa :</th>
                                                <th class="text-center">Pilih Karyawan Terbaik : </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->where('division_id','=',$divisionsItems->id) as $dataItem)
                                                <tr>  
                                                    <td class="text-center">{{$dataItem->staff_name}}</td>
                                                    <td class="text-center">{{$dataItem->achievement_score}}</td>
                                                    <td class="text-center">{{$dataItem->performance_score}}</td>
                                                    <td class="text-center">
                                                        <input form="eom" type="radio" name="radio_input_eom" id="radio-eom{{$loop->iteration}}" value="{{$dataItem->staff_id}}">
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger" form="eom">Pilih</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script>
        $('#pickadate .input-group.date').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            minViewMode: 'months',
            maxViewMode: 'years',
            startView: 'months',
            orientation: 'bottom',
            forceParse: false,
            startDate:'-1m',
            endDate:'0d'
        });
    </script> 
@endsection