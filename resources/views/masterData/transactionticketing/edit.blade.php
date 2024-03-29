@extends('layouts/templateAdmin')
@section('content-title','Sistem / Ticketing / Kirim Respon Ticket')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Sistem')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Kirim Respon Ticket</h3>
        </div>

        <form action="/admin/ticketing/{{$ticketing->id}}" method="POST" id="form_edit">
            @csrf
            @method('put')
        </form>
        
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-1 control-label">ID Ticket:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="ID Ticket" name="name" form="form_edit"
                            class="form-control" value="{{$ticketing->id}}" disabled>
                        </div>
                        <div class="col-sm-1"></div>
                        <label class="col-sm-1 control-label">Nama Pengirim:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nama Staff" name="name" form="form_edit"
                            class="form-control" value="{{$ticketing->is_anonim == true ? 'Anonim' : $sender->name}}" disabled>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-1 control-label">Kategori:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nama Shift" name="name" form="form_edit"
                            class="form-control" value="{{$ticketing->category}}" disabled>
                        </div>
                        <label class="col-sm-2 control-label" for="status">Status Ticket:</label>
                        <div class="col-sm-5">
                            <select class="selectpicker" data-style="btn-purple" name="status" form="form_edit">
                                @foreach ($status as $item)
                                    <option value="{{$item}}" {{$ticketing->status == $item ? 'selected' : '' }}>
                                        {{$item}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-muted">Pastikan merubah status ticket jika masalah sudah selesai.</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-1 control-label" for="textarea-edit-message">Pesan:</label>
                        <div class="col-sm-11">
                            <textarea id="textarea-edit-message" rows="2" class="form-control" form="form_edit"
                                placeholder="Pesan" name="message" readonly>{{$ticketing->message}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-1 control-label" for="textarea-edit-response">Respon:</label>
                        <div class="col-sm-11">
                            <textarea id="textarea-edit-response" rows="2" class="form-control" form="form_edit"
                                placeholder="Respon" name="response">{{$ticketing->response}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success" type="submit" form="form_edit">Kirim Respon</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
@endsection
