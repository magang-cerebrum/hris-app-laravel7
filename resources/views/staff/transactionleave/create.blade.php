@extends('layouts/templateStaff')
@section('title', 'Cuti')
@section('content-title', 'Cuti / Pengajuan Cuti')
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
        <h3 class="panel-title">Form Pengajuan Cuti</h3>
    </div>
    <form class="form-horizontal" action="{{url('/staff/paid-leave')}}" method="POST">
        @csrf
        <div class="panel-body">
            <input type="hidden" name="user_id" class="form-control" value="{{$id}}">
            <div class="row">
                <label class="col-sm-2 control-label" for="paid_leave">Tipe Cuti : </label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-success" name="paid_leave_type_id" id="type-changer" onchange="typeChanger(this.value);result_end(this.value)">
                        @foreach ($data as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-md-2 control-label yearly" for="demo-text-input">Sisa Cuti Tahunan :</label>
                <div class="col-md-4">
                    <input type="text" id="paid-leave-left" class="form-control yearly" value="{{$left}}"
                        name="leave_remaining" disabled>
                </div>
            </div>
            <div class="yearly">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal :</label>
                    <div id="datepicker-input-cuti">
                        <div class="col-sm-10">
                            <div class="input-group input-daterange">
                                <input type="text"
                                    class="form-control @error('paid_leave_date_start') is-invalid @enderror"
                                    placeholder="Tanggal Mulai" name="paid_leave_date_start" id="paid_leave_date_start"
                                    value="{{old('paid_leave_date_start')}}" autocomplete="off" onchange="result_end()">
                                <span class="input-group-addon">sampai</span>
                                <input type="text"
                                    class="form-control @error('paid_leave_date_end') is-invalid @enderror"
                                    placeholder="Tanggal Berakhir" name="paid_leave_date_end" id="paid_leave_date_end"
                                    value="{{old('paid_leave_date_start')}}" autocomplete="off" onchange="result_end()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="text-info text-center" id="yearly_info"></div></div>
                <div class="row"><div class="text-danger text-center" id="yearly_info-2"></div></div>
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
            <div class="defaulted hidden">
                <div class="row">
                    <label class="col-sm-2 control-label">Tanggal :</label>
                    <div id="datepicker-input-date-defaulted">
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control @error('paid_leave_date_start') is-invalid @enderror"
                                    placeholder="Tanggal Mulai Cuti" id="paid_leave_date_start_defaulted" name="paid_leave_date_start_defaulted" onchange="result_end()" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                            @error('paid_leave_date_start') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                tanggal mulai cuti.</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 5px;">
                        <div class="text-center" id="end_date"></div>
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

    function typeChanger() {
        var type = document.getElementById("type-changer").value;
        var remaining = {!! json_encode($left) !!}
        if (type == 1) {
            $(".defaulted").addClass("hidden");
            $(".yearly").removeClass("hidden");
            $("#paid-leave-left").val(remaining);
        } else {
            $(".defaulted").removeClass("hidden");
            $(".yearly").addClass("hidden");
            $("#paid-leave-left").val("-");
        }
    }

    function result_end(){
        var type = document.getElementById("type-changer").value;
        var yearly_start = document.getElementById("paid_leave_date_start").value;
        var yearly_end = document.getElementById("paid_leave_date_end").value;
        var defaulted_start = document.getElementById("paid_leave_date_start_defaulted").value;
        var url = "{{url('/staff/paid-leave/calculate')}}";
        var left = document.getElementById('paid-leave-left').value;
        $.ajax({
            type:"GET",
            data:{
                type:type,
                yearly_start:yearly_start,
                yearly_end:yearly_end,
                defaulted_start:defaulted_start
            },
            url:url,
            dataType:'json',
            success:function(response){
                if (response.type == 1) {
                    if (left < response.yearly_days) {document.getElementById('submit-button').disabled = true;}
                    else document.getElementById('submit-button').disabled = false;

                    if (yearly_start == '' || yearly_end == '') {
                        document.getElementById("yearly_info").innerHTML = '';
                        document.getElementById("yearly_info-2").innerHTML = '';                        
                    } else {
                        document.getElementById("yearly_info").innerHTML = 'Pengajuan Cuti sebanyak ' + response.yearly_days + ' hari (belum termasuk hari libur dan cuti)';
                        document.getElementById("yearly_info-2").innerHTML = 'Jumlah pengajuan cuti sebaiknya tidak melebihi dari sisa cuti tahunan!';
                    }
                } else {
                    if (defaulted_start == '') {
                        document.getElementById("end_date").className = 'text-center text-danger'
                        document.getElementById("end_date").innerHTML = 'Mohon pilih tanggal terlebih dahulu!';    
                    } else {
                        document.getElementById("end_date").className = 'text-center text-success'
                        document.getElementById("end_date").innerHTML = response.info;
                    }
                }
            }
        });
        
    }

</script>
@endsection
