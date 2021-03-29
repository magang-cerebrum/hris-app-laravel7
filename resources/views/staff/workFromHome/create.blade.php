@extends('layouts/templateStaff')
@section('title', 'WFH')
@section('content-title', 'Work From Home / Pengajuan WFH')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<style>
    .row{
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="panel panel-primary panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Pengajuan WFH</h3>
    </div>
    <form class="form-horizontal" action="{{url('/staff/wfh')}}" method="POST">
        @csrf
        <div class="panel-body">
            <input type="hidden" name="user_id" class="form-control" value="{{$id}}">
            <div class="yearly">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal :</label>
                    <div id="datepicker-input-cuti">
                        <div class="col-sm-10">
                            <div class="input-group input-daterange">
                                <input type="text"
                                    class="form-control @error('wfh_date_start') is-invalid @enderror"
                                    placeholder="Tanggal Mulai" name="wfh_date_start" id="wfh_date_start"
                                    value="{{old('wfh_date_start')}}" autocomplete="off" onchange="result_end()">
                                <span class="input-group-addon">sampai</span>
                                <input type="text"
                                    class="form-control @error('wfh_date_end') is-invalid @enderror"
                                    placeholder="Tanggal Berakhir" name="wfh_date_end" id="wfh_date_end"
                                    value="{{old('wfh_date_start')}}" autocomplete="off" onchange="result_end()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="text-info text-center" id="yearly_info"></div></div>
                <div class="row">
                    <label class="col-md-2 control-label" for="demo-textarea-input">Keterangan Keperluan : </label>
                    <div class="col-md-10">
                        <textarea id="needs" rows="4" class="form-control @error('needs') is-invalid @enderror"
                            placeholder="Keterangan Keperluan" name="needs"></textarea>
                        @error('needs') <div class="text-danger invalid-feedback mt-3">
                            Keterangan keperluan tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success" type="submit" id="submit-button">Ajukan</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#datepicker-input-cuti .input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            orientation:'bottom',
            autoclose: true,
            todayHighlight: true,
            startDate: '0d'
        });
        $('#datepicker-input-date-defaulted .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            orientation:'bottom',
            autoclose: true,
            todayHighlight: true,
            startDate: '0d'
        });
    });

    function result_end(){
        var yearly_start = document.getElementById("wfh_date_start").value;
        var yearly_end = document.getElementById("wfh_date_end").value;
        var url = "{{url('/staff/wfh/calculate')}}";
        $.ajax({
            type:"GET",
            data:{
                yearly_start:yearly_start,
                yearly_end:yearly_end
            },
            url:url,
            dataType:'json',
            success:function(response){
                if (yearly_start == '' || yearly_end == '') {
                    document.getElementById("yearly_info").innerHTML = '';                       
                } else {
                    document.getElementById("yearly_info").innerHTML = 'Pengajuan WFH sebanyak ' + response.yearly_days + ' hari (belum termasuk hari libur dan cuti)';
                }
            }
        });
        
    }

</script>
@endsection
