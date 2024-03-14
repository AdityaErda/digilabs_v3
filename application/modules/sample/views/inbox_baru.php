<!--CONTAINER -->
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
                <div class="col-md-12">
                    <!-- <div class="modal-content"> -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><?= $judul ?></h3>
                        </div>
                        <!-- Body -->
                        <form id="form_modal">
                            <div class="card-body row">
                                <!-- Modal -->
                                <input type="text" id="transaksi_id" name="transaksi_id" value="" style="display: none;">
                                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;">
                                <div class="modal-body">
                                    <div class="card-body row">
                                        <!-- Kiri -->
                                        <div class="col-6">
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Peminta Jasa</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="peminta_jasa_nama" name="peminta_jasa_nama" value="" placeholder="Peminta Jasa" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Jenis Sample</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="jenis_nama" name="jenis_nama" value="" placeholder="Jenis Sample" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Jenis Pekerjaan</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="sample_pekerjaan_nama" name="sample_pekerjaan_nama" value="" placeholder="Jenis Pekerjaan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">PIC Pengirim Sample</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="transaksi_detail_pic_pengirim" name="transaksi_detail_pic_pengirim" value="" placeholder="PIC Pengirim Sample" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Ext Pengirim Sample</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Jumlah Sample</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah" value="" placeholder="Jumlah Sample" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Identitas</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="identitas_nama" name="identitas_nama" value="" placeholder="Identitas" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Keterangan</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="transaksi_detail_keterangan" name="transaksi_detail_keterangan" value="" placeholder="Identitas" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Kiri -->
                                        <!-- Kanan -->
                                        <div class="col-6">
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Parameter*</label>
                                                <div class="input-group col-md-8">
                                                    <input type="number" class="form-control" id="transaksi_detail_parameter" name="transaksi_detail_parameter" value="" placeholder="Parameter" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Tanggal Pengajuan</label>
                                                <div class="input-group col-md-8">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right" id="transaksi_detail_tgl_pengajuan" name="transaksi_detail_tgl_pengajuan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Estimasi*</label>
                                                <div class="input-group col-md-8">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_estimasi" name="transaksi_detail_tgl_estimasi" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Note</label>
                                                <div class="input-group col-md-8">
                                                    <input type="text" class="form-control" id="transaksi_detail_note" name="transaksi_detail_note" value="" placeholder="Note" maxlength="25">
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-12" id="div_file" style="display: none;">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="35%"><label>Upload FIle</label></td>
                                                        <td width="65%"><input type="file" class="form-control" id="transaksi_detail_file" name="transaksi_detail_file" value="" placeholder=""></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="form-group row col-md-12" id="div_surat" style="display: none;">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="35%"><label>Nomor Surat</label></td>
                                                        <td width="65%"><input type="number" class="form-control" name="transaksi_detail_no_surat" id="transaksi_detail_no_surat" placeholder="Nomor Surat"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="form-group row col-md-12">
                                                <label class="col-md-4">Foto Sample</label>
                                                <table width="100%">
                                                    <tr>
                                                        <!-- <td width="35%"><label>Foto Sample</label></td> -->
                                                        <td width="55%"><img src="" alt="" style="width: 200px" id="transaksi_detail_foto"></td>
                                                        <td width="10%"><a href="" target="_BLANK" id="unduh">Unduh</a></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Kanan -->
                                        <div class="modal-footer justify-content-between">
                                            <!-- <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button> -->
                                            <button type="submit" class="btn btn-danger" id="belum_diterima" style="display:none;">Sample Belum Diterima</button>
                                            <button type="submit" class="btn btn-success" id="diterima" style="display:none;">Sample Diterima</button>
                                            <button type="submit" class="btn btn-danger" id="tunda" style="display: none">Tunda</button>
                                            <button type="submit" class="btn btn-primary" id="progress" style="display: none">On Progress</button>
                                            <button type="submit" class="btn btn-warning" id="terbit_sertifikat" style="display: none">Terbit Sertifikat</button>
                                            <button type="submit" class="btn btn-warning" id="clossed" style="display: none">Clossed</button>
                                            <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                            </div>
                        </form>
                        <!-- Body -->
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Container Body -->
</div>
<!--CONTAINER -->