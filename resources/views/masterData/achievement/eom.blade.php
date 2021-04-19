@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Karyawan Terbaik')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
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
    <div class="panel-body">
        <form action="/admin/achievement/eom/chosed" method="POST">
            <input type="hidden" name="date" value="{{date('m/Y')}}">
            @csrf
        <table class="table table-hover table-vcenter">
            <thead>
                <tr>
                    <th>Divisi</th>
                   
                </tr>
            </thead>
            <tbody>
                

                

                {{-- <tr>
                    <td>
                        {{$dataItems->staff_name}}
                    </td>
                    <td>
                        {{$dataItems->division_name}}
                    </td>
                    <td>
                        {{$dataItems->performance_score}}
                    </td>
                </tr> --}}
                    @foreach ($divisions as $divisionsItems)
                    <tr>
                        <td><a href="#collapseRow{{$loop->iteration}}" data-toggle="collapse" data-id="">{{$divisionsItems->name}}</a></td>    
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
                                    @foreach ($data->where('division_name','=',$divisionsItems->name) as $dataItem)
                                    <tr>  
                                        {{-- {{dd($dataItem)}} --}}
                                        <td class="text-center">{{$dataItem->staff_name}}</td>
                                        <td class="text-center">{{$dataItem->achievement_score}}</td>
                                        <td class="text-center">{{$dataItem->performance_score}}</td>
                                        <td class="text-center"><input type="radio" name="radio_input_eom" id="radio-eom{{$loop->iteration}}" value="{{$dataItem->staff_id}}"></td>
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
        <button type="submit" class="btn btn-danger">Pilih</button>
    </form>
        {{-- <div class="accordian-body collapse" id="collapseRow">
            <table class="table table-condensed">
                <thead><th>ahahah</th></thead>
            </table>
        </div> --}}
    </div>
</div>

@endsection
@section('script')
    {{-- <script src="{{asset("/js/footable.all.min.js")}}"></script>
    $(document).ready(function(){
        $('#accordion_table').footable().on('footable_row_expanded', function(e) {
            $('#accordion_table tbody td.footable-detail-show').not(e.row).each(function() {
                $('#accordion_table').data('footable').toggleDetail(this);
            });
        });
        
    }); --}}
    <script>
    
    </script>
    
@endsection