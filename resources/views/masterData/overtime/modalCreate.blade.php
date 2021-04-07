<div class="modal fade" id="modal-create-overtime" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Form Tambah Lembur "<span id="name-title"></span>"</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/admin/overtime/store')}}" method="post" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="salary" id="salary">
                    <input type="hidden" name="user_hour" id="user_hour">
                    <input type="hidden" name="payment" id="payment">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label">Nama Staff:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Nama Staff" name="name" class="form-control" id="name" readonly>
                            </div>
                            <label class="col-sm-1 control-label">NIP:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="NIP" name="nip" class="form-control" id="nip" readonly>
                            </div>                            
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label">Bulan/Tahun:</label>
                            <div id="pickadate">
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <input type="text" class="form-control @error('periode') is-invalid @enderror"
                                            placeholder="Periode" name="periode" value="{{old('periode')}}">
                                        <span class="input-group-addon btn-mint"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    @error('periode') <div class="text-danger invalid-feedback mt-3">Mohon isi
                                        tanggal lahir.</div> @enderror
                                </div>
                            </div>
                            <label class="col-sm-1 control-label">Jam:</label>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Jumlah Jam Lembur" name="hour" class="form-control" id="hour" onkeyup="calculate(this.value)">
                            </div>                            
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div id="information"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambahkan Data Lembur">Tambah</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
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
        $(document).on('click', '#create_overtime', function () {
            
            var id = $(this).data('id');
            var nip = $(this).data('nip');
            var name = $(this).data('name');
            var salary = $(this).data('salary');
            var user_hour = $(this).data('user_hour');

            document.getElementById('id').value = id;
            document.getElementById('nip').value = nip;
            document.getElementById('name').value = name;
            document.getElementById('salary').value = salary;
            document.getElementById('user_hour').value = user_hour;

            $('#name-title').text(name);
        });
    });

    function calculate(hour) {

        hour.replace(/[^,\d]/g, '').toString();
        document.getElementById("hour").value = hour;

        var salary = document.getElementById('salary').value;
        var user_hour = document.getElementById('user_hour').value;
        var payment = Math.round(( salary / user_hour ) * hour);
        // var payment = (( salary / user_hour ) * hour);
        console.log(salary,user_hour,payment)
    }

    // Sweetalert 2
    function submit_add() {
        event.preventDefault();
        var check_user = document.querySelector('.sub_chk:checked');
        var check_year = document.getElementById('periode').value;
        if (check_year != '' && check_user != null) {
            $('#form-check-user-month').submit();
        } else if (check_year == '' && check_user == null) {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Mohon isi tahun dan pilih staff terlebih dahulu...",
                icon: 'error',
            });
            return false;
        } else if (check_year == '') {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Mohon isi periode terlebih dahulu...",
                icon: 'error',
            });
            return false;
        } else if (check_user == null) {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada staff yang dipilih untuk diatur jadwalnya!",
                icon: 'error',
            });
            event.preventDefault();
            return false;
        }
    }

</script>
@endsection
