@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Pilih Staff untuk Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Pilih Staff untuk Jadwal Kerja</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <form action="{{ url('/admin/schedule/add-schedule')}}" method="POST" style="display: inline" id="form-chek-user-month">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <button id="btn-post" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                            data-container="body" data-placement="top" data-original-title="Buat Jadwal Kerja" onclick="submit_add()">
                            <i class="btn-labeled fa fa-plus"></i>
                            Buat Jadwal Kerja
                        </button>
                        <span class="text-muted text-danger mar-hor">Pilih dahulu staff yang jadwalnya akan diatur melalui checkbox!</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mar-btm">
                        <div class="input-group">
                            <span class="input-group-addon">Bulan :</span>
                            {{-- <label class="col-sm-1 control-label" for="month">Bulan : </label> --}}
                            <select class="selectpicker" data-style="btn-pink" style="width: 100%" name="month" >
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="juli">juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                            <span class="input-group-addon">Tahun :</span>
                            {{-- <label class="col-sm-1 control-label" for="year">Tahun : </label> --}}
                            <input id="year-input" type="text" class="form-control @error('year') is-invalid @enderror" placeholder="Tahun" name="year">
                            @error('year') <div class="text-danger invalid-feedback mt-3">
                                Tahun tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <table id="masterdata-division"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                            <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                            <th class="sorting text-center" tabindex="0">NIP</th>
                            <th class="sorting text-center" tabindex="0">Nama</th>
                            <th class="sorting text-center" tabindex="0">Divisi</th>
                            <th class="sorting text-center" tabindex="0">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="sorting text-center" tabindex="0">
                                <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}"></td>
                                <td class="text-center">{{$item->nip}}</td>
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">{{$item->division_name}}</td>
                                <td class="text-center">{{$item->position_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#master').on('click', function(e) {
            if($(this).is(':checked',true)) {
                $(".sub_chk").prop('checked', true);  
            }
            else {  
                $(".sub_chk").prop('checked',false);  
            }  
        });
    });

    // Sweetalert 2
    function submit_add(){

        event.preventDefault();
        var check_user = document.querySelector('.sub_chk:checked');
        var check_year = document.getElementById('year-input').value;
        if (check_year != '' && check_user != null){
                $('#form-chek-user-month').submit();
        }
        else if (check_year == '' && check_user == null) {
            Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Mohon isi tahun dan pilih staff terlebih dahulu...",
                    icon: 'error',
            });
            return false;
        }
        else if (check_year == '') {
            Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Mohon isi tahun terlebih dahulu...",
                    icon: 'error',
            });
            return false;
        }
        else if (check_user == null){
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada staff yang dipilih untuk diatur jadwalnya!",
                icon: 'error',
            });
            event.preventDefault();
            return false;
        }
    }
</script>
@endsection