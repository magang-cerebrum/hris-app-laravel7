@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Daftar Presensi Divisi')
@section('content-subtitle', 'HRIS ' . $company_name)

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        .img-presence {
            width: 50%;
        }
        @media screen and (max-width: 600px) {
            .img-presence {
                width: 150px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Presensi Divisi</h3>
        </div>
        
        <form action="/staff/presence/division" method="POST" id="accept_presence">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <button id="btn-presence" class="btn btn-success btn-labeled add-tooltip" type="button"
                data-toggle="tooltip" data-container="body" data-placement="top"
                data-original-title="Terima Presensi Terpilih" onclick="check_data()" form="accept_presence" style="margin-bottom: 10px">
                <i class="btn-label fa fa-check"></i>
                Terima Presensi Terpilih
            </button>
            <div class="table-responsive">
                <table class="table table-striped table-responsive table-bordered no-footer dtr-inline collapsed" role="grid"
                aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center">All <input type="checkbox" id="check-all"></th>
                            <th class="sorting_asc text-center">Nama Staff</th>
                            <th class="sorting_asc text-center">Tanggal</th>
                            <th class="sorting_asc text-center">Absen Masuk</th>
                            <th class="sorting_asc text-center">Telat</th>
                            <th class="sorting_asc text-center">Foto Masuk</th>
                            <th class="sorting_asc text-center">Absen Pulang</th>
                            <th class="sorting_asc text-center">Foto Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item @error('selectid') is-invalid @enderror"
                                    name="selectid[]" value="{{$item->id}}" form="accept_presence">
                                </td>
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">{{$item->presence_date}}</td>
                                <td class="text-center">{{$item->in_time}}</td>
                                <td class="text-center">{{$item->late_time}}</td>
                                <td class="text-center"><img class="img-presence" src="{{asset ('img-presensi/masuk/'.$item->file_in)}}"></td>
                                <td class="text-center">{{$item->out_time}}</td>
                                <td class="text-center">
                                    @if ($item->file_out != null)   
                                        <img class="img-presence" src="{{asset ('img-presensi/pulang/'.$item->file_out)}}">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#check-all").click(function () {
                if ($(this).is(":checked"))
                    $(".check-item").prop("checked", true);
                else
                    $(".check-item").prop("checked", false);
            });
        });

        function check_data() {
            var check = document.querySelector('.check-item:checked');
            if ( check == null ) {
                Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Tidak ada data yang dipilih, Silahkan memilih data terlebih dahulu!",
                    icon: 'error',
                })
            }
            else {
                $("#accept_presence").submit();
            }
        }
    </script>
@endsection