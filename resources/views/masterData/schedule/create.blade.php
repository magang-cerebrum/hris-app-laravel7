@extends('layouts/templateAdmin')
@section('title','Data Staff')
@section('content-title','Data Staff / Tambah Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="table-responsive">
            <form action="{{ url('/admin/schedule/add-schedule')}}" method="POST" style="display: inline">
                @csrf
                <button id="btn-post" class="btn btn-primary add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                    data-container="body" data-placement="top" data-original-title="Buat Jadwal Kerja">
                    <i class="btn-label fa fa-trash"></i>
                    Buat Jadwal Kerja
                </button>
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
</script>
@endsection