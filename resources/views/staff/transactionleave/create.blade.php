@extends('layouts/templateStaff')
@section('title', 'Rekruitasi')
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
                <label class="col-md-2 control-label" for="paid_leave_date_start">Tanggal Mulai</label>
                <div id="datepicker-input-start">
                    <div class="col-md-4">
                        <div class="input-group date">
                            <input type="text" class="form-control @error('paid_leave_start') is-invalid @enderror"
                                placeholder="Tanggal Mulai" name="paid_leave_date_start">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            @error('paid_leave_start') <div class="text-danger invalid-feedback mt-3">
                                Tanggal mulai tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <label class="col-md-2 control-label" for="paid_leave_date_end">Tanggal Selesai</label>
                <div id="datepicker-input-end">
                    <div class="col-md-4">
                        <div class="input-group date">
                            <input type="text" class="form-control @error('paid_leave_end') is-invalid @enderror"
                                placeholder="Tanggal Selesai" name="paid_leave_date_end">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            @error('paid_leave_end') <div class="text-danger invalid-feedback mt-3">
                                Tanggal selesai tidak boleh kosong.
                            </div> @enderror
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
        $('#datepicker-input-start .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            orientation: 'bottom'
        });
        $('#datepicker-input-end .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            orientation: 'bottom'
        });
    })

</script>
@endsection
