<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
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
          <h1>
            <?= $judul ?>
          </h1>
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
          <form id="form_logsheet_multiple" method="POST" action="<?= base_url() ?>sample/nomor/insertLogsheetMultipleDraft">
            <!-- Detail Sample -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">Detail Sample</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <?php
                $jumlah = 0;
                foreach ($nomor_detail_group as $value) {
                  $arr_nomor_sample[] = $value['transaksi_nomor'];
                  $arr_nama_sample[] = $value['jenis_nama'];
                  $arr_peminta_jasa[] = $value['peminta_jasa_nama'];
                  $arr_jenis_pekerjaan[$value['sample_pekerjaan_nama']] = $value['sample_pekerjaan_nama'];
                  $jumlah += $value['jumlah'];
                }
                $nomor_sample = implode(', ', $arr_nomor_sample);
                $nama_sample = implode(', ', $arr_nama_sample);
                $peminta_jasa = implode(', ', $arr_peminta_jasa);
                $jenis_pekerjaan = implode(', ', $arr_jenis_pekerjaan);
                ?>
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="header_menu" name="header_menu" value="<?= $_GET['header_menu'] ?>" style="display:none">
                <input type="text" id="menu_id" name="menu_id" value="<?= $_GET['menu_id'] ?>" style="display:none">
                <input type="text" id="status" name="status" style="display:none" value="<?= $_GET['status'] ?>">
                <input type="text" id="transaksi_rutin_id" name="transaksi_rutin_id" style="display:none" value="<?= $_GET['id_transaksi_rutin'] ?>">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="R" style="display:none">
                <div class="col-12">
                  <div class="row">
                    <!-- Kiri -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Petugas</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_petugas" name="transaksi_petugas" placeholder="Judul" value="<?= $nomor['who_create'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_nomor" name="transaksi_nomor" placeholder="Judul" value="<?= $nomor_sample ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Peminta Jasa</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_peminta_jasa" name="transaksi_peminta_jasa" placeholder="Judul" value="<?= $peminta_jasa ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_jenis" name="transaksi_jenis" placeholder="Judul" value="<?= $nama_sample; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Pekerjaan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_pekerjaan" name="transaksi_pekerjaan" placeholder="Judul" value="<?= $jenis_pekerjaan ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Kiri -->
                    <!-- Kanan -->
                    <div class="col-6">
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group date col-md-8">
                          <input type="date" class="form-control" id="transaksi_tanggal_terima" name="transaksi_tanggal_terima" value="<?= $logsheet_group['logsheet_tgl_terima'] ?>" placeholder="Ext Pengirim Sample" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Uji</label>
                        <div class="input-group date col-md-8">
                          <input type="date" class="form-control" id="transaksi_tanggal_uji" name="transaksi_tanggal_uji" placeholder="Judul" value="<?= $logsheet_group['logsheet_tgl_uji'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Asal Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_asal" name="transaksi_asal" placeholder="Asal sample" value="<?= $logsheet_group['logsheet_asal_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Penerima Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_penerima" name="transaksi_penerima" placeholder="Penerima Sample" value="<?= $logsheet_group['logsheet_pengolah_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jumlah Contoh</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_jumlah" name="transaksi_jumlah" placeholder="Judul" value="<?= $jumlah ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Kanan -->
                  </div>
                </div>
              </div>
              <!-- Body -->
            </div>
            <!-- Detail Sample -->

            <!-- Transaksi Detail -->
            <?php foreach ($logsheet as $key => $value) : ?>
              <?php
              $param_jenis['jenis_id'] = $value['jenis_id'];
              $data_jenis = $this->M_rumus_multiple->getJenisSample($param_jenis);

              $data_logsheet_detail = $this->M_nomor->getLogsheetDetail(array('logsheet_id' => $value['logsheet_id']));

              if ($value['identitas_id'] != '') $data_identitas = $this->M_sample_jenis->getSampleIdentitas(array('identitas_id' => $value['identitas_id']));
              ?>
              <input type="text" id="logsheet_jenis_id" name="logsheet_jenis_id[]" value="<?= $data_jenis['jenis_id']; ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_<?= $key; ?>" name="transaksi_detail_id[]" value="<?= $value['transaksi_detail_id'] ?>" style="display:none">
              <div class="card">
                <!-- Header -->
                <div class="card-header bg-info">
                  <h3 class="card-title">Logsheet - <?= $value['logsheet_jenis_nama'] ?></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- Header -->
                <!-- Body -->
                <div class="card-body">
                  <div class="col-12">
                    <div class="row">
                      <!-- Kiri -->
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Identitas</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_identitas" name="transaksi_identitas" placeholder="Identitas" value="<?= (!empty($data_identitas)) ? $data_identitas['identitas_nama'] : '' ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <!-- Kiri -->
                      <!-- Kanan -->
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Nomor</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_nomor_detail" name="transaksi_nomor_detail" placeholder="Nomor" value="<?= (!empty($value)) ? $value['transaksi_nomor'] : '' ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <!-- Kanan -->
                      <!-- Rumus -->
                      <?php if (!empty($data_logsheet_detail)) : ?>
                        <?php foreach ($data_logsheet_detail as $k => $val) : ?>
                          <?php
                          $param_logsheet_detail_detail['logsheet_detail_id'] = $val['logsheet_detail_id'];
                          $data_logsheet_detail_detail = $this->M_nomor->getLogsheetDetailDetail($param_logsheet_detail_detail);

                          $rumus = $val['parameter_rumus'] . ' = ';
                          foreach ($data_logsheet_detail_detail as $val_rumus_detail) {
                            $rumus .= ($val_rumus_detail['rumus_jenis'] == 'I') ? $val_rumus_detail['detail_parameter_rumus'] : $val_rumus_detail['rumus_input'];
                          }
                          ?>
                          <input type="text" name="rumus_id[<?= $val['detail_multiple_rumus_id'] ?>][]" value="<?= $val['detail_multiple_rumus_id'] ?>" style="display:none">
                          <h5 style="background-color:aqua;" class="text-center font-weight-bold col-12"><?= $rumus ?></h5>
                          <!-- Table -->
                          <table width="100%" class="table table-striped table-bordered table_logsheet" cellspacing="0" cellpadding="0" id="table_logsheet">
                            <thead>
                              <tr>
                                <td width="150">Kode / Urut</td>
                                <?php foreach ($data_logsheet_detail_detail as $val_rumus_detail) : ?>
                                  <?php if ($val_rumus_detail['detail_parameter_rumus'] != '') : ?>
                                    <td><?php echo $val_rumus_detail['detail_parameter_rumus'] ?></td>
                                  <?php endif ?>
                                <?php endforeach; ?>
                                <td width="150">Metoda</td>
                                <td width="150">Satuan</td>
                                <td>Hasil</td>
                                <td>Keterangan</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $random = $key . $k; ?>
                              <tr>
                                <td>
                                  <input type="text" name="random_temp[]" id="random_temp_<?= $random ?>" value="<?= $random ?>" style="display:none">
                                  <input type="text" name="logsheet_id[<?= $val['detail_multiple_rumus_id'] ?>][]" id="logsheet_id_<?= $random ?>" value="<?= $val['detail_multiple_rumus_id'] ?>" class="form-control" style="display:none">
                                  <input type="text" name="logsheet_detail_urut" id="logsheet_detail_urut_<?= $random ?>" value="<?= $k + 1 ?>" class="form-control" readonly>
                                </td>
                                <?php foreach ($data_logsheet_detail_detail as $val_rumus_detail) : ?>
                                  <?php if ($val_rumus_detail['rumus_detail_input'] != null) : ?>
                                    <td style="display: none;">
                                      <input type="text" id="logsheet_detail_detail_rumus_isi_<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>_<?= $random; ?>" name="logsheet_detail_rumus_isi[<?= $val['detail_multiple_rumus_id'] ?>][<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>]" value="<?php echo ($val_rumus_detail['rumus_detail_input']); ?>" style="display:none;">
                                    </td>
                                  <?php else : ?>
                                    <td>
                                      <input type="text" id="logsheet_detail_detail_rumus_isi_<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>_<?= $random; ?>" name="logsheet_detail_rumus_isi[<?= $val['detail_multiple_rumus_id'] ?>][<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>]" value="<?php echo ($val_rumus_detail['rumus_detail_isi']); ?>" class="form-control" readonly>
                                    </td>
                                  <?php endif ?>
                                <?php endforeach ?>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_metoda[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="rumus_metoda_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" class="form-control" value="<?= $val['rumus_metoda'] ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_satuan[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="rumus_satuan_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" class="form-control" value="<?= $val['rumus_satuan'] ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_hasil[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" value="<?= $val['rumus_hasil'] ?>" class="form-control" readonly>
                                </td>
                                <td>
                                  <textarea name="logsheet_kesimpulan[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="logsheet_kesimpulan_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" cols="30" rows="3" class="form-control" placeholder="Silahkan masukan keterangan yang diperlukan" readonly><?= $val['logsheet_kesimpulan'] ?></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- Table -->
                        <?php endforeach ?>
                      <?php else : ?>
                        <h3 style="background-color: orange;" class="text-center font-weight-bold col-12">Data parameter rumus belum ada dimaster silahkan input terlebih dahulu (Logsheet tidak akan bisa diproses)</h3>
                      <?php endif ?>
                      <!-- Rumus -->
                    </div>
                  </div>
                </div>
                <!-- Body -->
              </div>
            <?php endforeach ?>
            <!-- QR-Code -->
            <div class="card-body">
              <div class="col-6" style="float:right">
                <table id="table" class="table table-bordered" width="50%" style="float:right">
                  <thead>
                    <tr>
                      <th>Analisis</th>
                      <th>Reviewer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>
                        <?php if ($logsheet_group['logsheet_analisis'] != '') : ?>
                          <img src="<?= base_url('img/' . $logsheet_group['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                        <?php endif; ?>
                      </th>
                      <th>
                        <?php if ($logsheet_group['logsheet_review'] != '') : ?>
                          <img src="<?= base_url('img/' . $logsheet_group['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                        <?php endif; ?>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- QR-Code -->
            <!-- Tombol -->
            <div class="card-footer">
              <button type="button" id="kembali" class="btn btn-default border-dark no-print" onclick="kembali_rutin()">Kembali</button>
              <button type="button" id="cetak" class="btn btn-info no-print" onclick="cetak_draft()">Cetak</button>
              <button type="button" id="ulang" class="btn btn-warning no-print">Isi Ulang</button>
              <button type="submit" id="simpan" class="btn btn-success no-print" style="float:right;">Kirim Penyelia</button>
              <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>
            </div>
            <!-- Tombol -->
            <!-- Transaksi Detail -->
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!--CONTAINER -->