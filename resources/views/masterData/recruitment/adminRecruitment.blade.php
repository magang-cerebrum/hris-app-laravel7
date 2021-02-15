@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Daftar Rekruitasi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
        <div class="panel">
            <!-- Striped Table -->
            <!--===================================================-->
            <div class="panel-body">
                <div class="table-responsive">
                    @if (count($data) == 0)
                        <div class="text-center">
                            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                        </div>
                        @else
                            <form action="{{ url('/admin/rectuitment/delete-all')}}" method="POST">
                                @method('delete')
                                @csrf
                                <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" style="margin-bottom: 10px" type="submit" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Hapus Data">
                                    <i class="btn-label fa fa-trash"></i>
                                    Hapus Data Terpilih
                                </button>
                                <table id="masterdata-division"
                                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                                cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                            <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                                            <th class="sorting text-center" tabindex="0">Nama Lengkap</th>
                                            <th class="sorting text-center" tabindex="0">Tempat Tanggal Lahir</th>
                                            <th class="sorting text-center" tabindex="0">Domisili</th>
                                            <th class="sorting text-center" tabindex="0">No Telfon</th>
                                            <th class="sorting text-center" tabindex="0">Email</th>
                                            <th class="sorting text-center" tabindex="0">Jenis Kelamin</th>
                                            <th class="sorting text-center" tabindex="0">Pendidikan Terakhir</th>
                                            <th class="sorting text-center" tabindex="0">Posisi</th>
                                            <th class="sorting text-center" tabindex="0">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="sorting text-center" tabindex="0">
                                                <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                                                <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}"></td>
                                                <td class="text-center">{{$item->name}}</td>
                                                <td class="text-center">{{$item->dob}}</td>
                                                <td class="text-center">{{$item->live_at}}</td>
                                                <td class="text-center">{{$item->phone_number}}</td>
                                                <td class="text-center">{{$item->email}}</td>
                                                <td class="text-center">{{$item->gender}}</td>
                                                <td class="text-center">{{$item->last_education}}</td>
                                                <td class="text-center">{{$item->position}}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset('/upload_recruitment/cv_upload/'.$item->file_cv)}}" target="blank">
                                                        <button class="btn btn-pink btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Buka CV">
                                                            <i class="fa fa-file icon-lg"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ asset('/upload_recruitment/portofolio_upload/'.$item->file_portofolio)}}" target="blank">
                                                        <button class="btn btn-pink btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Buka Portofolio">
                                                            <i class="fa fa-file icon-lg"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <div class="row" style="margin-top: -50px">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <ul class="pagination">
                                        {{ $data->links() }}
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