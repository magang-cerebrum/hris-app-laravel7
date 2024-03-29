<div class="modal fade" id="modal-detail-staff" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Detail Staff</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr style="background-color: #2B323A; color: #FFFFFF">
                            <td><label for="nip" class="text-bold">NIP: </label></td>
                            <td><span id="nip" class="text-bold"></span></td>
                            <td></td>
                            <td><label for="name" class="text-bold">Nama Lengkap: </label></td>
                            <td><span id="name" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td><label for="dob">Tanggal Lahir: </label></td>
                            <td><span id="dob"></span></td>
                            <td rowspan="13"></td>        
                            <td rowspan="4" colspan="2" class="text-center">
                                <img id="img-modal" src="" alt="Tidak ada foto profil." style="width:128px;">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="phone_number">Nomor Handphone: </label></td>
                            <td><span id="phone_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="ktp_number">No. KTP: </label></td>
                            <td><span id="ktp_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="kk_number">No. KK: </label></td>
                            <td><span id="kk_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="gender">Jenis Kelamin: </label></td>
                            <td><span id="gender"></span></td>
                            <td><label for="email">Email: </label></td>
                            <td><span id="email"></span></td>
                        </tr>
                        <tr>
                            <td><label for="employee_status">Status Staff: </label></td>
                            <td><span id="employee_status"></span></td>
                            <td><label for="contract_duration">Durasi Kontrak: </label></td>
                            <td><span id="contract_duration"></span></td>
                        </tr>
                        <tr>
                            <td><label for="status">Status Kerja: </label></td>
                            <td><span id="status"></span></td>
                            <td><label for="employee_type">Tipe Staff: </label></td>
                            <td><span id="employee_type"></span></td>
                        </tr>
                        <tr>
                            <td><label for="start_work_date">Tanggal Mulai Bekerja: </label></td>
                            <td><span id="start_work_date"></span></td>
                            <td><label for="end_work_date">Tanggal Akhir Bekerja: </label></td>
                            <td><span id="end_work_date"></span></td>
                        </tr>
                        <tr>
                            <td><label for="yearly_leave_remaining">Sisa Cuti Tahunan: </label></td>
                            <td><span id="yearly_leave_remaining"></span></td>
                            <td><label for="role_name">Hak Akses: </label></td>
                            <td><span id="role_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="division_name">Divisi: </label></td>
                            <td><span id="division_name"></span></td>
                            <td><label for="position_name">Jabatan: </label></td>
                            <td><span id="position_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="cc_number">No. Rekening: </label></td>
                            <td><span id="cc_number"></span></td>
                            <td><label for="salary">Gaji Pokok: </label></td>
                            <td><span id="salary"></span></td>
                        </tr>
                        <tr>
                            <td><label for="bpjskes_number">No. BPJS Kesehatan: </label></td>
                            <td><span id="bpjskes_number"></span></td>
                            <td><label for="bpjsket_number">No. BPJS Ketenagakerjaan: </label></td>
                            <td><span id="bpjsket_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="npwp_number">No. NPWP </label></td>
                            <td><span id="npwp_number"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
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
            $("#masterdata-staff").hide();
            $("#count-all").hide();
            $("#nactive-pagination").hide();
            // modal
            $(document).on('click', '#detail_staff', function () {
                var nip = $(this).data('nip');
                var name = $(this).data('name');
                var dob = $(this).data('dob');
                var address = $(this).data('address');
                var phone_number = $(this).data('phone_number');
                var gender = $(this).data('gender');
                var email = $(this).data('email');
                var profile_photo = $(this).data('profile_photo');
                var employee_status = $(this).data('employee_status');
                var employee_type = $(this).data('employee_type');
                var status = $(this).data('status');
                var contract_duration = $(this).data('contract_duration');
                var start_work_date = $(this).data('start_work_date');
                var end_work_date = $(this).data('end_work_date');
                var yearly_leave_remaining = $(this).data('yearly_leave_remaining');
                var division_name = $(this).data('division_name');
                var position_name = $(this).data('position_name');
                var role_name = $(this).data('role_name');
                var cc_number = $(this).data('cc_number');
                var salary = $(this).data('salary');
                var ktp_number = $(this).data('ktp_number');
                var kk_number = $(this).data('kk_number');
                var npwp_number = $(this).data('npwp_number');
                var bpjskes_number = $(this).data('bpjskes_number');
                var bpjsket_number = $(this).data('bpjsket_number');

                var join = `{{ asset('img/profile-photos/`+ profile_photo + `')}}`;

                if (contract_duration == '') {
                    contract_duration = '-'
                } else {
                    contract_duration = contract_duration + ' bulan'
                }

                
                //show image
                $("#img-modal").attr("src", join);

                //show data to html
                $('#nip').text(nip);
                $('#name').text(name);
                $('#dob').text(indonesian_date(dob));
                $('#address').text(address);
                $('#gender').text(gender);
                $('#email').text(email);
                $('#phone_number').text(phone_number);
                $('#employee_status').text(employee_status);
                $('#employee_type').text(employee_type);
                $('#status').text(status);
                $('#contract_duration').text(contract_duration);
                $('#start_work_date').text(indonesian_date(start_work_date));
                $('#end_work_date').text(indonesian_date(end_work_date));
                $('#yearly_leave_remaining').text(yearly_leave_remaining);
                $('#division_name').text(division_name);
                $('#position_name').text(position_name);
                $('#role_name').text(role_name);
                $('#cc_number').text(cc_number);
                $('#salary').text(format_rupiah(salary));
                $('#ktp_number').text(ktp_number);
                $('#kk_number').text(kk_number);
                $('#npwp_number').text(npwp_number);
                $('#bpjskes_number').text(bpjskes_number);
                $('#bpjsket_number').text(bpjsket_number);
            });
            
            $("#check-all").click(function () {
                if ($(this).is(":checked"))
                    $(".check-item").prop("checked", true);
                else
                    $(".check-item").prop("checked", false);
            });
            $("#check-all-active").click(function () {
                if ($(this).is(":checked"))
                    $(".check-item-active").prop("checked", true);
                else
                    $(".check-item-active").prop("checked", false);
            });
        });

        function toogle_nonaktif() {
            if (document.getElementById('toogle-nonaktif-radio-2').checked) {
                document.getElementById('masterdata-staff').style.display = 'none';
                document.getElementById('masterdata-staff-active').style.display = '';
                document.getElementById('count-all').style.display = 'none';
                document.getElementById('count-active').style.display = '';
                document.getElementById('nactive-pagination').style.display = 'none';
                document.getElementById('active-pagination').style.display = '';
            } else {
                document.getElementById('masterdata-staff').style.display = '';
                document.getElementById('masterdata-staff-active').style.display = 'none';
                document.getElementById('count-all').style.display = '';
                document.getElementById('count-active').style.display = 'none';
                document.getElementById('nactive-pagination').style.display = '';
                document.getElementById('active-pagination').style.display = 'none';
            }
        };

        function submit_delete(){
            event.preventDefault();
            var check1 = document.querySelector('.check-item:checked');
            var check2 = document.querySelector('.check-item-active:checked');
            if (check1 != null || check2 != null){
                Swal.fire({
                    title: 'Anda yakin ingin menghapus data terpilih?',
                    text: "Data yang sudah di hapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Tidak'
                    }).then((result) => {
                    if (result.value == true) {
                        $("#form-mul-delete").submit();
                    }}
                );
            } else {
                Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Tidak ada data yang dipilih untuk dihapus!",
                    icon: 'error',
                })
            }
        }

        function reset_pass(id,name){
            var url = "/admin/data-staff/:id/password".replace(':id', id);
            Swal.fire({
                width: 600,
                title: 'Lakukan reset password untuk user ' + name + '?',
                text: "Informasikan kepada staff agar mengganti passwordnya segera!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {id : id, name: name},
                        success: function(response) {
                            Swal.fire({
                                width: 600,
                                title: 'Berhasil!',
                                text: "Password untuk user dengan nama " + response.name + " berhasil direset! (password default : cerebrum)",
                                icon: 'success',
                            });
                        },
                        error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: errorThrown,
                            text: "Reset Password gagal!",
                            icon: 'error',
                            width: 600
                        });
                    }
                    });
                } else {
                    return false;
                }} 
            );
        }

        function toogle_status(id,name,status){
            var url = "/admin/data-staff/:id/status".replace(':id', id);
            if (status == 'Aktif') { var word = 'menonaktifkan'}
            else { var word = 'mengaktifkan'}
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Perubahan Status ',
                text: 'Anda yakin ingin ' + word + ' staff dengan nama '+ name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {id : id, name: name, status:status},
                        success: function(response) {
                            Swal.fire({
                                width: 600,
                                title: 'Berhasil!',
                                text: "User dengan nama " + response.name + " saat ini berstatus " + response.status,
                                icon: 'success',
                                timer: 2000
                            });
                            window.location.reload();
                        },
                        error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: errorThrown,
                            text: "Penggantian status gagal!",
                            icon: 'error',
                            width: 600
                        });
                    }
                    });
                } else {
                    return false;
                }} 
            );
        }

        function promote(id,name,employee_status){
            var url = "/admin/data-staff/promote/:id".replace(':id', id);
            if (employee_status == 'Probation') { var word = 'Kontrak'}
            else { var word = 'Tetap'}
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Promosi Staff',
                text: 'Anda yakin ingin mempromosikan staff "'+ name + '" dari status karyawan ' + employee_status + ' menjadi ' + word + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    window.location.href = url;
                } else {
                    return false;
                }} 
            );
        }

        function salary_increase(id,name){
            var url = "/admin/data-staff/promote/:id".replace(':id', id);
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Menaikan Gaji Staff',
                text: 'Anda yakin ingin menaikan gaji staff "'+ name + '" ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    window.location.href = url;
                } else {
                    return false;
                }} 
            );
        }
    </script>
@endsection