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
              <?php
              $nomor_sample = '';
              $jenis_nama = '';
              foreach ($inbox_detail as $key_header => $detail_header) :
                $nomor_sample .= $detail_header['transaksi_detail_nomor_sample'] . ', ';
                $jenis_nama .= $detail_header['jenis_nama'] . ', ';

                $logsheet = $this->db->get_where('sample.sample_logsheet', array('logsheet_multiple_id' => $detail_header['transaksi_detail_group'], 'id_transaksi_detail' => $detail_header['transaksi_detail_id']))->row_array();

              ?>
                <input type="text" name="transaksi_detail_id_temp[]" value="<?= $detail_header['transaksi_detail_id'] ?>" style="display:none">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?php echo $multisample_group['transaksi_id'] ?>">
                <input type="text" name="logsheet_id[]" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?php echo $multisample_group['transaksi_detail_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?php echo $multisample_group['id_transaksi_non_rutin'] ?>">
                <input type="text" style="display: none;" name="header_menu" value="<?= $this->input->get('header_menu') ?>">
                <input type="text" style="display: none;" name="menu_id" value="<?= $this->input->get('menu_id') ?>">
                <input type="text" style="display: none;" name="template_logsheet_id" value="<?= $this->input->get('template_logsheet_id') ?>">
                <input type="text" style="display:none" id="transaksi_detail_group" name="transaksi_detail_group" value="<?= $this->input->get('transaksi_detail_group') ?>">
                <input type="text" style="display: none;" name="transaksi_tipe" value="<?= $multisample_group['transaksi_tipe'] ?>" id="transaksi_tipe">
              <?php endforeach; ?>
              <textarea name="custom_raw_eksekutor" class="custom_raw_eksekutor" id="custom_raw_eksekutor">
                <div style="width: 100%; text-align: center; font-size: 14pt; margin-bottom: 20px;">LEMBAR KERJA <?= strtoupper($multisample_group['jenis_nama']) ?></div>
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
                    <div style="width: 35%;"><?= ($logsheet_group['logsheet_review_date'] != '') ? date_indo(date('Y-m-d', strtotime($logsheet_group['logsheet_review_date']))) : '-' ?></div>
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
                    <div style="width: 60%;"><?= $logsheet_group['logsheet_jenis'] ?></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Tanda</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"><?= $logsheet_group['logsheet_nomor_permintaan'] ?></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Catatan</div>
                    <div style="width: 5%;">:</div>
                    <!-- <div style="width: 60%;"><?= $logsheet_group['logsheet_deskripsi'] ?></div> -->
                    <div style="width: 60%;"></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Sertifikat</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Area</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"></div>
                  </div>
                  <!-- <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">No. Lab</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"></div>
                  </div> -->
                  <?php if ($inbox_detail[0]['is_sampling'] == 'y') : ?>
                    <div style="display: flex; margin: 10px;">
                      <div style="width: 35%;">Tanggal Sampling</div>
                      <div style="width: 5%;">:</div>
                      <div style="width: 60%;"><?= date_indo('Y-m-d', strtotime($logsheet_group['logsheet_tgl_sampling'])) ?></div>
                    </div>
                  <?php endif ?>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Tanggal Terima</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"><?= date_indo('Y-m-d', strtotime($logsheet_group['logsheet_tgl_terima'])) ?></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Tanggal Pengujian</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"><?= date_indo('Y-m-d', strtotime($logsheet_group['logsheet_tgl_uji'])) ?></div>
                  </div>
                  <div style="display: flex; margin: 10px;">
                    <div style="width: 35%;">Analisis</div>
                    <div style="width: 5%;">:</div>
                    <div style="width: 60%;"><?= ($logsheet_group['logsheet_analisis'] != '') ? $logsheet_group['logsheet_analisis'] : $session['user_nama'] ?></div>
                  </div>
                </div>

                <?php foreach ($template_detail as $key_td => $val_td) :                      ?>
                  <?php
                  $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
                  $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id']));
                  // $logsheet_level_2_group = $this->M_inbox->getLogsheetDetailGroup(array('logsheet_multiple_id' => $val_md['logsheet_multiple_id'], 'logsheet_id' => $val_md['logsheet_id'], 'rumus_id' => $val_td['rumus_id']));
                  foreach ($multi_detail as $key_detail => $val_detail) :
                    $logsheets = $this->M_multi_sample->getLogsheet(array('transaksi_id' => $this->input->get_post('transaksi_id'), 'logsheet_multiple_id' => $this->input->get('transaksi_detail_group'), 'id_transaksi_detail' => $val_detail['transaksi_detail_id']));
                  endforeach;
                  ?>
                  <div class="card-header col-12">
                    <!-- <center> -->
                      <h3 class="card-title">
                        <?= $val_td['rumus_nama'] ?>
                      </h3>
                    <!-- </center> -->
                    <br />
                  </div>
                  <!-- <?php foreach ($logsheet_level_2_group as $key_llg2 => $val_llg2) : ?>
                            <div class="card-body col-12 row">
                              <div class="col-6">
                                <div class="form-group row col-12">
                                  <label class="col-md-4">Metoda</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control" id="rumus_metoda_<?= $key_td ?>" name="rumus_metoda" readonly value="<?= $val_llg2['rumus_metoda'] ?>">
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group row col-12">
                                  <label class="col-md-4">Satuan</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control" name="rumus_satuan" id="rumus_satuan_<?= $key_td ?>" readonly value="<?= $val_llg2['rumus_satuan'] ?>">
                                  </div>
                                </div>
                              </div>
                            <?php endforeach; ?> -->
                  <div class="card-body">
                    <table id="table" class="table table-bordered  datatables" width="100%">
                      <thead>
                        <tr>
                          <th>No Sample</th>
                          <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                            <th><?= $val_dr['rumus_detail_nama']; ?></th>
                          <?php endforeach; ?>
                          <th>Hasil</th>
                        </tr>
                      </thead>
                      <?php
                      if ($this->input->get('transaksi_detail_group') && $this->input->get('transaksi_detail_group') != 'null') {
                        $logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('logsheet_multiple_id' => $this->input->get('transaksi_detail_group'), 'rumus_id' => $val_td['rumus_id']));
                      } else {
                        $hexStrings = $this->input->get_post('transaksi_detail_id_group');
                        $hexArray = explode(',', $hexStrings);
                        $hexArray2 = implode("','", $hexArray);
                        $logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('id_transaksi_detail_group' => $hexArray, 'rumus_id' => $val_td['rumus_id']));
                      }
                      ?>
                      <?php foreach ($logsheet_level_2 as $key_ll2 => $val_ll2) : ?>
                        <tbody>
                          <tr>
                            <td>
                              <?= $val_ll2['logsheet_nomor_sample'] ?>
                            </td>
                            <?php
                            $logsheet_level_3 = $this->M_inbox->getLogsheetDetailDetail(array('logsheet_detail_id' => $val_ll2['logsheet_detail_id']));
                            foreach ($logsheet_level_3 as $key_ll3 => $val_ll3) : ?>
                              <?php
                              $background = '';

                              ?>
                              <td style="background-color: <?= $background ?>;">
                                <?= $val_ll3['rumus_detail_isi']; ?>
                              </td>
                            <?php endforeach; ?>
                            <td>
                              <?= $val_ll2['rumus_hasil'] ?>
                            </td>

                          </tr>
                        </tbody>
                      <?php endforeach; ?>

                    </table>
                  </div>
                <?php endforeach; ?>

                <div style="width: 30%; float: right; border-collapse:collapse; border:1px solid black; font-size: 11pt; margin-top: 20px;">
                  <div style="display: flex;">
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Analisis</div>
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Reviewer</div>
                  </div>
                  <div style="display: flex;">
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                      <?php if ($logsheet_group['logsheet_analisis'] != '') : ?>
                        <img src="<?= base_url('img/' . $logsheet_group['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                      <?php endif; ?>
                    </div>
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                      <?php if ($logsheet_group['logsheet_review'] != '') : ?>
                        <img src="<?= base_url('img/' . $logsheet_group['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </textarea>
              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="btn btn-default border-dark">Kembali</button>
                  <button type="button" id="cetak" class="btn btn-primary">Cetak Preview</button>
                  <button type="button" id="reupload" class="btn   btn-custom btn-info border-dark">Upload Ulang</button>
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
                <label class="col-md-4">is KAN</label>
                <div class="input-group col-md-8">
                  <input type="checkbox" name="is_kan" id="is_kan" class="form-control-checkbox" value="y">
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">is DS</label>
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