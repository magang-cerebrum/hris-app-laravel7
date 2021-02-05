@extends('layouts/templateAdmin')
@section('title','Masterdata Divisi')
@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">List Divisi</h3>
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
                        <a href="{{url('/admin/division/add')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Divisi
                        </a>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-3">
                        <div class="form-group float-right">
                            <input type="text" name="cari-divisi" id="cari-divisi" class="form-control"
                                placeholder="Cari Divisi" />
                        </div>
                    </div>
                </div>
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                ID Divisi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">{{$row->id}}</td>
                            <td class="text-center">{{$row->name}}</td>
                            <td class="text-center">
                                <a href="/admin/division/{{$row->id}}/edit"
                                    class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Edit Divisi"
                                    type="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="/admin/division/{{$row->id}}" method="POST"
                                    style="display: inline; margin: auto 5px">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-pink btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Hapus Divisi">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <ul class="pagination">
                            {{ $division->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
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
