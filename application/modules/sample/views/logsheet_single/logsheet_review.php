<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  #modal-content {
    overflow: scroll !important;
  }

  * {
    box-sizing: border-box;
  }

  .rows {
    display: flex;
    margin-left: -5px;
    margin-right: -5px;
  }

  .columns {
    flex: 50%;
    padding: 5px;
  }

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }

  th,
  td {
    text-align: left;
    padding: 16px;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
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
          <!-- <h1>Lembar Kerja <?= $inbox_detail[0]['jenis_nama'] ?></h1> -->
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
          <!-- LogSheet -->
          <form id="form_logsheet">
            <div class="card">
              <input type="text" id="is_new" name="is_new" style="display:none">
              <input type="text" id="transaksi_tipe" name="transaksi_tipe" style="display:none" value="<?= $inbox['transaksi_tipe'] ?>">
              <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
              <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
              <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
              <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
              <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
              <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
              <input type="text" id="transaksi_detail_id_new" name="transaksi_detail_id_new" value="<?= create_id() . '-' . rand(); ?>" style="display: none;">
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
                    <div style="width: 35%;"><?= ($logsheet['logsheet_review_date'] != '') ? date_indo(date('Y-m-d', strtotime($logsheet['logsheet_review_date']))) : '-' ?></div>
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

                <!-- Detail Logsheet -->
                <?php foreach ($detail_logsheet as $value) : ?>
                  <?php
                  $dataDetailRumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_urut ASC")->result_array();

                  $dataHeader = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail where rumus_detail_template IS NOT NULL AND id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_template ASC")->result_array();

                  $dataBody = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus LEFT JOIN sample.sample_template_logsheet_detail d ON b.id_rumus = d.logsheet_nama_rumus AND a.id_template_logsheet = d.id_logsheet_template WHERE id_transaksi = '" . $this->input->get('transaksi_id') . "' AND a.logsheet_id = '" . $this->input->get('logsheet_id') . "' AND b.id_rumus = '" . $value['rumus_id'] . "' ORDER BY d.detail_logsheet_urut ASC")->result_array();

                  $dataLogsheetDetailGroup = $this->db->query("SELECT DISTINCT rumus_metoda,rumus_avg,rumus_satuan,rumus_adbk FROM sample.sample_logsheet_detail WHERE logsheet_id = '" . $this->input->get_post('logsheet_id')  . "' AND id_rumus = '" . $value['rumus_id'] . "'")->row_array();

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
                      <div style="width: 60%;">
                        <?= $dataLogsheetDetailGroup['rumus_metoda'] ?>
                      </div>
                    </div>
                    <div style="display: flex; margin: 10px;">
                      <div style="width: 35%;">Satuan</div>
                      <div style="width: 5%;">:</div>
                      <div style="width: 60%;">
                        <?= $dataLogsheetDetailGroup['rumus_satuan'] ?>
                      </div>
                    </div>

                    <div class="rows" style= "display: flex;">
                      <div class="columns" style="flex: 100%;display:contents">


                        <table style="width: 75%; border-collapse: collapse; border: 1px solid black; font-size: 11pt;">
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
                                <?php
                                $dataDetail = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet_detail='" . $v_body['logsheet_detail_id'] . "' ORDER BY rumus_detail_template ASC")->result_array();
                                ?>
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
                      <div class="columns" style="flex: 50%;padding-left:20px">
                        <table style="width: 25%; border-collapse: collapse; border: 1px solid black; font-size: 11pt;">
                  <?php
                  $sql_kurva_header = $this->db->query("SELECT * FROM sample.sample_kurva_header a LEFT JOIN sample.sample_kurva b ON b.kurva_id = a.id_kurva WHERE b.id_rumus = '" . $value['rumus_id'] . "'");
                  $kurva_header = $sql_kurva_header->result_array();
                  ?>
                  <thead>
                    <tr>
                      <?php foreach ($kurva_header as $header) : ?>
                        <th><?= $header['kurva_header_nama'] ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php foreach ($kurva_header as $header) : ?>
                        <td>
                          <?php
                          $sql_kurva_isi = $this->db->get_where('sample.sample_kurva_isi', array('id_kurva_header' => $header['kurva_header_id']));
                          $data_kurva_isi = $sql_kurva_isi->result_array();
                          ?>
                          <?php foreach ($data_kurva_isi as $isi) : ?>
                            <p><?= $isi['kurva_isi_jumlah'] ?></p>
                          <?php endforeach; ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>
                  </tbody>
                </table>

                        <!-- kurva -->
                      </div>
                    </div>

                  </div>
                <?php endforeach ?>
                <!-- Detail Logsheet -->

                <!-- Detail Kurva -->

                <!-- Detail Kurva -->


                <!-- Detail Cek Sample -->
                <div style="font-size: 14pt; margin-top: 10px;font-weight:bold">
                  Cek Sample
                </div>
                <?php foreach ($detail_logsheet as $value) : ?>
                  <?php
                  $detailRumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_urut ASC")->result_array();
                  $tableHeader = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail where rumus_detail_template IS NOT NULL AND id_rumus = '" . $value['rumus_id'] . "' ORDER BY rumus_detail_template ASC")->result_array();

                  $tableBody = $this->db->select('*')->from('sample.sample_logsheet a')->join('sample.sample_cek_sample b', 'b.id_template_logsheet=a.id_template_logsheet', 'left')->join('sample.sample_cek_sample_detail c', 'c.cek_sample_id=b.cek_sample_id', 'left')->join('sample.sample_perhitungan_sample d', 'd.rumus_id=c.id_rumus', 'left')->join('sample.sample_template_logsheet_detail e', 'e.logsheet_nama_rumus=c.id_rumus AND b.id_template_logsheet = e.id_logsheet_template', 'left')->where('a.id_transaksi', $this->input->get('transaksi_id'))->where('c.id_rumus', $value['rumus_id'])->where('b.id_template_logsheet', $this->input->get('template_logsheet_id'))->where('a.logsheet_id', $this->input->get('logsheet_id'))->where('b.is_lama', 'n')->get()->result_array();

                  $tableFooter = $this->db->query("SELECT DISTINCT id_rumus, rumus_avg, rumus_adbk FROM sample.sample_cek_sample_detail a LEFT JOIN sample.sample_cek_sample b ON b.cek_sample_id = a.cek_sample_id WHERE id_rumus = '" . $value['rumus_id'] . "' AND id_template_logsheet='" . $_GET['template_logsheet_id'] . "' AND rumus_avg IS NOT NULL AND rumus_adbk IS NOT NULL")->result_array();
                  ?>
                  <div style="width: 100%; margin-top: 30px;">
                    <div style="font-size: 14pt; margin-bottom: 5px;">
                      <?= $value['rumus_nama'] ?> =
                      <?php foreach ($detailRumus as $detail_rumus) : ?>
                        <?= ($detail_rumus['rumus_detail_nama'] != null) ? $detail_rumus['rumus_detail_nama'] : $detail_rumus['rumus_detail_input']; ?>
                      <?php endforeach ?>
                    </div>
                    <div style="display: flex; margin: 10px;">
                      <div style="width: 35%;">Metoda</div>
                      <div style="width: 5%;">:</div>
                      <div style="width: 60%;">
                        <?= $dataLogsheetDetailGroup['rumus_metoda'] ?>
                      </div>
                    </div>
                    <div style="display: flex; margin: 10px;">
                      <div style="width: 35%;">Satuan</div>
                      <div style="width: 5%;">:</div>
                      <div style="width: 60%;">
                        <?= $dataLogsheetDetailGroup['rumus_satuan'] ?>
                      </div>
                    </div>

                    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 11pt;">
                      <thead>
                        <tr>
                          <?php $jml_kolom[$value['rumus_id']] = (count($tableHeader) + 2) ?>
                          <?php foreach ($tableHeader as $table_header) : ?>
                            <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $table_header['rumus_detail_nama'] ?></td>
                          <?php endforeach ?>

                          <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;">Hasil</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($tableBody as $table_body) : ?>
                          <tr>
                            <?php $tableDetail = $this->db->query("SELECT * FROM sample.sample_cek_sample_detail_detail WHERE id_cek_sample_detail='" . $table_body['cek_sample_detail_id'] . "' ORDER BY rumus_detail_template ASC")->result_array(); ?>
                            <?php foreach ($tableDetail as $table_detail) : ?>
                              <td style="border-collapse: collapse; border: 1px solid black;"><?= $table_detail['rumus_detail_isi'] ?></td>
                            <?php endforeach ?>

                            <td style="border-collapse: collapse; border: 1px solid black;"><?= $table_body['rumus_hasil'] ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <?php foreach ($tableFooter as $table_rata) : ?>
                            <?php if ($table_rata['rumus_avg'] != '') : ?>
                              <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold; text-align: center;" colspan="<?= $jml_kolom[$table_rata['id_rumus']] ?>">Rata-rata</td>
                              <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $table_rata['rumus_avg'] ?></td>
                            <?php endif ?>
                          <?php endforeach ?>
                        </tr>
                        <tr>
                          <?php foreach ($tableFooter as $table_adbk) : ?>
                            <?php if ($table_adbk['rumus_adbk'] != '') : ?>
                              <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold; text-align: center;" colspan="<?= $jml_kolom[$table_adbk['id_rumus']] ?>">ADBK</td>
                              <td style="border-collapse: collapse; border: 1px solid black; font-weight: bold;"><?= $table_adbk['rumus_adbk'] ?></td>
                            <?php endif ?>
                          <?php endforeach ?>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                <?php endforeach; ?>
                <!-- Detail Cek Sample -->
                <div style="width: 30%; float: right; border-collapse:collapse; border:1px solid black; font-size: 11pt; margin-top: 20px;">
                  <div style="display: flex;">
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Analisis</div>
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">Reviewer</div>
                  </div>
                  <div style="display: flex;">
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                      <?php if ($logsheet['logsheet_analisis'] != '') : ?>
                        <img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:2cm;max-height:2cm">
                      <?php endif; ?>
                    </div>
                    <div style="width: 50%; border-collapse: collapse; border: 1px solid black; text-align: center;">
                      <?php if ($logsheet['logsheet_review'] != '') : ?>
                        <img src="<?= base_url('img/' . $logsheet['logsheet_review_qr']) ?>" style="max-width:2cm;max-height:2cm">
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </textarea>

              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="col-2 mr-2 btn btn-default">Kembali</button>
                  <button type="button" id="cetak_konsep" class="col-2 mr-2 btn btn-primary">Cetak Preview</button>
                  <button type="button" id="reupload" class="col-2 mr-2 btn btn-info">Revisi Logsheet</button>

                  <?php if ($logsheet['logsheet_review'] == '') : ?>
                    <button type="button" id="setuju_raw" class="col-2 mr-2 btn btn-success float-right">Setuju Raw Data</button>
                    <button type="button" id="reject" class="col-2 mr-2 btn btn-danger float-right">Reject</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </form>
          <!-- LogSheet -->

          <!-- Review -->
          <?php if ($logsheet['logsheet_analisis'] != '' && $logsheet['logsheet_review'] != '') : ?>
            <center>
              <form id="form_sertifikat">
                <div id="area_cetak" class="area_cetak">
                  <div id="dokumen_dof"></div>
                  <div class="no-print">
                    <div class="card-footer">
                      <button type="button" id="close" class="btn btn-default" onclick="history.back()" style="float:left;">Kembali</button>
                      <button type="button" id="refresh" class="btn btn-warning" onclick="fun_refresh_dokumen('<?= $this->input->get('transaksi_detail_id') ?>.docx')">Refresh</button>
                      <?php if ($logsheet['is_approve'] == '') { ?>
                        <button type="button" id="approve_kasie" class="btn btn-success float-right">Approve Kasie</button>
                      <?php } ?>
                      <?php if ($logsheet['is_approve'] == 'y') { ?>
                        <button type="button" id="send_dof_modal" class="btn btn-success float-right">Kirim DOF</button>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </form>
            </center>
          <?php endif; ?>
          <!-- Review -->
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->

<!-- modal reject -->
<div class="modal fade" id="modal_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_reject">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Alasan Reject</label>
                <div class="input-group col-md-8">
                  <input type="text" name="transaksi_detail_reject_alasan" id="transaksi_detail_reject_alasan" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_reject">Close</button>
        <button type="button" class="btn btn-custom btn-danger" id="simpan_reject">Reject</button>
        <button class="btn btn-primary" type="button" id="loading_reject" disabled style="display: none;">
          <img src="<?php echo site_url('assets_tambahan/ext_img/loading_page_resize_2.gif') ?>" alt="" style="width:30px">
          Loading...
        </button>
      </div>
    </div>
  </div>
</div>
<!-- modal reject -->

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
          <button type="button" class="btn btn-primary" id="setuju">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Template -->

<!-- Modal Send DOF -->
<div id="modal_send_dof" class="modal fade">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data Dokumen DOF</h5>
      </div>
      <form id="form_send_dof">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Tipe Dokumen</label>
                <div class="input-group col-md-8">
                  <input type="text" name="typeId" id="typeId" class="form-control" style="display: none;">
                  <input type="text" name="typeName" id="typeName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Template Dokumen</label>
                <div class="input-group col-md-8">
                  <select name="templateId" id="templateId" class="form-control" onchange="func_ganti_tujuan(this.value)"></select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Klasifikasi Dokumen</label>
                <div class="input-group col-md-8">
                  <input type="text" name="classId" id="classId" class="form-control" readonly style="display:none">
                  <input type="text" name="className" id="className" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Sifat Dokumen</label>
                <div class="input-group col-md-8">
                  <select name="category" id="category" class="form-control select2">
                    <option value="Biasa">Biasa</option>
                    <option value="Rahasia">Rahasia</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Kecepatan Tanggap</label>
                <div class="input-group col-md-8">
                  <select name="responseSpeed" id="responseSpeed" class="form-control select2">
                    <option value="Biasa">Biasa</option>
                    <option value="Segera">Segera</option>
                    <option value="Sangat Segera">Sangat Segera</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Judul</label>
                <div class="input-group col-md-8">
                  <input type="text" name="title" id="title" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Drafter</label>
                <div class="input-group col-md-8">
                  <input type="text" name="drafterId" id="drafterId" class="form-control" readonly style="display:none">
                  <input type="text" name="drafterName" id="drafterName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Reviewer</label>
                <div class="input-group col-md-8">
                  <select multiple class="form-control select2" id="reviewerId" name="reviewerId[]" width="100%"></select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Approver</label>
                <div class="input-group col-md-8">
                  <input type="text" name="approverId[]" id="approverId" class="form-control" readonly style="display:none">
                  <input type="text" name="approverName" id="approverName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12" id="div_tujuan">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Tujuan</label>
                <div class="input-group col-md-8">
                  <select multiple class="form-control select2" id="tujuanId" name="tujuanId[]" width="100%"></select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">CC</label>
                <div class="input-group col-md-8">
                  <select multiple class="form-control select2" id="cc" name="cc[]" width="100%"></select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_send_dof" onClick="func_close_send_dof()">Cancel</button>
          <button type="button" class="btn btn-primary" id="send_dof_new">Simpan dan Kirim</button>
          <button class="btn btn-primary" type="button" id="loading_send_dof" disabled style="display: none;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Send DOF -->