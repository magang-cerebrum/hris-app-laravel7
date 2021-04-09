<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Daftar Lembur "'.switch_month($month) . ' - ' . $year . '"'}}</h3>
    </div>
    <div class="panel-body">
        <div class="row mar-btm">
            <div class="col-sm-12">


                <form action="{{url('/admin/salary/processed')}}" method="post">
                    @csrf
                    <input type="hidden" name="month" value="{{$month}}">
                    <input type="hidden" name="year" value="{{$year}}">
                    <button href="{{url('/admin/overtime/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Tambah Lembur Baru" type="submit">
                        <i class="btn-label fa fa-plus"></i>
                        Ambil Data Gaji Baru
                    </button>
                    <button class="btn btn-success btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top" form="slip"
                        data-original-title="Tambah Lembur Baru" type="submit">
                        <i class="btn-label fa fa-check"></i>
                        Cetak Slip Gaji Data Terpilih
                    </button>
                    <button class="btn btn-danger btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top" form="reset"
                        data-original-title="Tambah Lembur Baru" type="submit">
                        <i class="btn-label fa fa-check"></i>
                        Reset Log Salary
                    </button>
                </form>
                <form action="{{url('/admin/salary/reset')}}" method="post" id="reset">
                    @csrf
                </form>
                <form action="{{url('/admin/salary/slip')}}" method="post" id="slip">
                    @csrf
                </form>
            </div>
        </div>
        @if(!$data->isEmpty())
        
        <table id="salary-result" class="table table-striped table-bordered no-footer dtr-inline collapsed"
            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
            <thead>
                <tr role="row">
                    @if ($data[0] == null)
                    <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data gaji ditemukan!</th>
                    @else
                    <th class="sorting_asc text-center" tabindex="0">Checked</th>
                    <th class="sorting_asc text-center">Aksi / File Slip Gaji</th>
                    <th class="sorting_asc text-center">Nama</th>
                    <th class="sorting_asc text-center">Periode</th>
                    <th class="sorting_asc text-center">Total Jam Kerja Seharusnya</th>
                    <th class="sorting_asc text-center">Total Jam Kerja</th>
                    <th class="sorting_asc text-center">Total Keterlambatab</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <?php
                        $string_time_work = split_time($item->total_work_time);
                        $string_time_late = split_time($item->total_late_time);
                    ?>
                    <td class="text-center">
                        @if ($item->status == "Pending")
                            <input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}" form="slip">
                        @else
                            Slip Gaji Sudah Tersedia
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->status == "Pending")
                            <a href="/admin/salary/{{$item->id}}/edit"
                                class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Edit Staff"
                                type="button">
                                <i class="fa fa-pencil-square"></i>
                            </a>
                        @else
                            <a href="{{ asset('/upload_recruitment/cv_upload/'.$item->file_salary)}}" target="blank">
                                <button type="button" class="btn btn-pink btn-icon btn-circle add-tooltip"
                                    data-toggle="tooltip" data-container="body" data-placement="top"
                                    data-original-title="Buka CV">
                                    <i class="fa fa-file icon-lg"></i>
                                </button>
                            </a>
                        @endif
                    </td>
                    <td class="text-center">{{$item->user_name}}</td>
                    <td class="text-center">{{$item->month . ' - ' . $item->year}}</td>
                    <td class="text-center">{{$item->total_default_hour.' Jam'}}</td>
                    <td class="text-center">{{$string_time_work}}</td>
                    <td class="text-center">{{$string_time_late}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        @else
        <div class="text-center text-danger text-bold">Ma'af, tidak ada data gaji ditemukan untuk periode {{switch_month($month) . ' - ' . $year}}</div>
        @endif
    </div>
</div>