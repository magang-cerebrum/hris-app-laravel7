<div class="modal fade" id="modal-create-overtime" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Form Tambah Lembur "<span id="name-title"></span>"</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/admin/overtime/store')}}" method="POST" class="form-horizontal" id="form-overtime">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" form="form-overtime">
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
                            <label class="col-sm-2 control-label">Gaji Pokok Staff:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Gaji Pokok Staff" class="form-control" id="salary" disabled form="form-overtime">
                            </div>
                            <label class="col-sm-2 control-label">Jam Kerja Sebulan:</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Jumlah Jam Kerja Sebulan" class="form-control" id="user_hour" disabled form="form-overtime">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label">Periode:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="periode" name="periode" class="form-control"
                                    value="{{switch_month($month).'-'.$year}}" form="form-overtime" readonly style="cursor: not-allowed">
                            </div>
                            <label class="col-sm-2 control-label">Upah Per-jam Lembur:</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Upah Per-jam Lembur" id="perhour" class="form-control"
                                form="form-overtime" disabled>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label">Jam:</label>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Jumlah Jam Lembur" name="hour"
                                    class="form-control @error('hour') is-invalid @enderror" id="hour"
                                    onkeyup="calculate(this.value)" form="form-overtime">
                                @error('hour') <div class="text-danger">Mohon isi jam lembur.</div> @enderror
                            </div>
                            <div class="col-sm-6"></div>
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
            </form>
        </div>
    </div>
</div>

@section('script')
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('js/helpers.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#filter').selectpicker({
                dropupAuto: false
            });
            $(document).on('click', '#create_overtime', function () {
                var id = $(this).data('id');
                var nip = $(this).data('nip');
                var name = $(this).data('name');
                var salary = $(this).data('salary');
                var user_hour = $(this).data('user_hour');
                var perhour = Math.round(salary/user_hour);

                document.getElementById('user_id').value = id;
                document.getElementById('nip').value = nip;
                document.getElementById('name').value = name;
                document.getElementById('salary').value = format_rupiah(salary);
                document.getElementById('user_hour').value = user_hour + ' jam';
                document.getElementById('perhour').value = format_rupiah(perhour);
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

            var get_salary = document.getElementById('salary').value;
            var salary = get_salary.replace(/Rp. /i, '').replace('.', '').toString();
            var get_user_hour = document.getElementById('user_hour').value;
            var user_hour = get_user_hour.replace(/ jam/i, '').toString();

            var perhour = Math.round(salary / user_hour);
            var payment = Math.round(perhour * hour);
            
            document.getElementById('information').innerHTML = 'Upah Lembur sebesar <strong>"' + format_rupiah(payment) +
                '"</strong> dihitung dari <strong>"' + hour + '"</strong> jam lembur dikali upah lembur per-jam sebesar <strong>"' + format_rupiah(perhour) + '"</strong>';
            document.getElementById('payment').value = payment;
        }

        function filter_division() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("filter");
            filter = input.value.toUpperCase();
            if(filter == ' '){$("#overtime-create").addClass("hidden");}
            else{$("#overtime-create").removeClass("hidden");}
            table = document.getElementById("overtime-create");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                for (j = 2; j < 3; j++ ){
                        td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
@endsection
