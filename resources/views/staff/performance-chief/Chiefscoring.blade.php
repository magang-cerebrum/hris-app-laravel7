@extends('layouts/templateStaff')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Penilaian')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">

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
  background: #242275;
  border-radius: 25px;
  border: 0px solid #000101;
}
input[type=range]::-webkit-slider-thumb {
  box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
  border: 0px solid #000000;
  height: 20px;
  width: 39px;
  border-radius: 7px;
  background: #090735;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -3.6px;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #242275;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 12.8px;
  cursor: pointer;
  animate: 0.2s;
  box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
  background: blue;
  border-radius: 25px;
  border: 0px solid #000101;
}
input[type=range]::-moz-range-thumb {
        box-shadow: 0px 0px 0px #000000, 0px 0px 0px #0d0d0d;
        border: 0px solid #000000;
        height: 20px;
        width: 39px;
        border-radius: 7px;
        background: #090735;
        cursor: pointer;
    }



    </style>
@endsection
@section('content')
<div class="panel panel-bordered panel-primary">
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">

    <div class="panel-heading">
        <h3 class="panel-title">Pemberian Nilai Performa Karyawan</h3>
    </div>
    <div class="panel-body">
        <form action="{{url('/staff/performance/scoring')}}" method="POST" id="submit-achievement">
            @csrf
            <div class="row mar-btm">
              <div class="col-sm-4"></div>
              <div class="col-sm-4">
                      <div id="pickadate">
                          <div class="input-group date">
                              <span class="input-group-btn">
                                  <button class="btn btn-primary" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                              </span>
                              <input type="text" name="date" placeholder="Masukan Periode Penilian" class="form-control"
                                  autocomplete="off" id="query" readonly>
                          </div>
                      </div>
                  
              </div>
              <div class="col-sm-4"></div>
          </div>
                <table id="scoring"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                   
                    <thead id="headerTable" hidden>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Karyawan</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Penilaian Performa Karyawan </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Value </th>
                                
                            </tr>
                    </thead>
                    
                    <tbody id="performance_body_table">
                           
                            {{-- <input type="hidden" name="count" value="{{count($data)}}" >
                        @foreach ($data as $item)
                        
                        <tr>
                            <input type="hidden" name="division_id_{{$loop->iteration}}" value="{{$item->division_id}}">
                            <input type="hidden" name="user_id_{{$loop->iteration}}" value="{{$item->id}}">
                            <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{$item->name}}</td>
                            

                            <td class="text-center">
                                <input type="range" class="form-range" min="0" max="100" id="customRange_{{$loop->iteration}}" name="score_{{$loop->iteration}}" value="0" oninput="slidervalfunc()" step="5">     
                                <input type="hidden" name="id-{{$item->id}}" value="{{$item->id}}">
                            </td>
                            <td>
                               <span id="val_{{$loop->iteration}}"></span>
                            </td>
                        </tr>
                        @endforeach
                    
                         --}}
                    </tbody>
                   
                </table>
            
        
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" id="button-submit">Nilai</button>
    </div>
</form>
</div>

@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>

<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>

<script>   
   
   function slidervalfunc(){
    var tr = document.getElementsByTagName('tr');
    for (i = 1; i<tr.length;i++){
        var output = document.getElementById('val_'+i)
        var slider= document.getElementById('customRange_' + i)
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
        var url = '/staff/performance/ajx/pickdate'

        $('#pickadate').on('change',function(){
            $('.scorethis').remove();
            periode = document.getElementById('query').value
            // console.log(periode)
            
            var data
            var dataOutName
            var dataOutId
            var dataoutDivId
            var firstTd
            var tr
            var scTd
            var thrdTd
            var frthTd
            var counterData
                $.ajax({
                    url: url,
                    type : 'GET',
                    data : {
                        periode :periode
                    },
                    dataType:'json', 
                    success:function(response){
                        $('#headerTable').show()
                        // console.log(response)
                        let count = 0
                       
                        for(data in response.data){
                        //    console.log(response)
                            var counted =count+=1
                            var iteration = document.createTextNode(counted)
                            dataOutName = response.data[data].name
                            var nodeDataOutName = document.createTextNode(dataOutName)
                            dataOutId = response.data[data].id
                            var nodeDataOutId = document.createTextNode(dataOutId)
                            dataoutDivId = response.data[data].division_id
                            var nodeDataOutDivId = document.createTextNode(dataOutId)
                            tr = document.createElement("tr")
                            tr.setAttribute('class','scorethis')
                            firstTd = document.createElement("td")
                            scTd = document.createElement("td")
                            thrdTd = document.createElement("td")
                            counterData=document.createElement('input')
                            counterData.setAttribute('type','hidden')
                            counterData.setAttribute('name','count')
                            counterData.setAttribute('value',response.countData)
                            var slider = document.createElement('input')
                            // var sliderhidden = document.createElement('input')
                            frthTd = document.createElement("td")
                            var spanOnFourthTD = document.createElement("span")
                            firstTd.setAttribute('class','sorting_1 text-center')
                            firstTd.setAttribute('tabindex','0')
                            firstTd.appendChild(iteration)
                            scTd.setAttribute('class','text-center')
                            scTd.appendChild(nodeDataOutName)
                            slider.setAttribute('type','range')
                            slider.setAttribute('class','form-range')
                            slider.setAttribute('min','0')
                            slider.setAttribute('max','100')
                            slider.setAttribute('step','5')
                            slider.setAttribute('id','customRange_'+counted)
                            slider.setAttribute('value','0')
                            slider.setAttribute('onchange','slidervalfunc()')
                            slider.setAttribute('name','score_'+counted)
                            // sliderhidden.setAttribute('type','hidden')
                            // sliderhidden.setAttribute('value',dataOutId)
                            // sliderhidden.setAttribute('name',"id_"+dataOutId)
                            thrdTd.setAttribute('class','text-center')
                            thrdTd.appendChild(slider)
                            // thrdTd.appendChild(sliderhidden)
                            frthTd.setAttribute('class','text-center')
                            spanOnFourthTD.setAttribute('id','val_'+counted)
                            var hiddenDivisionId = document.createElement('input')
                            var hiddenUserId = document.createElement('input')
                            hiddenDivisionId.setAttribute('name','division_id_'+counted)
                            hiddenDivisionId.setAttribute('type','hidden')
                            hiddenDivisionId.setAttribute('value',dataoutDivId)
                        
                            hiddenUserId.setAttribute('name','user_id_'+counted)
                            hiddenUserId.setAttribute('type','hidden')
                            hiddenUserId.setAttribute('value',dataOutId)
                            frthTd.appendChild(spanOnFourthTD)
                            tr.appendChild(firstTd)
                            tr.appendChild(scTd)
                            tr.appendChild(thrdTd)
                            tr.appendChild(frthTd)
                            tr.appendChild(hiddenDivisionId)
                            tr.appendChild(hiddenUserId)
                            document.getElementById('performance_body_table').appendChild(counterData)
                            document.getElementById('performance_body_table').appendChild(tr)
                            
                            
                        }
                        // console.log(response)
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
 //    </script>
@endsection
   
@endsection
