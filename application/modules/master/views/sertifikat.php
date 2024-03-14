<!-- CONTAINER -->
<div class="content-wrapper">
    <!-- Container Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
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
                                <table id="table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Sample</th>
                                            <th>Nama Log Sheet</th>
                                            <th>Updated</th>
                                            <th>Action</th>
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
                                            <form id="form_modal">
                                                <input type="text" id="sertifikat_id" name="sertifikat_id" value="" style="display: none;">
                                                <div class="modal-body">
                                                    <div class="card-body row">
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Nama Sample</label>
                                                                <div class="input-group col-md-8">
                                                                    <select class="form-control select2" id="sertifikat_nama" name="sertifikat_nama" value="" required=""></select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Nama Log Sheet</label>
                                                                <div class="input-group col-md-8">
                                                                    <select class="form-control select2" id="id_template_logsheet" name="id_template_logsheet" value="" required=""></select>
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

                <!-- Div Detail Sertifikat-->
                <div class="col-md-12" id="div_detail" style="display: none;">
                    <input type="hidden" id="id_sertifikat_detail" name="id_sertifikat_detail">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header bg-success">
                                <h3 class="card-title">DetaiL Template Sertifikat</h3>
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Table -->
                                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Urutan</th>
                                            <th>Header Tabel Sertifikat</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Table -->
                                <!-- Modal -->
                                <div class="modal fade" id="modal_detail">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $judul ?></h4>
                                            </div>
                                            <form id="form_modal_detail">
                                                <input type="text" id="temp_sertifikat_id" name="temp_sertifikat_id" style="display: none;">
                                                <input type="text" id="sertifikat_template_detail_id" name="sertifikat_template_detail_id" value="" style="display: none;">
                                                <div class="modal-body">
                                                    <div class="card-body row">
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Urutan</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="number" name="sertifikat_template_detail_urut" id="sertifikat_template_detail_urut" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Header Tabel Sertifikat</label>
                                                                <div class="input-group col-md-8">
                                                                    <select class="form-control select2" id="id_template_sertifikat_header" name="id_template_sertifikat_header" value="" required=""></select>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="fun_close_detail()">Close</button>
                                                    <button type="submit" class="btn btn-success" id="simpan_detail">Simpan</button>
                                                    <button type="submit" class="btn btn-primary" id="edit_detail" style="display: none">Edit</button>
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

                        <!-- <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Template Sertifikat</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>&nbsp;
                            <div class="card-body">
                                <h2 class="text-center fw-bolder"><u>SERTIFIKAT PENGUJIAN</u></h2>
                                <h6 class="text-center">Nomor : </h6>
                                &nbsp;
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-2 col-sm-2 col-xs-2" style="margin-left: -20px;">
                                        <table width="100%" border="0" cellpadding="7">
                                            <tr>
                                                <td>Nomor Laboratorium</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Bahan</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Rupa/Warna</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Peminta Jasa</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Terima</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Pengujian</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Asal Contoh</td>
                                                <td>: </td>
                                            </tr>
                                            <tr>
                                                <td>Pengambilan Contoh</td>
                                                <td>: </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>&nbsp;
                                <h5 class="text-center fw-bolder">Hasil Pengujian</h5>

                                <div class="card-body" id="div_sertifikat"></div>

                            </div>
                        </div> -->

                    </div>
                    <!-- Div Detail Sertifikat -->
                </div>
            </div>
    </section>
    <!-- Container Body -->
</div>
<!-- CONTAINER -->