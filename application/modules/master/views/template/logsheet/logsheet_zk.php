<!-- CONTAINER -->
<div class="content-wrapper">
    <!-- Container Header -->
    <!-- <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Container Header -->

    <!-- Container Body -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Template LogSheet</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kiri -->
                                    <div class="col-6">
                                        <div class="form-group row col-12">
                                            <label class="card-title" style="text-align: center;">
                                                <u>LEMBAR KERJA PUPUK ZK</u>
                                            </label>
                                        </div>&nbsp;
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Contoh</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_contoh" name="log_contoh" placeholder="Contoh" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Catatan</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_catatan" name="log_catatan" placeholder="Catatan" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Nomor</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_nomor" name="log_nomor" placeholder="Nomor" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kiri -->
                                    <!-- Kanan -->
                                    <div class="col-6">
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">No. Dokumen</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_no_dokumen" name="log_no_dokumen" placeholder="No. Dokumen" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Terbitan/Revisi</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_terbitan_revisi" name="log_terbitan_revisi" placeholder="Terbitan/Revisi" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Tanggal Pengesahan</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right tanggal" id="log_transaksi_pengesahan" name="log_transaksi_pengesahan">
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">No.Lab</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_no_lab" name="log_no_lab" placeholder="No. Lab" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Tanggal Terima</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right tanggal" id="log_tanggal_terima" name="log_tanggal_terima">
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Tanggal Uji</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right tanggal" id="log_tanggal_uji" name="log_tanggal_uji">
                                            </div>
                                        </div>
                                        <div class="form-group row col-12">
                                            <label class="col-md-4">Analis</label>
                                            <div class="input-group col-md-8">
                                                <input type="text" class="form-control" id="log_analis" name="log_analis" placeholder="Analis" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kanan -->
                                </div>
                                <!-- Body -->
                            </div>
                            <!-- Rumus 1 -->
                            <div class="card-body">
                                <div class="row">
                                    <!-- <label class="col-md-4">K20 Total =</label> -->
                                    <h3 class="card-title"> K20 Total =
                                        <!-- <?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?> -->
                                    </h3>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_1" class="table table-bordered table-striped" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth</th>
                                                    <th>ppm</th>
                                                    <th>Faktor Pengenceran</th>
                                                    <th>Bst (K20/2K)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="1" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 1 -->
                                <hr>
                                <!-- Rumus 2 -->
                                <div class="row">
                                    <label class="col-md-4">Sulfur =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_2" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (g)</th>
                                                    <th>Wo (g)</th>
                                                    <th>W1 (g)</th>
                                                    <th>W2 (g) </th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="2" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 2 -->
                                <hr>
                                <!-- Rumus 3 -->
                                <div class="row">
                                    <label class="col-md-4">Klorida as Cl- =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_3" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>(mg)</th>
                                                    <th>(ml)</th>
                                                    <th>0.1 N AgNO3</th>
                                                    <th>Cl</th>
                                                    <th>(%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="3" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 3 -->
                                <!-- Rumus Normalitas 3  -->
                                <div class="row">
                                    <label class="col-md-4">Normalitas AgNO3 =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_4" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NaCl</th>
                                                    <th>Vol.Titran</th>
                                                    <th>N AgNO3</th>
                                                    <th>Rata-Rata</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="4" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus Normalitas 3 -->
                                <hr>
                                <!-- Rumus 4 -->
                                <div class="row">
                                    <label class="col-md-4">Asam Bebas =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_5" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (mg)</th>
                                                    <th>Vol. Titran (ml)</th>
                                                    <th>N - NaOH 0.1 N NaOH</th>
                                                    <th>Bst H2SO4</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="5" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 4 -->
                                <!-- Rumus Normalitas 4 -->
                                <div class="row">
                                    <label class="col-md-4">Normalitas NaOH =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_6" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>C8H5KO4</th>
                                                    <th>Vol.Titran</th>
                                                    <th>N NaOH</th>
                                                    <th>Rata-Rata</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="6" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus Normalitas 3 -->
                                <hr>
                                <!-- Rumus 5 -->
                                <div class="row">
                                    <label class="col-md-4">H2O =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_7" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (g)</th>
                                                    <th>Wo (g)</th>
                                                    <th>W1 (g)</th>
                                                    <th>W2 (g)</th>
                                                    <th>W3 (g)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="7" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="7" style="display: none;">
                                                        <input type="text" class="form-control" id="param_7" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- </form> -->
                                    </div>
                                </div>
                                <!-- Rumus 5 -->
                                <hr>
                                <!-- Rumus 6 -->
                                <div class="row">
                                    <label class="col-md-4">NaCl =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_8" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (g)</th>
                                                    <th>ppm cth</th>
                                                    <th>Faktor Pengenceran</th>
                                                    <th>Bst (Na2O/Na)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="8" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- </form> -->
                                    </div>
                                </div>
                                <!-- Rumus 6 -->
                                <hr>
                                <!-- Rumus 7 -->
                                <div class="row">
                                    <label class="col-md-4">MgO =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_9" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (mg)</th>
                                                    <th>ppm cth</th>
                                                    <th>Faktor Pengenceran</th>
                                                    <th>Bst (MgO/Mg)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="9" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 7 -->
                                <hr>
                                <!-- Rumus 8 -->
                                <div class="row">
                                    <label class="col-md-4">CaO =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_10" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (mg)</th>
                                                    <th>ppm cth</th>
                                                    <th>Faktor Pengenceran</th>
                                                    <th>Bst (CaO/Ca)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="10" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 8 -->
                                <hr>
                                <!-- Rumus 9 -->
                                <div class="row">
                                    <label class="col-md-4">Fe203 =</label>
                                    <div class=" form-group col-12 row">
                                        <table id="table_logsheet_11" class="table table-bordered table-striped" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Berat Cth (mg)</th>
                                                    <th>ppm cth</th>
                                                    <th>Faktor Pengenceran</th>
                                                    <th>Bst (Fe203/Fe)</th>
                                                    <th>Hasil (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody" id="tbody">
                                                <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="11" style="display: none;">
                                                <input type="text" id="logsheeet_template_id" name="logsheet_template_id[0]" value="<?= create_id() ?>" class="logsheet_template_id" style="display: none;">
                                                <tr class="tr" id="tr">
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="1" style="display: none;">
                                                        <input type="text" class="form-control" id="param_1" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="2" style="display: none;">
                                                        <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="3" style="display: none;">
                                                        <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="4" style="display: none;">
                                                        <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="5" style="display: none;">
                                                        <input type="text" class="form-control" id="param_5" name="param_isi[0][]">
                                                    </td>
                                                    <td class="td">
                                                        <input type="text" id="param_urut_1" name="param_urut[0][]" value="6" style="display: none;">
                                                        <input type="text" class="form-control" id="param_6" name="param_isi[0][]">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Rumus 8 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Container Body -->

</div>