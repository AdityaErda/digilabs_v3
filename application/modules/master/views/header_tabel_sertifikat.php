<!-- CONTAINER -->
<div class="content-wrapper">
    <!-- Container Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Header Tabel Sertifikat</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- Container Header -->

    <!-- Container Body -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- DIV DATA DIRI -->
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header bg-warning">
                                <h3 class="card-title"><?= $judul ?></h3>
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal">Tambah</button>
                                <label class="float-right">&nbsp;</label>
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Table -->
                                <table id="table_header" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Header Tabel</th>
                                            <th>Updated</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Table -->
                                <!-- Modal -->
                                <div class="modal fade" id="modal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $judul ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="form_modal_header">
                                                <input type="text" id="template_sertifikat_header_id" name="template_sertifikat_header_id" value="" style="display: none;">
                                                <div class="modal-body">
                                                    <div class="card-body row">
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Nama Header Tabel</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" class="form-control" id="template_sertifikat_header_nama" name="template_sertifikat_header_nama" placeholder="Nama Header Tabel" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                                                    <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                                                    <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Modal -->
                            </div>
                            <!-- Body -->
                        </div>
                    </div>
                </div>
                <!-- DIV DATA DIRI -->
            </div>
        </div>
    </section>
    <!-- Container Body -->

</div>
<!-- CONTAINER -->