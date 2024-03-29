@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Data / Promosi Staff')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Promosi Staff')

@section('head')
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .panel-body {
            padding: 10px 20px 25px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
        .separator {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #EAEAEA;
        }

        .separator:not(:empty)::before {
            margin-right: .25em;
        }

        .separator:not(:empty)::after {
            margin-left: .25em;
        }

        .separator:hover{
            color: #353535 !important;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Promosi Staff</h3>
        </div>
        
        <form class="form-horizontal" action="/admin/data-staff/promote/approved" method="POST" id="form-promotion">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="separator mar-ver text-bold">Data pokok staff</div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">NIP:</label>
                    <div class="col-sm-4">
                        <input type="number" placeholder="NIP" name="nip" form="form-promotion"
                            class="form-control" value="{{$staff->nip}}" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Nama Staff:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Lengkap" name="name" form="form-promotion"
                            class="form-control" value="{{$staff->name}}" readonly>
                    </div>
                </div>
            </div>
            <div class="separator mar-ver text-bold">Status staff saat ini</div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Status Karyawan:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Status karyawan saat ini" form="form-promotion"
                            class="form-control" value="{{$staff->employee_status}}" name="status_before" id="status_before" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Gaji Pokok:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Gaji Pokok saat ini" id="salary_before" name="salary_before" form="form-promotion"
                            class="form-control" value="{{rupiah($staff->salary)}}" readonly>
                    </div>
                </div>
            </div>
            @if ($staff->employee_status == 'Tetap')
                <a href="#collapseScore" data-toggle="collapse">
                    <div class="separator mar-ver text-bold">Nilai Performa Staff "{{$staff->name}}" selama 1 Tahun</div>
                </a>
                <div class="collapse" id="collapseScore">
                    <div class="table-responsive">
                        <table id="user_performance_score" class="table table-striped table-bordered text-center" role="grid" width="100%">
                            <thead>
                                <tr role="rowheader" style="background-color: dimgray">
                                    <th class="text-center" style="color: white">Bulan - Tahun</th>
                                    <th class="text-center" style="color: white">Nilai Performa</th>
                                    <th width="1px"></th>
                                    <th class="text-center" style="color: white">Bulan - Tahun</th>
                                    <th class="text-center" style="color: white">Nilai Performa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 6; $i++)
                                    <tr role="row">
                                        <td>{{$periode[$i]}}</td>
                                        <td>{{$performance[$i] ? $performance[$i] : "Tidak ada penilaian"}}</td>
                                        <td></td>
                                        <td>{{$periode[$i+6]}}</td>
                                        <td>{{$performance[$i+6] ? $performance[$i+6] : "Tidak ada penilaian"}}</td>
                                    </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr role="rowfooter" style="background-color: dimgray">
                                    <th class="text-center" style="color: white">Total Nilai</th>
                                    <th class="text-center" style="color: white">{{$total}}</th>
                                    <th width="1px" style="background-color: #353535"></th>
                                    <th class="text-center" style="color: white">Rata-rata Nilai</th>
                                    <th class="text-center" style="color: white" id="average_score">{{$average}}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="score-information"></div>
                    </div>
                </div>
            @endif
            <a href="#collapseResultSalary" data-toggle="collapse">
                <div class="separator mar-ver text-bold">Status staff setelah promosi</div>
            </a>
            <div class="collapse" id="collapseResultSalary">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Status Karyawan:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Status karyawan saat ini" name="new_employee_status" form="form-promotion"
                                class="form-control text-success text-bold" value="{{$staff->employee_status == 'Probation' ? 'Kontrak' : 'Tetap'}}" readonly>
                        </div>
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Tipe kenaikan gaji:</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <input id="salary_raise_type_radio-1" class="magic-radio" type="radio" form="form-promotion"
                                    name="salary_raise_type" value="Persentase" onclick="showSalaryRaiseTypeOption()" onchange="calculate()" checked>
                                <label for="salary_raise_type_radio-1">Persentase</label>
                                <input id="salary_raise_type_radio-2" class="magic-radio" type="radio" form="form-promotion"
                                    name="salary_raise_type" value="Penambahan" onclick="showSalaryRaiseTypeOption()" onchange="calculate()">
                                <label for="salary_raise_type_radio-2">Penambahan Langsung</label>
                            </div>
                        </div>
                        <span id="input-percentage">
                            <label class="col-sm-2 control-label">Persentase:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Hanya isi oleh angka (kenaikan berdasarkan gaji sebelumnya)"
                                    name="percentage" id="percentage" onkeyup="calculate()" form="form-promotion"
                                    class="form-control @error('percentage') is-invalid @enderror">
                                @error('percentage') <div class="text-danger invalid-feedback mt-3">
                                    Persentase harus diisi.
                                </div> @enderror
                            </div>
                        </span>
                        <span id="input-direct_add">
                            <label class="col-sm-2 control-label">Penambahan Langsung:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Jumlah penambahan langsung"
                                    name="direct_add" id="direct_add" form="form-promotion"
                                    class="form-control @error('direct_add') is-invalid @enderror" onkeyup="calculate();format_rp(this.id)">
                                @error('direct_add') <div class="text-danger invalid-feedback mt-3">
                                    Penambahan langsung harus diisi.
                                </div> @enderror
                            </div>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Gaji Pokok:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Gaji pokok setelah mendapatkan promosi" id="salary_after" name="salary_after"
                                class="form-control text-success text-bold" form="form-promotion" readonly>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="text-info text-center" id="information"></div></div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a class="btn btn-dark" type="button" href="{{url('/admin/data-staff')}}" id="btn-back">Kembali ke Informasi Staff</a>
            <button class="btn btn-mint" type="submit" onclick="submit_promote()" form="form-promotion" id="btn-submit" disabled>Promosikan</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('js/helpers.js')}}"></script>
    <script>
        setTimeout(calculate,1500)

        $(document).ready(function () {
            $('#user_performance_score tr > td:contains(Tidak ada penilaian)').addClass("text-danger text-bold not-scored");

            if (document.querySelector('.not-scored')){
                document.getElementById('score-information').className = 'text-danger text-bold text-center'
                document.getElementById('score-information').innerHTML = 'Kenaikan gaji tidak dapat dilakukan karena masih terdapat nilai performa yang kosong!'
                $('#btn-back').show();
                $('#btn-submit').remove();
            } else {
                document.getElementById('btn-submit').disabled = false;
                if (document.getElementById('status_before').value == 'Tetap'){
                    var ratarata = (document.getElementById('average_score').innerText / 10 ).toFixed(2);
                    document.getElementById('score-information').className = 'text-success text-center'
                    document.getElementById('score-information').innerHTML = 'Kenaikan gaji dapat disetujui! Kenaikan sebesar <b>('+ratarata+'%)</b> dari gaji pokok!'
                    document.getElementById('percentage').value = ratarata;
                } else {
                    document.getElementById('percentage').value = '';
                }
            }
        });

        function format_rp(idnya) {
            var angka = document.getElementById(idnya).value;
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            document.getElementById(idnya).value = 'Rp. ' + rupiah;
        }

        function submit_promote(){
            event.preventDefault();
            var name = $('input[name="name"]').val();
            var check_type = $('input[name="salary_raise_type"]:checked').val();
            var check1 = document.getElementById("percentage").value;
            var check2 = document.getElementById("direct_add").value;
            if ((check_type == 'Persentase' && check1 != '') || (check_type == 'Penambahan' && check2 != '')){
                Swal.fire({
                    width:600,
                    title: 'Anda yakin ingin mempromosikan staff '+name+'?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                    }).then((result) => {
                    if (result.value == true) {
                        $("#form-promotion").submit();
                    }}
                );
            } else {
                Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Terdapat form yang belum diisi!",
                    icon: 'error',
                })
            }
        }

        function calculate(){
            var type = $('input[name="salary_raise_type"]:checked').val();
            var get_salary = document.getElementById("salary_before").value;
            var salary_before = get_salary.substring(3).split('.').join("");
            
            var percentage = document.getElementById('percentage').value;
            var get_direct_add = document.getElementById('direct_add').value;
            var direct_add = get_direct_add.substring(3).split('.').join("");
            
            var url = "{{url('/admin/data-staff/promote/calculate')}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"POST",
                data:{
                    type:type,
                    salary_before:salary_before,
                    percentage:percentage,
                    direct_add:direct_add
                },
                url:url,
                dataType:'json',
                success:function(response){
                    document.getElementById("information").className = 'text-center text-success'
                    document.getElementById("information").innerHTML = response.info;
                    document.getElementById("salary_after").value = response.salary_after;
                }
            });
            
        }

        function showSalaryRaiseTypeOption() {
            if (document.getElementById('salary_raise_type_radio-1').checked) {
                document.getElementById('input-direct_add').style.display = 'none';
                document.getElementById('direct_add').value = '';
                document.getElementById('direct_add').disabled = true;
                document.getElementById('input-percentage').style.display = 'block';
                document.getElementById('percentage').disabled = false;
            } else {
                document.getElementById('input-direct_add').style.display = 'block';
                document.getElementById('direct_add').disabled = false;
                document.getElementById('input-percentage').style.display = 'none';
                document.getElementById('percentage').disabled = true;
                if (document.getElementById('status_before').value == 'Probation'){
                    document.getElementById('percentage').value = '5';
                } else if (document.getElementById('status_before').value == 'Kontrak') {
                    document.getElementById('percentage').value = '7.5';
                } else {
                    if (document.getElementById('status_before').value == 'Tetap'){
                        var ratarata = (document.getElementById('average_score').innerText / 10 ).toFixed(2);
                        document.getElementById('percentage').value = ratarata;
                    } else {
                        document.getElementById('percentage').value = '';
                    }
                }
            }
        }
        
        window.onload = showSalaryRaiseTypeOption();
    </script>
@endsection
