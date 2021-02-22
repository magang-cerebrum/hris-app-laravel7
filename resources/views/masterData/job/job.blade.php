@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Lowongan Tersedia')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
        <div class="panel panel-danger panel-bordered">
            <!-- Striped Table -->
            <!--===================================================-->
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Lowongan Tersedia</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-6 jobTambah">
                            <a href="{{url('/admin/job/add')}}" class="btn btn-primary btn-labeled"
                                style="margin-bottom:15px">
                                <i class="btn-label fa fa-plus"></i>
                                Tambah Divisi
                            </a>
                    @if (count($dataJob) == 0)
                        </div>
                        </div>
                        <div class="text-center">
                            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                        </div>
                        @else
                            <form action="{{ url('/admin/job/delete')}}" method="POST" style="display: inline">
                                @method('delete')
                                @csrf
                                <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" style="margin-top: -15px" type="submit" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Hapus Data">
                                    <i class="btn-label fa fa-trash"></i>
                                    Hapus Data Terpilih
                                </button>
                            </div>
                            </div>
                                <table id="masterdata-division"
                                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                                cellspacing="0">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                            <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                                            <th class="sorting text-center" tabindex="0">Nama Posisi</th>
                                            <th class="sorting text-center" tabindex="0">Deskripsi</th>
                                            <th class="sorting text-center" tabindex="0">Persyaratan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataJob as $item)
                                            <tr>
                                                <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}"></td>
                                                <td class="text-center">{{$item->name}}</td>
                                                <td class="text-center">{{$item->descript}}</td>
                                                <td class="text-center">{{$item->required}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <ul class="pagination">
                                        {{ $dataJob->links() }}
                                    </ul>
                                </div>
                                <div class="col-sm-5"></div>
                            </div>
                    @endif
                </div>
            </div>
            <!--===================================================-->
            <!-- End Striped Table -->
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