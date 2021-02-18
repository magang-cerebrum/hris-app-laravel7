@extends('layouts/templateAdmin')
@section('title','Masterdata Cuti')
@section('content-title','Data Staff / Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-sm-6 jobTambah">
                        <a href="{{url('/admin/paid-leave/history')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px">
                            <i class="fa fa-history"></i>
                            Riwayat Pengajuan
                        </a>
                @if (count($data) == 0)
                    </div>
                    </div>
                    <div class="text-center">
                        <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                    </div>
                    @else
                        <form action="{{ url('/admin/paid-leave/approve')}}" method="POST" style="display: inline">
                            @method('put')
                            @csrf
                            <button id="btn-delete" class="btn btn-primary btn-labeled add-tooltip" style="margin-top: -15px" type="submit" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Terima Pengajuan Cuti">
                                <i class="btn-label fa fa-check"></i>
                                Terima Data Terpilih
                            </button>
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
                                        <th class="sorting text-center" tabindex="0">Tipe Cuti</th>
                                        <th class="sorting text-center" tabindex="0">Sisa Cuti</th>
                                        <th class="sorting text-center" tabindex="0">Mulai Cuti</th>
                                        <th class="sorting text-center" tabindex="0">Akhir Cuti</th>
                                        <th class="sorting text-center" tabindex="0">Keterangan Keperluan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr class="sorting text-center" tabindex="0">
                                            <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                                            <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}"></td>
                                            <td class="text-center">{{$item->user_nip}}</td>
                                            <td class="text-center">{{$item->user_name}}</td>
                                            <td class="text-center">{{$item->type_name}}</td>
                                            <td class="text-center">{{$item->user_laeve_remaining.' ('.$item->days.') hari'}}</td>
                                            <td class="text-center">{{$item->paid_leave_date_start}}</td>
                                            <td class="text-center">{{$item->paid_leave_date_end}}</td>
                                            <td class="text-center">{{$item->needs}}</td>
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
    </div>
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