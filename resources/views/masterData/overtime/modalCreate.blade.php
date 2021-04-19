<div class="modal fade" id="modal-create-overtime" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <form action="{{url('/admin/overtime/store')}}" method="POST" class="form-horizontal"
        id="form-overtime">
        @csrf
    </form>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Form Tambah Lembur "<span id="name-title"></span>"</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" id="user_id" form="form-overtime">
                <input type="hidden" name="salary" id="salary" form="form-overtime">
                <input type="hidden" name="user_hour" id="user_hour" form="form-overtime">
                <input type="hidden" name="payment" id="payment" form="form-overtime">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Nama Staff:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Nama Staff" name="name" class="form-control" id="name" disabled form="form-overtime">
                        </div>
                        <label class="col-sm-1 control-label">NIP:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="NIP" name="nip" class="form-control" id="nip" disabled form="form-overtime">
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Bulan/Tahun:</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="periode" name="periode" class="form-control"
                                value="{{$month.'/'.$year}}" form="form-overtime" readonly>
                        </div>
                        <label class="col-sm-1 control-label">Jam:</label>
                        <div class="col-sm-4">
                            <input type="number" placeholder="Jumlah Jam Lembur" name="hour"
                                class="form-control @error('hour') is-invalid @enderror" id="hour"
                                onkeyup="calculate(this.value)" form="form-overtime">
                            @error('hour') <div class="text-danger">Mohon isi jam lembur.</div> @enderror
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div id="information" class="text-info text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success add-tooltip" id="btn-submit" data-toggle="tooltip"
                    data-container="body" data-placement="top"
                    data-original-title="Tambahkan Data Lembur" onclick="submit_form()" form="form-overtime">Tambah</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{ asset('js/helpers.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#create_overtime', function () {
            var id = $(this).data('id');
            var nip = $(this).data('nip');
            var name = $(this).data('name');
            var salary = $(this).data('salary');
            var user_hour = $(this).data('user_hour');

            document.getElementById('user_id').value = id;
            document.getElementById('nip').value = nip;
            document.getElementById('name').value = name;
            document.getElementById('salary').value = salary;
            document.getElementById('user_hour').value = user_hour;
            document.getElementById('hour').value = '';
            document.getElementById('information').innerHTML = '';

            $('#name-title').text(name);
        });
        $(document).on('click', '#btn-submit', function () {
            event.preventDefault();
            if (document.getElementById('hour').value != '') {
                Swal.fire({
                    width: 600,
                    title: 'Anda yakin dengan data yang akan di tambahkan?',
                    text: "Data yang sudah dimasukan tidak dapat dirubah kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value == true) {
                        $('#form-overtime').submit();
                    } else {
                        Swal.fire({
                            width: 600,
                            title: 'Dibatalkan!',
                            text: "Pastikan data diisi dengan benar terlebih dahulu!",
                            icon: 'error',
                        });
                    }
                })
            } else {
                Swal.fire({
                    width: 600,
                    title: 'Error',
                    text: 'Mohon isi jam lembur terlebih dahulu',
                    icon: 'error'
                });
            }
        })
    });

    function calculate(hour) {

        hour.replace(/[^,\d]/g, '').toString();
        document.getElementById("hour").value = hour;

        var salary = document.getElementById('salary').value;
        var user_hour = document.getElementById('user_hour').value;
        var payment = Math.round((salary / user_hour) * hour);
        document.getElementById('information').innerHTML = 'Upah Lembur sebesar <strong>"' + format_rupiah(payment) +
            '"</strong> dihitung dari <strong>"' + hour + '"</strong> jam lembur';
        document.getElementById('payment').value = payment;
    }

</script>
@endsection
