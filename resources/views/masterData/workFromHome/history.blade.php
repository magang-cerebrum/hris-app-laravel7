@extends('layouts/templateAdmin')
@section('title','Data Staff')
@section('content-title','Data Staff / Riwayat Pengajuan WFH')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Riwayat Pengajuan WFH Staff</h3>
    </div>
    <div class="panel-body">
        @if (count($data) == 0)
        <div class="text-center">
            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
        </div>
        @else
        <form action="{{ url('/admin/wfh/delete')}}" method="POST" style="display: inline">
            @method('delete')
            @csrf
            <button id="btn-delete" class="btn btn-danger add-tooltip" style="margin-bottom: 10px" type="submit"
                data-toggle="tooltip" data-container="body" data-placement="top"
                data-original-title="Hapus Riwayat Pengajuan WFH">
                <i class="btn-label fa fa-trash"></i>
                Hapus Data Terpilih
            </button>
            <div class="table-responsive">
                <table id="masterdata-history-cuti"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                            <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                            <th class="sorting text-center" tabindex="0">NIP</th>
                            <th class="sorting text-center" tabindex="0">Nama</th>
                            <th class="sorting text-center" tabindex="0">Mulai WFH</th>
                            <th class="sorting text-center" tabindex="0">Akhir WFH</th>
                            <th class="sorting text-center" tabindex="0">Keperluan</th>
                            <th class="sorting text-center" tabindex="0">Keterangan</th>
                            <th class="sorting text-center" tabindex="0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr class="sorting text-center" tabindex="0">
                            <td class="sorting text-center" tabindex="0">
                                {{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                            <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]"
                                    value="{{$item->id}}"></td>
                            <td class="text-center">{{$item->user_nip}}</td>
                            <td class="text-center">{{$item->user_name}}</td>
                            <td class="text-center">{{indonesian_date($item->wfh_date_start)}}</td>
                            <td class="text-center">{{indonesian_date($item->wfh_date_end)}}</td>
                            <td class="text-center">{{$item->needs}}</td>
                            <td class="text-center">{{$item->informations}}</td>
                            <td class="text-center">{{$item->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#master').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });
    });

</script>
@endsection
