@extends('layouts/templateStaff')
@section('title','Cuti')
@section('content-title','Cuti / Riwayat Pengajuan Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="panel panel-primary panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Riwayat Pengajuan Cuti</h3>
        </div>
        <div class="panel-body" style="padding-top: 20px">
            @if (count($data) == 0)
                <div class="text-center">
                    <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                    <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                </div>
            @else
                <div class="table-responsive">
                    <table id="transaction-paid-leave-staff"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        aria-describedby="dt-basic_info" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                <th class="sorting text-center" tabindex="0">Tipe Cuti</th>
                                <th class="sorting text-center" tabindex="0">Mulai Cuti</th>
                                <th class="sorting text-center" tabindex="0">Akhir Cuti</th>
                                <th class="sorting text-center" tabindex="0">Jumlah Hari Cuti</th>
                                <th class="sorting text-center" tabindex="0">Keperluan</th>
                                <th class="sorting text-center" tabindex="0">Keterangan</th>
                                <th class="sorting text-center" tabindex="0">Status</th>
                                <th class="sorting text-center" tabindex="0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="sorting text-center" tabindex="0">
                                    <td class="sorting text-center" tabindex="0">
                                        {{$data->currentpage() * 5 - 5 + $loop->iteration}}</td>
                                    <td class="text-center">{{$item->type_name}}</td>
                                    <td class="text-center">{{indonesian_date($item->paid_leave_date_start)}}</td>
                                    <td class="text-center">{{indonesian_date($item->paid_leave_date_end)}}</td>
                                    <td class="text-center">{{$item->days.' hari'}}</td>
                                    <td class="text-center">{{$item->needs}}</td>
                                    <td class="text-center">{{$item->informations}}</td>
                                    <td class="text-center">{{$item->status}}</td>
                                    <td class="text-center">
                                        @if ($item->status == 'Diterima' || $item->status == 'Ditolak' || $item->status == 'Ditolak-Chief' || $item->status == 'Cancel')
                                            <button class="btn btn-sm btn-icon btn-circle" type="submit" disabled>
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @else
                                            <button onclick="cancel({{$item->id}},'{{$item->type_name}}')"
                                                class="cancel-paid-leave btn btn-sm btn-danger btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="left"
                                                data-original-title="Cancel Pengajuan Cuti" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
        function cancel(id,name){
            var url = "/staff/paid-leave/:id/cancel".replace(':id', id);
            Swal.fire({
                width: 600,
                title: 'Yakin untuk membatalkan ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {id : id, name: name},
                        success: function(response) {
                            Swal.fire({
                                width: 600,
                                title: 'Berhasil!',
                                text: response.name + " berhasil di cancel!",
                                icon: 'info',
                                timer: 2000
                            });
                            window.location.reload();
                        },
                        error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: errorThrown,
                            text: "Pengajuan cuti gagal di cancel!",
                            icon: 'error',
                            width: 600
                        });
                    }
                    });
                } else {
                    return false;
                }} 
            );
        }
    </script>
@endsection