<!-- modal form reject -->
<form class="form-horizontal" action="" method="POST" id="form-reject">
    @csrf
    @method('put')
</form>

<div class="modal fade" id="modal-reject" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Form Penolakan Pengajuan Cuti</h5>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><label for="nip">NIP: </label></td>
                                <td><span id="nip"></span></td>
                                <td><label for="name">Nama Staff: </label></td>
                                <td><span id="name"></span></td>
                            </tr>
                            <tr>
                                <td><label for="paidleaveleft">Sisa Cuti Tahunan Staff: </label></td>
                                <td><span id="paidleaveleft"></span></td>
                                <td><label for="days">Jumlah Hari Pengajuan Cuti: </label></td>
                                <td><span id="days"></span></td>
                            </tr>
                            <tr>
                                <td><label for="datestart">Tanggal Awal Cuti: </label></td>
                                <td><span id="datestart"></span></td>
                                <td><label for="dateend">Tanggal Akhir Cuti: </label></td>
                                <td><span id="dateend"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="textarea-needs-message">Keterangan Cuti:</label>
                            <div class="col-sm-10">
                                <textarea id="needs" rows="2" class="form-control" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="textarea-informations-message">Alasan Penolakan:</label>
                            <div class="col-sm-10">
                                <textarea id="textarea-informations-message" rows="2" class="form-control"
                                    placeholder="Masukan keterangan penolakan disini" name="informations"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success add-tooltip" type="submit" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Kirim Penolakan Pengajuan Cuti" form="form-reject">Kirim Penolakan</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#master').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });
        $(document).on('click', '#reject', function () {
            var id = $(this).data('id');
            var nip = $(this).data('nip');
            var name = $(this).data('name');
            var paidleaveleft = $(this).data('paidleaveleft');
            var days = $(this).data('days');
            var datestart = $(this).data('datestart');
            var dateend = $(this).data('dateend');
            var needs = $(this).data('needs');
            
            var join = `{{ url('/admin/paid-leave/` + id + `/reject')}}`;
            $('#form-reject').attr('action', join);

            $('#nip').text(nip);
            $('#name').text(name);
            $('#paidleaveleft').text(paidleaveleft);
            $('#days').text(days);
            $('#datestart').text(datestart);
            $('#dateend').text(dateend);
            $('#needs').text(needs);
        });
    });

    function submit_approve(){
        event.preventDefault();
        var check = document.querySelector('.sub_chk:checked');
        if (check != null){
            Swal.fire({
                title: 'Anda yakin ingin menyetujui pengajuan cuti dari data terpilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Terima',
                cancelButtonText: 'Tidak',
                width: 600
            }).then((result) => {
                if (result.value == true) {
                    $('#form-approve-pending').attr('action', '/admin/paid-leave/approve');
                    $("#form-approve-pending").submit();
                }}
            );
        } else {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada data yang pengajuan cuti yang dipilih untuk disetujui!",
                icon: 'error',
            })
        }
    }
    function submit_pending(){
        event.preventDefault();
        var check = document.querySelector('.sub_chk:checked');
        if (check != null){
            Swal.fire({
                title: 'Anda yakin ingin menunda pengajuan cuti dari data terpilih?',
                text: 'Beritahu staff untuk memberikan informasi lebih lanjut mengenai cuti!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Pending',
                cancelButtonText: 'Tidak',
                width: 600
            }).then((result) => {
                if (result.value == true) {
                    $('#form-approve-pending').attr('action', '/admin/paid-leave/pending');
                    $("#form-approve-pending").submit();
                }}
            );
        } else {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada data yang pengajuan cuti yang dipilih untuk ditunda!",
                icon: 'error',
            })
        }
    }
</script>
@endsection