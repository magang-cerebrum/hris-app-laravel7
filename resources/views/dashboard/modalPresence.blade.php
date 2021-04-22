<!-- modal -->
<?php $date = date('d-m-Y') ?>
<div class="modal fade" id="modal-presence" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Staff Belum Absen Tanggal, {{$date}}</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="background-color: #2B323A; color: #FFFFFF; font-weight: bold; margin-bottom: 10px">
                            <td class="sorting_asc text-center">Nama</td>
                            <td class="sorting_asc text-center">DIvisi</td>
                            <td class="sorting_asc text-center">Shift</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_absensi as $item)
                            <tr>
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">{{$item->division}}</td>
                                <td class="text-center">{{$item->shift}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
