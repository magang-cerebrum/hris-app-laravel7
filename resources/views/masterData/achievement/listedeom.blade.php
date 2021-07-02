<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Pemilihan Karyawan Terbaik</h3>
    </div>
    <div class="panel-body">
        <form action="{{url('/admin/achievement/eom/chosed')}}" method="POST" id="choose-eom">
            @csrf
        </form>
            <table class="table table-hover table-vcenter">
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
                                        {{-- @dump($data->where('division_id','=',$divisionsItems->id)->count()) --}}
                                        @if ($data->where('division_id','=',$divisionsItems->id)->count()==0)
                                            <td colspan="4" class="text-uppercase text-bold text-center" id="data-exist">Nilai Achievement dan Nilai Performance pada periode ini belum ada</td>
                                        @else
                                        @foreach ($data->where('division_id','=',$divisionsItems->id) as $dataItem)
                                       
                                        <tr>
                                           
                                            <td class="text-center" id="staff_name">{{$dataItem->staff_name}}</td>
                                            <td class="text-center">{{$dataItem->achievement_score}}</td>
                                            <td class="text-center">{{$dataItem->performance_score}}</td>
                                            <td class="text-center"><input type="radio" name="radio_input_eom"
                                                    id="radio-eom{{$loop->iteration}}" form="choose-eom" value="{{$dataItem->staff_id}}"></td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <input type="hidden" name="year" value="{{$year}}" form="choose-eom">
            <input type="hidden" name="month"value="{{$month}}" form="choose-eom">
            <button type="submit" class="btn btn-danger" id="btn-submit" form="choose-eom">Pilih</button>
        
    </div>
</div>