<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }

  .custom_raw_eksekutor {
    font-family: Arial;
  }
</style>

<?php
$session = $this->session->userdata();
$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();
?>

<!--CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div>
  </section>
  <!-- Container Header -->
  <!-- Container Body -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <form id="form_logsheet">
            <div class="card">
              <input type="text" id="is_new" name="is_new" style="display:none">
              <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
              <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
              <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
              <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
              <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
              <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
              <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="<?= create_id(); ?>" style="display: none;">
              <input type="text" id="transaksi_drafter_detault" name="transaksi_drafter_default" value="<?= $inbox['transaksi_drafter'] ?>" style="display:none">
              <textarea name="custom_raw_eksekutor" class="custom_raw_eksekutor" id="custom_raw_eksekutor">
                    <div style="width: 100%; text-align: center; font-size: 14pt; margin-bottom: 20px;">LEMBAR KERJA <?= strtoupper($logsheet['logsheet_jenis_nama']) ?></div>
                    <div style="width: 30%; float: right; border-collapse:collapse; border:1px solid black; font-size: 9pt;">
                      <div style="display: flex;">
                        <div style="width: 60%;">No Dokumen</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 35%;">FM-39-4210</div>
                      </div>
                      <div style="display: flex;">
                        <div style="width: 60%;">Terbitan / Revisi</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 35%;"></div>
                      </div>
                      <div style="display: flex;">
                        <div style="width: 60%;">Tanggal Pengesahan</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 35%;"><?= ($logsheet['logsheet_review_date'] != '') ? date_indo(date(($logsheet['logsheet_review_date']))) : '-' ?></div>
                      </div>
                      <div style="display: flex;">
                        <div style="width: 60%;">Lembar</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 35%;"></div>
                      </div>
                    </div>
                    <div style="width: 100%; margin-top: 200px; font-size: 11pt;">
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Contoh</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $logsheet['logsheet_jenis_nama'] ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Tanda</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $logsheet['logsheet_nomor_permintaan'] ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Catatan</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $logsheet['logsheet_deskripsi'] ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Sertifikat</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $inbox_detail[0]['transaksi_detail_nomor'] ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Area</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $inbox_detail[0]['transaksi_detail_nomor'] ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">No. Lab</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></div>
                      </div>
                      <?php if ($inbox_detail[0]['is_sampling'] == 'y') : ?>
                        <div style="display: flex; margin: 10px;">
                          <div style="width: 35%;">Tanggal Sampling</div>
                          <div style="width: 5%;">:</div>
                          <div style="width: 60%;"><?= date_indo(($logsheet['logsheet_tgl_sampling'])) ?></div>
                        </div>
                      <?php endif ?>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Tanggal Terima</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= date_indo(($logsheet['logsheet_tgl_terima'])) ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Tanggal Pengujian</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= date_indo(($logsheet['logsheet_tgl_uji'])) ?></div>
                      </div>
                      <div style="display: flex; margin: 10px;">
                        <div style="width: 35%;">Analisis</div>
                        <div style="width: 5%;">:</div>
                        <div style="width: 60%;"><?= ($logsheet['nama_analisis'] != '') ? $logsheet['nama_analisis'] : $session['user_nama'] ?></div>
                      </div>
                    </div>
                    <?php foreach ($detail_logsheet as $value) : ?>
                      <?php
                      $dataDetailRumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_urut ASC")->result_array();

                      $dataHeader = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail where rumus_detail_template IS NOT NULL AND id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_template ASC")->result_array();

                      $dataBody = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus LEFT JOIN sample.sample_template_logsheet_detail d ON b.id_rumus = d.logsheet_nama_rumus AND a.id_template_logsheet = d.id_logsheet_template WHERE id_transaksi = '" . $this->input->get('transaksi_id') . "' AND a.logsheet_id = '" . $this->input->get('logsheet_id') . "' AND b.id_rumus = '" . $value['rumus_id'] . "' ORDER BY d.detail_logsheet_urut ASC")->result_array();

                      $dataLogsheetDetailGroup = $this->db->query("SELECT DISTINCT rumus_metoda,rumus_avg,rumus_satuan ,rumus_adbk FROM sample.sample_logsheet_detail WHERE logsheet_id = '" . $this->input->get_post('logsheet_id')  . "' AND id_rumus = '" . $value['rumus_id'] . "'")->row_array();

                      $dataFooter = $this->db->query("SELECT DISTINCT id_rumus, rumus_avg, rumus_adbk FROM sample.sample_logsheet_detail WHERE id_rumus = '" . $value['rumus_id'] . "' AND logsheet_id='" . $_GET['logsheet_id'] . "' AND rumus_avg IS NOT NULL AND rumus_adbk IS NOT NULL")->result_array();
                      ?>
                      <div style="width: 100%; margin-top: 30px;">
                        <div style="font-size: 14pt; margin-bottom: 5px;">
                          <?= $value['rumus_nama'] ?> =
                          <?php foreach ($dataDetailRumus as $v_detail_rumus) : ?>
                            <?= ($v_detail_rumus['rumus_detail_nama'] != null) ? $v_detail_rumus['rumus_detail_nama'] : $v_detail_rumus['rumus_detail_input']; ?>
                          <?php endforeach ?>
                        </div>
                        <div style="display: flex; margin: 10px;">
                          <div style="width: 35%;">Metoda</div>
                          <div style="width: 5%;">:</div>
                          <div style="width: 60%;"><?= $dataLogsheetDetailGroup['rumus_metoda'] ?></div>
                        </div>
                        <div style="display: flex; margin: 10px;">
                          <div style="width: 35%;">Satuan</div>
                          <div style="width: 5%;">:</div>
                          <div style="width: 60%;"><?= $dataLogsheetDetailGroup['rumus_satuan'] ?></div>
                        </div>
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 11pt;">
                          <thead>
                            <tr>
                              <?php $jml_kolom[$value['rumus_id']] = (count($dataHeader) + 2) ?>
                              <?php foreach ($dataHeader as $v_header) : ?>
                                <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $v_header['rumus_detail_nama'] ?></td>
                              <?php endforeach ?>
                              <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;">Hasil</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($dataBody as $v_body) : ?>
                              <tr>
                                <?php $dataDetail = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet_detail='" . $v_body['logsheet_detail_id'] . "' ORDER BY rumus_detail_template ASC")->result_array(); ?>
                                <?php foreach ($dataDetail as $v_detail) : ?>
                                  <td style="border-collapse: collapse; border: 1px solid black;"><?= $v_detail['rumus_detail_isi'] ?></td>
                                <?php endforeach ?>
                                <td style="border-collapse: collapse; border: 1px solid black;"><?= $v_body['rumus_hasil'] ?></td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                          <tfoot>
                              <?php
                              $jumlahDetail = count($dataDetail);
                              ?>
                              <tr>
                                  <?php if ($dataLogsheetDetailGroup['rumus_avg'] != '' && $dataLogsheetDetailGroup['rumus_avg'] != '0') : ?>
                                    <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold; text-align: center;" colspan="<?= $jumlahDetail ?>">Rata-rata</td>
                                    <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $dataLogsheetDetailGroup['rumus_avg'] ?></td>
                                  <?php endif ?>
                              </tr>
                              <tr>
                                  <?php if ($dataLogsheetDetailGroup['rumus_adbk'] != '') : ?>
                                    <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold; text-align: center;" colspan="<?= $jumlahDetail ?>">ADBK</td>
                                    <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $dataLogsheetDetailGroup['rumus_adbk'] ?></td>
                                  <?php endif ?>
                              </tr>
                            </tfoot>
                        </table>
                      </div>
                    <?php endforeach ?>
                    <div style="width: 30%; float: right; border-collapse:collapse; border:1px solid black; font-size: 11pt; margin-top: 20px;">
                      <div style="display: flex;">
                        <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Analisis</div>
                        <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Reviewer</div>
                      </div>
                      <div style="display: flex;">
                        <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                          <?php if ($logsheet['logsheet_analisis'] != '') : ?>
                            <img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                          <?php endif; ?>
                        </div>
                        <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                          <?php if ($logsheet['logsheet_review'] != '') : ?>
                            <img src="<?= base_url('img/' . $logsheet['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </textarea>
              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="btn btn-default border-dark">Kembali</button>
                  <button type="button" id="cetak" class="btn btn-primary">Cetak Preview</button>
                  <button type="button" id="reupload" class="col-2 btn btn-info">Upload Ulang</button>
                  <button type="button" id="simpan_modal" class="btn btn-success float-right">Selanjutnya</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->
<!-- Modal Template -->
<div id="modal_template" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Template</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="form_template">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">KAN</label>
                <div class="input-group col-md-8">
                  <input type="checkbox" name="is_kan" id="is_kan" class="form-control-checkbox" value="y">
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">DS</label>
                <div class="input-group col-md-8">
                  <input type="checkbox" name="is_ds" id="is_ds" class="form-control-checkbox" value="y">
                </div>
              </div>
            </div>
            <div class="col-12" style="display: none;">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Bilingual</label>
                <div class="input-group col-md-8">
                  <select name="bahasa" id="bahasa" class="select2 form-control" onchange="func_ganti_bahasa(this.value)">
                    <option value="">-Pilih-</option>
                    <option value="I">Indonesia</option>
                    <option value="E">Inggris</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Template Footer</label>
                <div class="input-group col-md-8">
                  <select name="id_template_footer[]" id="id_template_footer" class="form-control select2" style="width:100%" multiple>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Keterangan</label>
                <div class="input-group col-md-8">
                  <select name="logsheet_keterangan[]" id="logsheet_keterangan" class="form-control select2" style="width:100%" multiple>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Template -->