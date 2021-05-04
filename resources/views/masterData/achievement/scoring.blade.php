@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Penilaian')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        input[type=range] {
            -webkit-appearance: none;
            margin: 10px 0;
            width: 100%;
        }
        input[type=range]:focus {
            outline: none;
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 12.8px;
            cursor: pointer;
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
            background: #FF0404;
            border-radius: 25px;
            border: 0px solid #000101;
        }
        input[type=range]::-webkit-slider-thumb {
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
            border: 0px solid #000000;
            height: 20px;
            width: 39px;
            border-radius: 7px;
            background: #65001c;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -3.6px;
        }
        input[type=range]:focus::-webkit-slider-runnable-track {
            background: #FF0404;
        }
        input[type=range]::-moz-range-track {
            width: 100%;
            height: 12.8px;
            cursor: pointer;
            animate: 0.2s;
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
            background: #FF0404;
            border-radius: 25px;
            border: 0px solid #000101;
        }
        input[type=range]::-moz-range-thumb {
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
            border: 0px solid #000000;
            height: 20px;
            width: 39px;
            border-radius: 7px;
            background: #4F0505;
            cursor: pointer;
        }
        input[type=range]::-ms-track {
            width: 100%;
            height: 12.8px;
            cursor: pointer;
            animate: 0.2s;
            background: transparent;
            border-color: transparent;
            border-width: 39px 0;
            color: transparent;
        }
        input[type=range]::-ms-fill-lower {
            background: #FF0404;
            border: 0px solid #000101;
            border-radius: 50px;
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
        }
        input[type=range]::-ms-fill-upper {
            background: #FF0404;
            border: 0px solid #000101;
            border-radius: 50px;
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
        }
        input[type=range]::-ms-thumb {
            box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
            border: 0px solid #000000;
            height: 20px;
            width: 39px;
            border-radius: 7px;
            background: #65001c;
            cursor: pointer;
        }
        input[type=range]:focus::-ms-fill-lower {
            background: #FF0404;
        }
        input[type=range]:focus::-ms-fill-upper {
            background: #FF0404;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-bordered panel-danger">
        <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
        <div class="panel-heading">
            <h3 class="panel-title">Pemberian Nilai Penghargaan Karyawan</h3>
        </div>

        <form action="{{url('/admin/achievement/scoring')}}" method="POST" id="submit-achievement">@csrf</form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Masukan Periode Penilian" class="form-control" form="submit-achievement"
                                autocomplete="off" id="query" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <table id="scoring" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                            colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                            No</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                            aria-label="Position: activate to sort column ascending">Nama Karyawan</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                            aria-label="Position: activate to sort column ascending">Penilaian Karyawan </th>
                        <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                            aria-label="Position: activate to sort column ascending">Value </th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="count" value="{{count($data)}}">
                    @foreach ($data as $item)
                        <tr>
                            <input type="hidden" name="user_id_{{$loop->iteration}}" value="{{$item->id}}" form="submit-achievement">
                            <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{$item->name}}</td>
                            <td class="text-center">
                                <input type="range" class="form-range" min="0" max="100" id="customRange_{{$loop->iteration}}" form="submit-achievement"
                                    name="score_{{$loop->iteration}}" value="0" oninput="slidervalfunc()">
                                <input type="hidden" name="id-{{$item->id}}" value="{{$item->id}}" form="submit-achievement">
                            </td>
                            <td>
                                <span id="val_{{$loop->iteration}}"></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" id="button-submit" form="submit-achievement">Tambah</button>
        </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
        function slidervalfunc() {
            var tr = document.getElementsByTagName('tr');
            for (i = 1; i < tr.length; i++) {
                var output = document.getElementById('val_' + i)
                var slider = document.getElementById('customRange_' + i)
                output.innerHTML = slider.value + '/100'
            }
        }
        $(document).ready(function () {
            $('#pickadate .input-group.date').datepicker({
                format: 'mm/yyyy',
                autoclose: true,
                minViewMode: 'months',
                maxViewMode: 'years',
                startView: 'months',
                orientation: 'bottom',
                forceParse: false,
            });
            $('#button-submit').on('click', function (event) {
                event.preventDefault();
                var check_year = document.getElementById('query').value;
                if (check_year == '') {
                    Swal.fire({
                        title: 'Sepertinya ada kesalahan...',
                        text: "Mohon isi periode terlebih dahulu...",
                        icon: 'error',
                    });
                    return false;
                } else{
                  $('#submit-achievement').submit();
                }
            });
        });
    
    </script>
@endsection
