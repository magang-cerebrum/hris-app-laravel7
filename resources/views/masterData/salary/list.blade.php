<div class="panel panel-bordered panel-danger fade-in">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Daftar Gaji "'.switch_month($month) . ' - ' . $year . '"'}}</h3>
    </div>
    
    <form action="{{url('/admin/salary/processed')}}" method="post" id="get_salary">
        @csrf
        <input type="hidden" name="month" value="{{$month}}">
        <input type="hidden" name="year" value="{{$year}}">   
    </form>
    <form action="{{url('/admin/salary/reset')}}" method="post" id="reset">
        @csrf
    </form>
    <form action="{{url('/admin/salary/slip')}}" method="post" id="slip">
        @csrf
    </form>

    <div class="panel-body" style="padding-top: 20px">
        <div class="row mar-btm" id="row_btn">
            <div id="btn_paid_leave">
                <button class="btn btn-primary btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top" form="get_salary"
                    data-original-title="Ambil Data Gaji Baru" type="submit" >
                    <i class="btn-label fa fa-plus"></i>
                    Ambil Data Gaji Baru
                </button>
            </div>
            <div id="btn_paid_leave">
                <button class="btn btn-success btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top" form="slip"
                    data-original-title="Cetak Slip Gaji Data Terpilih" type="submit" onclick="submit_add()">
                    <i class="btn-label fa fa-check"></i>
                    Cetak Slip Gaji Data Terpilih
                </button>
            </div>
            <div id="btn_paid_leave">
                <button class="btn btn-danger btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top" form="reset"
                    data-original-title="Reset Log Salary" type="submit">
                    <i class="btn-label fa fa-check"></i>
                    Reset Log Salary
                </button>
            </div>
        </div>

        @if (!$bool_check_day)    
            <div class="row mar-btm">
                <div class="col-sm-12 text-danger text-bold text-center">
                    Ma'af Anda Belum Bisa Mengambil Data Gaji Periode {{switch_month($month) . ' - ' . $year}}, Karena Belum Melewati Tanggal {{$next_date}}
                </div>
            </div>
        @endif

        @if(!$data->isEmpty())
            <div class="table-responsive">
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
                                <th class="sorting_asc text-center">Divisi</th>
                                <th class="sorting_asc text-center">Periode</th>
                                <th class="sorting_asc text-center">Total Jam Kerja Seharusnya</th>
                                <th class="sorting_asc text-center">Total Jam Kerja</th>
                                <th class="sorting_asc text-center">Total Keterlambatan</th>
                                <th class="sorting_asc text-center">Total Absen</th>
                                <th class="sorting_asc text-center">Total Sakit</th>
                                <th class="sorting_asc text-center">Total Cuti</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <?php
                                    $string_time_work = split_time($item->total_work_time);
                                    $string_time_late = split_time($item->total_late_time);
                                    $default_salary = rupiah($item->default_salary);
                                    $total_fine = rupiah($item->total_fine);
                                    $total_salary_allowance = rupiah($item->total_salary_allowance);
                                    $total_salary_cut = rupiah($item->total_salary_cut);
                                    $total_salary = rupiah($item->total_salary);
                                ?>
                                <td class="text-center">
                                    @if ($item->status == "Pending")
                                        <input type="checkbox" class="sub_chk" name="check[]" value="{{$item->id}}" form="slip">
                                    @else
                                        Slip Gaji Sudah Tersedia
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span id="detail_salary_staff" data-toggle="modal" data-target="#modal-salary-staff"
                                        style="display: inline;" data-nip="{{$item->nip}}"
                                        data-name="{{$item->user_name}}" data-division_name="{{$item->division}}"
                                        data-position_name="{{$item->position}}" data-periode="{{switch_month($item->month) . ' - ' . $item->year}}"
                                        data-total_hour="{{$item->total_default_hour.' Jam'}}" data-work_hour="{{$string_time_work}}"
                                        data-absen="{{$item->total_absen}}" data-sick="{{$item->total_sick}}" data-paid_leave="{{$item->total_paid_leave}}" 
                                        data-late="{{$string_time_late}}" data-salary="{{$default_salary}}"
                                        data-fine="{{$total_fine}}" data-allowance="{{$total_salary_allowance}}"
                                        data-cut="{{$total_salary_cut}}" data-total_salary="{{$total_salary}}">
                                        <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Detail Gaji Staff"
                                            type="button">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </span>
                                    @if ($item->status == "Pending")
                                        <a href="/admin/salary/{{$item->id}}/edit"
                                            class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Edit Staff"
                                            type="button">
                                            <i class="fa fa-pencil-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ asset('/file_slip/'.$item->file_salary)}}" target="blank">
                                            <button type="button" class="btn btn-pink btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="top"
                                                data-original-title="Buka CV">
                                                <i class="fa fa-file icon-lg"></i>
                                            </button>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">{{$item->user_name}}</td>
                                <td class="text-center">{{$item->division}}</td>
                                <td class="text-center">{{switch_month($item->month) . ' - ' . $item->year}}</td>
                                <td class="text-center">{{$item->total_default_hour.' Jam'}}</td>
                                <td class="text-center">{{$string_time_work}}</td>
                                <td class="text-center">{{$string_time_late}}</td>
                                <td class="text-center">{{$item->total_absen . ' hari'}}</td>
                                <td class="text-center">{{$item->total_sick . ' hari'}}</td>
                                <td class="text-center">{{$item->total_paid_leave . ' hari'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-danger text-bold">Ma'af, tidak ada data gaji ditemukan untuk periode {{switch_month($month) . ' - ' . $year}}</div>
        @endif
    </div>
</div>
@include('masterData/salary/detail')