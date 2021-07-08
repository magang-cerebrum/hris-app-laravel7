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
            <div class="table-responsive">
                <table id="scoring" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead id="headerTable" hidden>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                                aria-label="Position: activate to sort column ascending">Nama Karyawan</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                                aria-label="Position: activate to sort column ascending">Divisi Karyawan</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                                aria-label="Position: activate to sort column ascending">Penilaian Karyawan </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1" colspan="1"
                                aria-label="Position: activate to sort column ascending">Value </th>
                        </tr>
                    </thead>
                    <tbody  id="achievements_body_table"></tbody>
                </table>
            </div>
            @if(!$dataCM->isEmpty())
            <p class="h4 text-uppercase text-bold text-center" id="data-exist" hidden>Data Pada Periode ini Sudah Diinput</p>
            @endif
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" id="button-submit" form="submit-achievement">Tambah</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
         var url = '/admin/achievement/ajx/pickdate'
        setTimeout(function(){
            // $('#data-exist').show()
            var date = new Date()
            var month =  ("0" + (date.getMonth() + 1)).slice(-2)
            var year = date.getFullYear()
            periode = month + '/' +year
            document.getElementById('query').value = periode
            console.log(periode)
                var data
                var dataOutName
                var dataOutId
                var dataoutDivId
                var firstTd
                var tr
                var scTd
                var thrdTd
                var frthTd
                var fifthTd
                var counterData
                $.ajax({
                    url: url,
                    type : 'GET',
                    data : {
                        periode :periode
                    },
                    dataType:'json', 
                    success:function(response){
                        console.log(response)
                        if(response.countData>0){
                            $('#data-exist').hide()
                        }
                        else{
                            $('#data-exist').show()
                        }
                        $('#headerTable').show()
                        let count = 0
                        for(data in response.data){
                            var counted =count+=1
                            var iteration = document.createTextNode(counted)
                            dataOutName = response.data[data].staff_name
                            var nodeDataOutName = document.createTextNode(dataOutName)
                            dataOutId = response.data[data].id
                            var nodeDataOutId = document.createTextNode(dataOutId)
                            dataoutDivId = response.data[data].division_id
                            var nodeDataOutDivId = document.createTextNode(dataOutId)
                            var nodeDataOutDivName = document.createTextNode(response.data[data].division_name)
                            tr = document.createElement("tr")
                            tr.setAttribute('class','scorethis')
                            firstTd = document.createElement("td")
                            scTd = document.createElement("td")
                            thrdTd = document.createElement("td")
                            fifthTd = document.createElement("td")
                            counterData=document.createElement('input')
                            counterData.setAttribute('type','hidden')
                            counterData.setAttribute('name','count')
                            counterData.setAttribute('value',response.countData)
                            counterData.setAttribute('form','submit-achievement')
                            var slider = document.createElement('input')
                            frthTd = document.createElement("td")
                            var spanOnFourthTD = document.createElement("span")
                            firstTd.setAttribute('class','sorting_1 text-center')
                            firstTd.setAttribute('tabindex','0')
                            firstTd.appendChild(iteration)
                            scTd.setAttribute('class','text-center')
                            scTd.appendChild(nodeDataOutName)
                            fifthTd.appendChild(nodeDataOutDivName)
                            slider.setAttribute('type','range')
                            slider.setAttribute('class','form-range')
                            slider.setAttribute('min','0')
                            slider.setAttribute('max','100')
                            slider.setAttribute('step','5')
                            slider.setAttribute('form','submit-achievement')
                            slider.setAttribute('id','customRange_'+counted)
                            slider.setAttribute('value','0')
                            slider.setAttribute('onchange','slidervalfunc()')
                            slider.setAttribute('name','score_'+counted)
                            thrdTd.setAttribute('class','text-center')
                            thrdTd.appendChild(slider)
                            frthTd.setAttribute('class','text-center')
                            spanOnFourthTD.setAttribute('id','val_'+counted)
                            var hiddenUserId = document.createElement('input')
                            hiddenUserId.setAttribute('name','user_id_'+counted)
                            hiddenUserId.setAttribute('type','hidden')
                            hiddenUserId.setAttribute('value',dataOutId)
                            hiddenUserId.setAttribute('form','submit-achievement')
                            frthTd.appendChild(spanOnFourthTD)
                            tr.appendChild(firstTd)
                            tr.appendChild(scTd)
                            tr.appendChild(fifthTd)
                            tr.appendChild(thrdTd)
                            tr.appendChild(frthTd)
                            tr.appendChild(hiddenUserId)
                            document.getElementById('achievements_body_table').appendChild(counterData)
                            document.getElementById('achievements_body_table').appendChild(tr)
                        }
                    },
                    error : function (jXHR, textStatus, errorThrown) {
                        console.log(jXHR, textStatus, errorThrown)
                    }
                });
        },1000)
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


           

            $('#pickadate').on('change',function(){
                $('.scorethis').hide();
                periode = document.getElementById('query').value
                console.log(periode)
                var data
                var dataOutName
                var dataOutId
                var dataoutDivId
                var firstTd
                var tr
                var scTd
                var thrdTd
                var frthTd
                var fifthTd
                var counterData
                $.ajax({
                    url: url,
                    type : 'GET',
                    data : {
                        periode :periode
                    },
                    dataType:'json', 
                    success:function(response){
                        // console.log(response)
                        if(response.countData>0){
                            $('#data-exist').hide()
                            console.log("ada")
                        }
                        else{
                            console.log("tidak ada")
                            $('#data-exist').show()
                        }
                        $('#headerTable').show()
                        let count = 0
                        // $('#data-exist').hide()
                        for(data in response.data){
                            var counted =count+=1
                            var iteration = document.createTextNode(counted)
                            dataOutName = response.data[data].staff_name
                            var nodeDataOutName = document.createTextNode(dataOutName)
                            dataOutId = response.data[data].id
                            var nodeDataOutId = document.createTextNode(dataOutId)
                            dataoutDivId = response.data[data].division_id
                            var nodeDataOutDivId = document.createTextNode(dataOutId)
                            var nodeDataOutDivName = document.createTextNode(response.data[data].division_name)
                            tr = document.createElement("tr")
                            tr.setAttribute('class','scorethis')
                            firstTd = document.createElement("td")
                            scTd = document.createElement("td")
                            thrdTd = document.createElement("td")
                            fifthTd = document.createElement("td")
                            counterData=document.createElement('input')
                            counterData.setAttribute('type','hidden')
                            counterData.setAttribute('name','count')
                            counterData.setAttribute('value',response.countData)
                            counterData.setAttribute('form','submit-achievement')
                            var slider = document.createElement('input')
                            frthTd = document.createElement("td")
                            var spanOnFourthTD = document.createElement("span")
                            firstTd.setAttribute('class','sorting_1 text-center')
                            firstTd.setAttribute('tabindex','0')
                            firstTd.appendChild(iteration)
                            scTd.setAttribute('class','text-center')
                            scTd.appendChild(nodeDataOutName)
                            fifthTd.appendChild(nodeDataOutDivName)
                            slider.setAttribute('type','range')
                            slider.setAttribute('class','form-range')
                            slider.setAttribute('min','0')
                            slider.setAttribute('max','100')
                            slider.setAttribute('step','5')
                            slider.setAttribute('form','submit-achievement')
                            slider.setAttribute('id','customRange_'+counted)
                            slider.setAttribute('value','0')
                            slider.setAttribute('onchange','slidervalfunc()')
                            slider.setAttribute('name','score_'+counted)
                            thrdTd.setAttribute('class','text-center')
                            thrdTd.appendChild(slider)
                            frthTd.setAttribute('class','text-center')
                            spanOnFourthTD.setAttribute('id','val_'+counted)
                            var hiddenUserId = document.createElement('input')
                            hiddenUserId.setAttribute('name','user_id_'+counted)
                            hiddenUserId.setAttribute('type','hidden')
                            hiddenUserId.setAttribute('value',dataOutId)
                            hiddenUserId.setAttribute('form','submit-achievement')
                            frthTd.appendChild(spanOnFourthTD)
                            tr.appendChild(firstTd)
                            tr.appendChild(scTd)
                            tr.appendChild(fifthTd)
                            tr.appendChild(thrdTd)
                            tr.appendChild(frthTd)
                            tr.appendChild(hiddenUserId)
                            document.getElementById('achievements_body_table').appendChild(counterData)
                            document.getElementById('achievements_body_table').appendChild(tr)
                        }
                    },
                    error : function (jXHR, textStatus, errorThrown) {
                        console.log(jXHR, textStatus, errorThrown)
                    }
                });      
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
