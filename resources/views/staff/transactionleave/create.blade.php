@extends('layouts/templateStaff')
@section('title', 'Cuti')
@section('content-title', 'Cuti / Pengajuan Cuti')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="panel panel-primary panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Pengajuan Cuti</h3>
    </div>
    <form class="form-horizontal" action="/staff/paid-leave" method="POST">
        @csrf
        <div class="panel-body">
            <input type="hidden" name="user_id" class="form-control" value="{{$id}}">
            <div class="row" style="margin-bottom: 10px">
                <label class="col-sm-2 control-label" for="paid_leave">Tipe Cuti</label>
                <div class="col-sm-4">
                    <select class="selectpicker" data-style="btn-success" name="paid_leave_type_id">
                        @foreach ($data as $item)
                        <option value="{{$item->id}}">
                            {{$item->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-md-2 control-label" for="demo-text-input">Sisa Cuti</label>
                <div class="col-md-4">
                    <input type="text" id="nama-input" class="form-control" value="-" name="leave_remaining" disabled>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <label class="col-sm-2 control-label">Tanggal:</label>
                <div id="datepicker-input-cuti">
                    <div class="col-sm-10">
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control @error('paid_leave_date_start') is-invalid @enderror"
                                placeholder="Tanggal Mulai" name="paid_leave_date_start" value="{{old('paid_leave_date_start')}}" autocomplete="off">
                            <span class="input-group-addon">sampai</span>
                            <input type="text" class="form-control @error('paid_leave_date_end') is-invalid @enderror"
                                placeholder="Tanggal Berakhir" name="paid_leave_date_end" value="{{old('paid_leave_date_start')}}" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-2 control-label" for="demo-textarea-input">Keterangan Keperluan</label>
                <div class="col-md-10">
                    <textarea id="needs" rows="4" class="form-control @error('needs') is-invalid @enderror"
                        placeholder="Keterangan Keperluan" name="needs"></textarea>
                    @error('needs') <div class="text-danger invalid-feedback mt-3">
                        Keterangan keperluan tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit">Ajukan</button>
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
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    })

</script>
@endsection
