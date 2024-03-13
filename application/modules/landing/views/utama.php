<style type="text/css">
    iframe {
        width: 500px !important;
        height: 300px !important;
    }
</style>

<style type="text/css">
  .dataTables_scrollHead {
    overflow: auto !important;
  }
</style>

<!-- CONTAINER -->
<div class="content-wrapper">
    <!-- Container Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h1><?= $judul ?></h1>
                </div>
                <a href="<?= base_url('landing/indexPreview') ?>" target="_blank" class="btn btn-danger col-2">Preview</a>
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
                                <button type="button" class="btn btn-primary col-1 float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>
                                <label class="float-right">&nbsp;</label>
                                <!-- <a href="<?= base_url('landing/preview') ?>" class="btn btn-danger col-1 float-right" target="_blank">Preview</a> -->
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Table -->
                                <table id="table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Urutan</th>
                                            <th>Judul</th>
                                            <th>Link</th>
                                            <th>Template</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Table -->
                                <div class="modal fade" id="modal">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $judul ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="form_modal">
                                                <input hidden type="text" id="landing_id" name="landing_id">
                                                <!-- <input type="text" hidden id="id_landing_temp" name="id_landing_temp"> -->
                                                <div class="modal-body">
                                                    <div class="card-body row">
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Urutan</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="number" name="landing_urutan" id="landing_urutan" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Judul</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_judul" id="landing_judul" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Link</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_link" id="landing_link" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Template</label>
                                                                <div class="input-group col-md-8">
                                                                    <select name="id_landing_template" id="id_landing_template" class="form-control" onchange="ganti_tipe(this.value)"></select>
                                                                    <input hidden type="text" name="landing_tipe" id="landing_tipe" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Aktif</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="checkbox" name="landing_aktif" id="landing_aktif" value="y">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                                                    <button type="button" class="btn btn-warning" id="preview" name="preview" onclick="func_preview()" style="display:none">Preview</button>
                                                    <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                                                    <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                            <!-- Body -->
                        </div>
                    </div>
                </div>
                <!-- DIV DATA DIRI -->
                <!-- DIV BANNER -->
                <div class="col-md-12" id="div_detail" style="display: none;">
                    <input hidden type="text" id="id_landing" name="id_landing">
                    <input hidden type="text" id="landing_template_tipe" name="landing_template_tipe">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header bg-success">
                                <h3 class="card-title">Detail <span id="judul_detail"></span></h3>
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Table -->
                                <div id="div_table_detail_banner" style="display:none;">
                                    <table id="table_detail_banner" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Urutan</th>
                                                <th>Judul</th>
                                                <th>Gambar</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="div_table_detail_tentang" style="display:none;">
                                    <table id="table_detail_tentang" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Isi</th>
                                                <th>Gambar</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="div_table_detail_berita" style="display:none;">
                                    <table id="table_detail_berita" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Isi</th>
                                                <th>Gambar</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="div_table_detail_sertifikat" style="display:none;">
                                    <table id="table_detail_sertifikat" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>Gambar</th>
                                                <th>Ruang Lingkup</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="div_table_detail_kerjasama" style="display:none;">
                                    <table id="table_detail_kerjasama" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor</th>
                                                <th>Judul</th>
                                                <th>Gambar</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="div_table_detail_kontak" style="display:none;">
                                    <table id="table_detail_kontak" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Alamat</th>
                                                <th>Kontak</th>
                                                <th>Fax</th>
                                                <th>Email</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- Table -->
                                <!-- Modal -->
                                <div class="modal fade" id="modal_detail">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $judul ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="form_modal_detail">
                                                <input hidden type="text" id="landing_detail_id" name="landing_detail_id">
                                                <input hidden type="text" id="id_landing_temp" name="id_landing_temp">
                                                <div class="modal-body">
                                                    <div class="card-body row">
                                                        <div class="col-12">
                                                            <div class="form-group row col-md-12" id="div_landing_detail_urutan" style="display:none">
                                                                <label class="col-md-4">Urutan</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="number" name="landing_detail_urutan" id="landing_detail_urutan" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_nomor" style="display:none">
                                                                <label class="col-md-4">Nomor</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_nomor" id="landing_detail_nomor" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_judul" style="display:none">
                                                                <label class="col-md-4">Judul</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_judul" id="landing_detail_judul" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_alamat" style="display:none">
                                                                <label class="col-md-4">Alamat</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_alamat" id="landing_detail_alamat" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_kontak" style="display:none">
                                                                <label class="col-md-4">Kontak</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_kontak" id="landing_detail_kontak" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_fax" style="display:none">
                                                                <label class="col-md-4">Fax</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_fax" id="landing_detail_fax" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_email" style="display:none">
                                                                <label class="col-md-4">E-Mail</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="email" name="landing_detail_email" id="landing_detail_email" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_text" style="display:none">
                                                                <label class="col-md-4">Isi</label>
                                                                <div class="input-group col-md-8">
                                                                    <textarea id="landing_detail_text" name="landing_detail_text"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row col-md-12" id="div_landing_detail_gambar" style="display:none">
                                                                <label class="col-md-4">Gambar</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_gambar_temp" id="landing_detail_gambar_temp" hidden>
                                                                    <div id="landing_detail_image_preview"></div>
                                                                    <input type="file" name="landing_detail_gambar" id="landing_detail_gambar" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_landing_detail_file" style="display:none">
                                                                <label class="col-md-4">Ruang Lingkup</label>
                                                                <div class="input-group col-md-8">
                                                                    <input type="text" name="landing_detail_file_temp" id="landing_detail_file_temp" hidden>
                                                                    <div id="landing_detail_file_preview"></div>
                                                                    <input type="file" name="landing_detail_file" id="landing_detail_file" class="form-control">
                                                                </div>
                                                            </div>
                                                            <!-- <div class="form-group row col-md-12" id="div_landing_detail_status" style="display:none">
                                                                <label class="col-md-4">Status</label>
                                                                <div class="input-group col-md-8">
                                                                    <?php
                                                                    $options = array(
                                                                        null => 'Pilih',
                                                                        'y' => 'Preview',
                                                                        'p' => 'Publish'
                                                                    );

                                                                    echo form_dropdown('landing_detail_status', $options, $this->input->get('landing_detail_status'), 'id="landing_detail_status" class="form-control"');
                                                                    ?>
                                                                </div>
                                                            </div> -->
                                                            <div class="form-group row col-md-12" id="div_image_home" style="display:none">
                                                                <!-- <label class="col-md-12">
                                                                    <span><strong>NB: <br />1. Untuk ukuran gambar yang di upload Max Size: 2mb, Lebar: 1100px dan Tinggi: 690px</strong> <span>
                                                                </label> -->
                                                                <i class="text-danger">NB: <br />1. Untuk ukuran gambar yang di upload Max Size: 2mb, Lebar: 1100px dan Tinggi: 690px</i>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_image_tentang_kami" style="display:none">
                                                                <i class="text-danger">NB: <br />1. Untuk Ukuran gambar yang di upload Max Size: 2mb, Lebar: 350px dan Tinggi: 550px</i>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_image_berita_terkini" style="display:none">
                                                                <i class="text-danger">NB: <br />1. Untuk ukuran gambar yang di upload Max Size: 2mb, Lebar: 300px dan Tinggi: 200px</i>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_image_sertifikat" style="display:none">
                                                                <i class="text-danger">NB: <br />1. Untuk ukuran gambar yang di upload Max Size: 2mb, Lebar: 522px dan Tinggi: 402px</i>
                                                            </div>
                                                            <div class="form-group row col-md-12" id="div_image_testimoni" style="display:none">
                                                                <i class="text-danger">NB: <br />1. Untuk ukuran gambar yang di upload Max Size: 2mb, Lebar: 300px dan Tinggi: 200px</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="fun_close_detail()">Close</button>
                                                    <!-- <button type="button" class="btn btn-warning" id="preview" data-toggle="modal" data-target="#modal_preview" onclick="fun_preview()">Preview</button> -->
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
                                <div class="modal fade" id="modal_lihat">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $judul ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="form_modal">
                                                <!-- <input type="hidden" id="jadwal_id" name="jadwal_id" value=""> -->
                                                <div class="modal-body">
                                                    <div class="card-body row" id="div_document" style="height: 600px;">

                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                            <!-- Body -->
                        </div>
                    </div>
                </div>
                <!-- DIV BANNER -->

            </div>
        </div>
    </section>
    <!-- Container Body -->
</div>
<!-- CONTAINER -->