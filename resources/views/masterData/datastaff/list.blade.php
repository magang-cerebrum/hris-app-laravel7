@extends('layout/template')
@section('title','Masterdata Data Staff')
@section('content')
<div class="boxed">
    <!--CONTENT CONTAINER-->
    <!--===================================================-->

    <div id="content-container">
        <div id="page-head">

            <div class="pad-all text-center">
                <h3>Data Staff</h3>
            </div>
        </div>


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">List Data Staff</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('status'))
                            <div class="alert alert-info">
                                {{session('status')}}
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="{{url('/data/staff/add')}}" class="btn btn-primary btn-labeled"
                                        style="margin-bottom:15px">
                                        <i class="btn-label fa fa-plus"></i>
                                        Tambah Data
                                    </a>
                                </div>
                                <div class="col-sm-7"></div>
                                <div class="col-sm-3">
                                    <div class="form-group float-right">
                                        <input type="text" name="cari-shift" id="cari-staff" class="form-control"
                                            placeholder="Cari Staff" />
                                    </div>
                                </div>
                            </div>
                            <table id="masterdata-staff"
                                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">ID</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic"
                                            rowspan="1" colspan="1"
                                            aria-label="Jam masuk: activate to sort column ascending">NIP</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending">Name</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic"
                                            rowspan="1" colspan="1"
                                            aria-label="Jam Kerja: activate to sort column ascending">Divisi</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic"
                                            rowspan="1" colspan="1" aria-label="Action">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staff as $row)
                                    <tr>
                                        <td tabindex="0" class="sorting_1 text-center">{{$row->id}}</td>
                                        <td class="text-center">{{$row->nip}}</td>
                                        <td class="text-center">{{$row->name}}</td>
                                        <td class="text-center">{{$row->division_name}}</td>
                                        <td class="text-center">
                                            <span id="detail_staff" data-toggle="modal" data-target="#modal-detail-staff"
                                                style="display: inline; margin: auto 5px">
                                                <a  class="btn btn-info btn-icon btn-circle add-tooltip"
                                                    data-toggle="tooltip" data-container="body" data-placement="top"
                                                    data-original-title="Detail Staff"type="button">
                                                    <i class="ion-information icon-lg"></i>
                                                </a>
                                            </span>
                                            <a href="/data/staff/{{$row->id}}/edit"
                                                class="btn btn-success btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="top"
                                                data-original-title="Edit Staff" type="button">
                                                <i class="ion-edit icon-lg"></i>
                                            </a>
                                            <form action="/data/staff/{{$row->id}}" method="POST"
                                                style="display: inline; margin: auto 5px">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-pink btn-icon btn-circle add-tooltip"
                                                    data-toggle="tooltip" data-container="body" data-placement="top"
                                                    data-original-title="Hapus Staff">
                                                    <i class="ion-trash-b icon-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <ul class="pagination">
                                        {{ $staff->links() }}
                            </ul>
                        </div>
                        <div class="col-sm-5"></div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('datastaff/detail')
{{-- <script>
        $(document).ready(function(){

            fetch_data();

            function fetch_data(query =''){
                $.ajax({
                    url:"{{ route('data.division.search') }}",
method:'GET',
data:{query:query},
dataType:'json',
success:function(data)
{
('tbody').html(data.table_data);
}
})
}

$(document).on('keyup','#cari-divisi',function(){
var query = $(this).val();
fetch_data(query);
});
});
</script> --}}
@endsection
