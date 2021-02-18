<!-- modal -->
<div class="modal fade" id="modal-detail-ticket" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Detail Ticket</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr style="background-color: #2B323A; color: #FFFFFF">
                            <td><label for="id" class="text-bold">ID Ticket: </label></td>
                            <td><span id="id" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td><label for="category" class="text-bold">Kategori: </label></td>
                            <td><span id="category" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td><label for="status" class="text-bold">Status: </label></td>
                            <td><span id="status" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td><label for="name">Nama Pengirim: </label></td>
                            <td><span id="name"></span></td>   
                            
                        </tr>
                        <tr>
                            <td><label for="diajukan">Tanggal Pengajuan Ticket: </label></td>
                            <td><span id="diajukan"></span></td>
                        </tr>
                        <tr>
                            <td><label for="message">Pesan Ticket: </label></td>
                            <td colspan="4" rowspan="3"><textarea name="message" id="message" cols="100" rows="4" disabled></textarea></td>
                        </tr>
                        <tr></tr><tr></tr>
                        <tr>
                            <td><label for="response">Respon Ticket: </label></td>
                            <td colspan="4" rowspan="3"><textarea name="response" id="response" cols="100" rows="4" disabled></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href=""
                    class="btn btn-success add-tooltip" id="kirim-resp" data-toggle="tooltip"
                    data-container="body" data-placement="top" data-original-title="Kirim Respon Ticket" type="button">
                    Kirim Respon
                </a>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
    function toogle_selesai() {
        if (document.getElementById('lihat_selesai_radio-2').checked) {
            document.getElementById('master').style.display = 'none';
        } else {
            console.log('off');
        }
    };

    $(document).ready(function () {
        // modal
        $(document).on('click', '#detail_ticket', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var category = $(this).data('category');
            var message = $(this).data('message');
            var response = $(this).data('response');
            var status = $(this).data('status');
            var diajukan = $(this).data('diajukan');

            var join = `{{ url('/admin/ticketing/`+ id + `/edit')}}`;

            if (status == 'Selesai') {
                $("#kirim-resp").attr("href", '');
                $("#kirim-resp").text('Ticket telah selesai diproses');
                $("#kirim-resp").addClass('disabled');
            } else{
                $("#kirim-resp").attr("href", join);
                $("#kirim-resp").text('Kirim Respon');
                $("#kirim-resp").removeClass('disabled');
            }

            $('#id').text(id);
            $('#name').text(name);
            $('#category').text(category);
            $('#message').text(message);
            $('#response').text(response);
            $('#status').text(status);
            $('#diajukan').text(diajukan);
        });

        // check all
        $("#check-all").click(function () {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else
                $(".check-item").prop("checked", false);
        });

        //toogle selesai
        $('.lihat_selesai').click(function () {            
            if (this.checked) {
                $.ajax({
                    url: '/admin/ticketing/selesai',
                    type: 'GET',
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#masterdata-ticketing").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            } else {
                return false;
            }
        });
    });
    //lihat selesai
    
    // Sweetalert 2
    function submit_on_progress(){
        event.preventDefault();
        var check = document.querySelector('.check-item:checked');
        if (check != null){
            Swal.fire({
                title: 'Anda yakin ingin mengubah status ticket terpilih menjadi On Progress?',
                text: "Ticket yang sudah berstatus Selesai akan kembali berubah menjadi On Progress!",
                icon: 'warning',
                width: 600,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Tidak'
                }
            ).then((result) => {
                if (result.value == true) {
                    $("#form-mul-onprog").submit();
                }}
            );
        } else {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada data yang dipilih untuk diubah!",
                icon: 'error',
            })
        }
    }

    // live search
    function search_ticket() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-ticket");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-ticketing");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 2; j < 6; j++ ){
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