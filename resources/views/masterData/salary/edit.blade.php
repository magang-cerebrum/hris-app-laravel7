@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Gaji / Edit Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Gaji')
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Gaji</h3>
    </div>

    <form action="{{url('/admin/salary/'.$data->id.'/update')}}" method="POST" id="form_edit">
        @csrf
        @method('put')
    </form>

    <div class="panel-body">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Nama Staff :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Staff" name="name" form="form_edit"
                            class="form-control is-invalid" value="{{$data->name}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Periode :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Periode" name="periode" form="form_edit"
                            class="form-control is-invalid" value="{{$data->month . ' - ' . $data->year}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Divisi Staff :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Divisi Staff" name="division" form="form_edit"
                            class="form-control is-invalid" value="{{$data->division}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Posisi Staff :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Posisi Staff" name="position" form="form_edit"
                            class="form-control is-invalid" value="{{$data->position}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Total Jam Kerja Seharusnya :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Jam Kerja Seharusnya" name="total_default_hour" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_default_hour}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Total Jam Kerja :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Jam Kerja" name="total_work_time" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_work_time}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Total Jam Keterlambatan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Jam Keterlambatan" name="total_late_time" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_late_time}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Total Absen (hari) :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Absen" name="total_work_time" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_absen}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Total Sakit (hari) :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Sakit" name="total_sick" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_sick}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Total Cuti (hari) :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Cuti" name="total_paid_leave" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_paid_leave}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Gaji Pokok :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Gaji Pokok" name="default_salary" form="form_edit"
                            class="form-control is-invalid" value="{{$data->default_salary}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Denda Keterlambatan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Denda Keterlambatan" name="total_fine" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_fine}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Total Tunjangan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Tunjangan" name="total_salary_allowance" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_salary_allowance}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label" for="information">Total Potongan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Potongan" name="total_salary_cut" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_salary_cut}}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="information">Total Gaji Yang Didapatkan :</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Gaji Yang Didapatkan" name="total_salary" form="form_edit"
                            class="form-control is-invalid" value="{{$data->total_salary}}" readonly>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" form="form_edit">Update</button>
    </div>
</div>
@endsection