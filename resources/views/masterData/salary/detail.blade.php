<!-- modal -->
<div class="modal fade" id="modal-salary-staff" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Detail Staff</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr style="background-color: #2B323A; color: #FFFFFF; font-weight: bold; margin-bottom: 10px"><td colspan="4">Identitas</td></tr>
                        <tr>
                            <td><label for="nip" class="text-bold">NIP: </label></td>
                            <td><span id="nip"></span></td>
                            <td><label for="name" class="text-bold">Nama Lengkap: </label></td>
                            <td><span id="name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="division_name" class="text-bold">Divisi: </label></td>
                            <td><span id="division_name"></span></td>
                            <td><label for="position_name" class="text-bold">Jabatan: </label></td>
                            <td><span id="position_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="periode" class="text-bold">Periode: </label></td>
                            <td colspan="3"><span id="periode_salary"></span></td>
                        </tr>
                        <tr style="background-color: #2B323A; color: #FFFFFF; font-weight: bold; margin-bottom: 10px"><td colspan="4">Keterangan Waktu</td></tr>
                        <tr>
                            <td><label for="total_hour" class="text-bold">Total Jam Kerja Seharusnya: </label></td>
                            <td><span id="total_hour"></span></td>
                            <td><label for="work_hour" class="text-bold">Total Jam Kerja: </label></td>
                            <td><span id="work_hour"></span></td>
                        </tr>
                        <tr>
                            <td><label for="late" class="text-bold">Total Jam Keterlambatan: </label></td>
                            <td><span id="late"></span></td>
                            <td><label for="late" class="text-bold">Total Absen: </label></td>
                            <td><span id="absen"></span></td>
                        </tr>
                        <tr>
                            <td><label for="sick" class="text-bold">Total Sakit: </label></td>
                            <td><span id="sick"></span></td>
                            <td><label for="paid_leave" class="text-bold">Total Cuti: </label></td>
                            <td><span id="paid_leave"></span></td>
                        </tr>
                        <tr style="background-color: #2B323A; color: #FFFFFF; font-weight: bold; margin-bottom: 10px"><td colspan="4">Keterangan Gaji</td></tr>
                        <tr>
                            <td><label for="salary" class="text-bold">Gaji Pokok: </label></td>
                            <td><span id="salary"></span></td>
                            <td><label for="fine" class="text-bold">Denda Keterlambatan: </label></td>
                            <td><span id="fine"></span></td>
                        </tr>
                        <tr>
                            <td><label for="allowance" class="text-bold">Total Tunjangan: </label></td>
                            <td><span id="allowance"></span></td>
                            <td><label for="cut" class="text-bold">Total Potongan: </label></td>
                            <td><span id="cut"></span></td>
                        </tr>
                        <tr style="background-color: #2B323A; color: #FFFFFF; margin-bottom: 10px">
                            <td><label for="total_salary" class="text-bold">Total Gaji Yang Didapatkan: </label></td>
                            <td colspan="3"><span id="total_salary" class="text-bold"></span></td>
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

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#detail_salary_staff', function () {
            var nip = $(this).data('nip');
            var name = $(this).data('name');
            var division_name = $(this).data('division_name');
            var position_name = $(this).data('position_name');
            var periode = $(this).data('periode');
            var total_hour = $(this).data('total_hour');
            var work_hour = $(this).data('work_hour');
            var late = $(this).data('late');
            var absen = $(this).data('absen');
            var sick = $(this).data('sick');
            var paid_leave = $(this).data('paid_leave');
            var salary = $(this).data('salary');
            var fine = $(this).data('fine');
            var allowance = $(this).data('allowance');
            var cut = $(this).data('cut');
            var total_salary = $(this).data('total_salary');

            //show data to html
            $('#nip').text(nip);
            $('#name').text(name);
            $('#division_name').text(division_name);
            $('#position_name').text(position_name);
            $('#periode_salary').text(periode);
            $('#total_hour').text(total_hour);
            $('#work_hour').text(work_hour);
            $('#late').text(late);
            $('#absen').text(absen);
            $('#sick').text(sick);
            $('#paid_leave').text(paid_leave);
            $('#salary').text(salary);
            $('#fine').text(fine);
            $('#allowance').text(allowance);
            $('#cut').text(cut);
            $('#total_salary').text(total_salary);
        });
    });

    function submit_add(){
        event.preventDefault();
        var check_user = document.querySelector('.sub_chk:checked');
        if (check_user != null){
                $('#slip').submit();
        }
        else {
            Swal.fire({
                    title: 'Sepertinya ada kesalahan...',
                    text: "Mohon pilih data gaji terlebih dahulu...",
                    icon: 'error',
            });
            return false;
        }
    }
</script>