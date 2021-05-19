@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Karyawan Terbaik')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<style>
    .hiddenRow {
        padding: 0 !important;
    }

</style>
@endsection
@section('content')

<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Pemilihan Karyawan Terbaik</h3>
    </div>
    <div class="panel-body">
        <form action="{{url('/admin/achievement/eom')}}" method="POST" id="search-eom">
            @csrf
        </form>
            <div id="pickadate">
                <div class="input-group date">
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                    </span>
                    <input type="text" name="periode" placeholder="Cari Data Pencapaian Karyawan" id="periode"
                        class="form-control" autocomplete="off" form="search-eom" readonly>
                    <span class="input-group-btn">
                        <button class="btn btn-danger" id="btn-search" type="submit" form="search-eom"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
            {{-- <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th>Divisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisions as $divisionsItems)
                    <tr>
                        <td><a href="#collapseRow{{$loop->iteration}}" data-toggle="collapse"
                                data-id="">{{$divisionsItems->name}}</a></td>
                    </tr>
                    <tr>
                        <td class="hiddenRow">
                            <div class="accordian-body collapse" id="collapseRow{{$loop->iteration}}">
                                <table class="table table-stripped" id="choose-eom">
                                    <thead>
                                        <tr class="danger">
                                            <th class="text-center">Nama Karyawan :</th>
                                            <th class="text-center">Score Achievement :</th>
                                            <th class="text-center">Score Performa :</th>
                                            <th class="text-center">Pilih Karyawan Terbaik : </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->where('division_id','=',$divisionsItems->id) as $dataItem)
                                        <tr>
                                            <td class="text-center" id="staff_name">{{$dataItem->staff_name}}</td>
                                            <td class="text-center">{{$dataItem->achievement_score}}</td>
                                            <td class="text-center">{{$dataItem->performance_score}}</td>
                                            <td class="text-center"><input type="radio" name="radio_input_eom"
                                                    id="radio-eom{{$loop->iteration}}" value="{{$dataItem->staff_id}}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}
            {{-- <button type="button" class="btn btn-danger" id="btn-submit">Pilih</button> --}}
        
    </div>
</div>
<div id="panel-output"></div>
@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("js/helpers.js")}}"></script>
<script>
    $('#pickadate .input-group.date').datepicker({
        format: 'mm/yyyy',
        autoclose: true,
        minViewMode: 'months',
        maxViewMode: 'years',
        startView: 'months',
        orientation: 'bottom',
        forceParse: false,
        startDate: '-1m',
        endDate: '0d'
    });

    $(document).ready(function () {
        $('#btn-submit').on('click', function () {
            // var periode = $('#periode').val();
            // var choosed_eom = $('input[name="radio_input_eom"]:checked').val();
            // var row = $('input[name="radio_input_eom"]:checked').closest('table').closest('tr');
            // var data = new Object();
            // data.name = row.find('td[id*=staff_name]').html();

            // if (periode == '' && choosed_eom === undefined) {
            //     Swal.fire({
            //         title: 'Sepertinya ada kesalahan...',
            //         text: "Belum ada periode dan karyawan yang dipilih!",
            //         icon: 'error',
            //     })
            // } else if (periode == '' && choosed_eom !== undefined){
            //     Swal.fire({
            //         title: 'Sepertinya ada kesalahan...',
            //         text: "Belum ada periode yang dipilih!",
            //         icon: 'error',
            //     })
            // } else if (periode != '' && choosed_eom === undefined){
            //     Swal.fire({
            //         title: 'Sepertinya ada kesalahan...',
            //         text: "Belum ada karyawan yang dipilih!",
            //         icon: 'error',
            //     })
            // } else {
            //     Swal.fire({
            //         width: 600,
            //         title: "Konfirmasi Employee of the Month",
            //         text: 'Anda yakin menjadikan "' + data.name + '" sebagai Employee of the Month pada periode "' + periodic(periode) + '"?',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Ya',
            //         cancelButtonText: 'Tidak'
            //         }).then((result) => {
            //         if (result.value == true) {
            //             $("#choose-eom").submit();
            //         }}
            //     );
            // }
        });


        $('#search-eom').on('submit', function (event) {
                event.preventDefault();
                var periode = document.getElementById('periode').value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: {periode: periode},
                    success: function (data) {
                        $("#panel-output").html(data);
                        
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: "Isi form terlebih dahulu!",
                            icon: 'error',
                            width: 600
                        });
                    }
                });
            });

    });

</script>

@endsection
