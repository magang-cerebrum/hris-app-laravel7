@extends('layouts/templateAdmin')
@section('title','Achievement')
@section('content-title','Penghargaan / Achievement Scoring')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    

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
    <div class="panel-body">
        <div class="row mar-btm">
          <div class="col-sm-6">
              <form action="/admin/achievement/scoring" method="post" style="display: inline">
                @csrf
                {{-- <label class="col-sm-1 control-label">Bulan:</label> --}}
                <div>
                    
                        <div class="input-group">
                            <span class="input-group-addon">Bulan :</span>
                            
                            <select class="selectpicker" data-style="btn-info" 
                            style="width: 100%" 
                            id="filter-bulan"  name="month">
                                <option value=" "></option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                            <span class="input-group-addon">Tahun :</span>
                            <input type="text" class="form-control @error('year') is-invalid @enderror"
                                placeholder="Tahun" name="year" value="{{old('year')}}"  autocomplete="off">
                        </div>
                        {{-- @error('start') <div class="text-danger invalid-feedback mt-3">Mohon isi
                            tanggal mulai.</div> @enderror
                        @error('end') <div class="text-danger invalid-feedback mt-3">Mohon isi
                        tanggal akhir.</div> @enderror --}}
                    </div>
                </div>
        </div>
                <table id="scoring"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                   
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Karyawan</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Penilaian Karyawan </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Value </th>
                                
                            </tr>
                    </thead>

                    <tbody>

                            <input type="hidden" name="count" value="{{count($data)}}" >
                        @foreach ($data as $item)
                        
                        <tr>
                            <input type="hidden" name="user_id_{{$loop->iteration}}" value="{{$item->id}}">
                            <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                            {{-- <td tabindex="0" class="sorting_1 text-center">{{$row->id}}</td> --}}
                            <td class="text-center">{{$item->name}}</td>
                            

                            <td class="text-center">
                                <input type="range" class="form-range" min="0" max="100" id="customRange_{{$loop->iteration}}" name="score_{{$loop->iteration}}" value="0" oninput="slidervalfunc()">     
                                <input type="hidden" name="id-{{$item->id}}" value="{{$item->id}}">
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
        <button class="btn btn-mint" type="submit">Tambah</button>
    </div>
</form>
</div>

@section('script')

<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>

<script>   
   
    function slidervalfunc(){
         var tr = document.getElementsByTagName('tr');
         for (i = 1; i<tr.length;i++){
     
             var output = document.getElementById('val_'+i)
             var slider= document.getElementById('customRange_' + i)
                 output.innerHTML = slider.value + '/100'
             
             }
             
         
     }
 //    </script>
@endsection
   
@endsection
