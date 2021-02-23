<!-- modal detail ticket-->
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
                            <td colspan="4" rowspan="3"><textarea name="message" id="message" rows="2"
                                    disabled></textarea></td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td><label for="response">Respon Ticket: </label></td>
                            <td colspan="4" rowspan="3"><textarea name="response" id="response" rows="2"
                                    disabled></textarea></td>
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
<!-- modal input ticket -->
<div class="modal fade" id="modal-input-ticket" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Input Ticket Baru</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="/staff/ticketing/input" method="POST">
                    @csrf
                    <div class="panel-body">
                        <input type="hidden" name="user_id" value="{{$id}}">
                        <input type="hidden" name="status" value="Diajukan">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">Kategori:</label>
                                <div class="col-sm-4">
                                    <select class="selectpicker" data-style="btn-mint" name="category">
                                        <option value="Keluhan">Keluhan</option>
                                        <option value="Masukan">Masukan</option>
                                        <option value="Bug Aplikasi">Bug Aplikasi</option>
                                        <option value="Kesalahan Informasi">Kesalahan Informasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label" for="textarea-edit-message">Pesan:</label>
                                <div class="col-sm-10">
                                    <textarea id="textarea-edit-message" rows="2" class="form-control"
                                        placeholder="Masukan keterangan tambahan anda disini" name="message"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success add-tooltip" type="submit" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Kirim Ticket">Kirim Ticket</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<!--Bootstrap Select [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
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

            var join = `{{ url('/admin/ticketing/` + id + `/edit')}}`;

            $('#id').text(id);
            $('#name').text(name);
            $('#category').text(category);
            $('#message').text(message);
            $('#response').text(response);
            $('#status').text(status);
            $('#diajukan').text(diajukan);
        });
    });

</script>
@endsection
