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
                            <td rowspan="11"></td>
                            <td rowspan="4" colspan="2" class="text-center">
                                <img id="img-modal" src="" alt="Tidak ada foto profil." style="width:128px;">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="phone_number">No Handphone: </label></td>
                            <td><span id="phone_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="gender">Jenis Kelamin: </label></td>
                            <td><span id="gender"></span></td>
                        </tr>
                        <tr>
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

            var join = `{{ asset('img/profile-photos/` + profile_photo + `')}}`;

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

</script>
@endsection
