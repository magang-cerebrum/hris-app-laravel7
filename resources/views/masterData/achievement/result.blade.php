
<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Leaderboard Achievement Bulan '.$data[0]->month.' - '.$data[0]->year}}</h3>
    </div>
    <div class="panel-body" style="padding-top: 20px">
        <table id="presensi-result"
            class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
            aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
            <thead>
                <tr role="row">
                    @if ($data[0] == null)
                        <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data achievement ditemukan!</th>
                    @else
                        <th class="sorting_asc text-center" tabindex="0">No</th>
                        <th class="sorting_asc text-center">Nama</th>
                        <th class="sorting text-center">Score</th>
                        <th class="sorting text-center">Bulan</th>
                        <th class="sorting text-center">Tahun</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $count; $i++)
                    <tr>
                        <td tabindex="0" class="sorting_1 text-center">{{$i+1}}</td>
                        @if ($data[$i]->score == $employee_of_the_month)
                            <td class="text-center"><i class="fa fa-star" title="Employee of The Month" style="color : gold"></i> {{$data[$i]->name}} <i class="fa fa-star" title="Employee of The Month" style="color : gold"></i></td>
                        @else 
                            <td class="text-center">{{$data[$i]->name}}</td>
                        @endif
                        <td class="text-center">{{$data[$i]->score}}</td>
                        <td class="text-center">{{$data[$i]->month}}</td>
                        <td class="text-center">{{$data[$i]->year}}</td>
                    </tr>    
                @endfor
            </tbody>
        </table>
    </div>
</div>