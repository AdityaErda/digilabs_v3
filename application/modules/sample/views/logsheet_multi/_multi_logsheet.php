<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }

  .dataTables_scrollHead {
    /* overflow: auto !important; */
    /*    width: 100%;*/
  }

  .kolom_header {
    /* background-color: grey; */
  }

  .kolom_konten {
    background-color: white;
  }
</style>

<?php $session = $this->session->userdata(); ?>

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
        <div class="col-12">
          <form id="form_logsheet" action="<?=base_url('sample/multi_sample/insertLogsheetMultiple')?>">
            <!-- FILTER -->
            <!-- Memorandum -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">
                  <center> Lembar Kerja <?= $inbox['transaksi_nomor'] ?> </center>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <!-- Kiri -->
                <!-- deklarasi data awal -->
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?php echo $inbox['transaksi_id'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?php echo $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?php echo $inbox['transaksi_non_rutin_id'] ?>">


                <?php
                $nomor_sample = '';
                $jenis_nama = '';

                foreach ($identitas_detail as $key_identitas => $detail_identitas) :
                  $nomor_sample .= $detail_identitas['transaksi_detail_nomor_sample'] . ', ';
                  $jenis_nama .= $detail_identitas['jenis_nama'] . ', ';
                  ?>
                  <input type="text" class="form-control" id="transaksi_detail_status_<?= $key_identitas ?>" name="transaksi_detail_status[<?=$key_identitas?>]" style="display:none" value="<?php echo $detail_identitas['transaksi_detail_status'] ?>">
                  <input type="text" class="form-control" id="transaksi_detail_id_temp_<?= $key_identitas ?>" name="transaksi_detail_id_temp[<?=$key_identitas?>]" value="<?php echo $detail_identitas['transaksi_detail_id'] ?>" style="display: none;">
                  <input type="text" class="form-control" id="transaksi_detail_id_<?= $key_identitas ?>" name="transaksi_detail_id[<?=$key_identitas?>]" value="<?php echo create_id(); ?>" style="display: none;">
                  <input type="text" class="form-control" id="logsheet_nomor_sample_<?= $key_identitas ?>" name="logsheet_nomor_sample[<?=$key_identitas?>]" placeholder="Judul" value="<?php echo $detail_identitas['transaksi_detail_nomor_sample']; ?>" style="display:none">
                  <input type="text" class="form-control" id="logsheet_jenis_<?= $key_identitas ?>" name="logsheet_jenis[<?=$key_identitas?>]" placeholder="Judul" value="<?php echo $detail_identitas['jenis_nama'] ?>" style="display:none">
                  <input type="text" class="form-control" id="logsheet_jenis_id_<?= $key_identitas ?>" name="logsheet_jenis_id[<?=$key_identitas?>]" placeholder="Judul" value="<?php echo $detail_identitas['jenis_id'] ?>" style="display:none">
                  <input type="text" name="logsheet_tgl_sampling[<?=$key_identitas?>]" id="logsheet_tgl_sampling_<?= $key_identitas ?>" value="<?= $detail_identitas['transaksi_detail_tgl_sampling'] ?>" style="display:none">
                  <input type="text" id="logsheet_id" name="logsheet_id[<?=$key_identitas?>]" value="<?php echo create_id(); ?>" style="display:none">
                <?php endforeach; ?>
                <!-- deklarasi data awal -->

                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample_show" name="logsheet_nomor_sample_show" placeholder="Judul" value="<?php echo $nomor_sample; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_show" name="logsheet_jenis_show" placeholder="Judul" value="<?php echo $jenis_nama ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Peminta Jasa</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_peminta_jasa" name="logsheet_peminta_jasa" value="<?php echo $inbox['peminta_jasa_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Permintaan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" value="<?php echo $inbox['transaksi_nomor'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <!-- jika sampling -->
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima">
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Pengujian</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji">
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Asal Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_asal_sample" name="logsheet_asal_sample" placeholder="Asal Sample" value="" required>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Pengambilan Sample Oleh</label>
                        <div class="input-group col-md-8">
                          <select name="logsheet_pengolah_sample" id="logsheet_pengolah_sample" class="form-control select2" required></select>
                          <!-- <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value=""> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Memorandum -->
            <!-- Transaksi Detail -->
            <?php foreach ($multi_detail as $key => $value):
              $param_jenis['jenis_id'] = $value['jenis_id'];
              $data_jenis = $this->M_rumus_multiple->getJenisSample($param_jenis);
              $data_rumus = $this->M_nomor->getRumusAll($param_jenis);
              if ($value['identitas_id'] != '') $data_identitas = $this->M_sample_jenis->getSampleIdentitas(array('identitas_id' => $value['identitas_id']));
              ?>
              <input type="text" id="logsheet_jenis_id" name="logsheet_jenis_id[]" value="<?= $data_jenis['jenis_id']; ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_<?= $key; ?>" name="transaksi_detail_id" value="<?= $value['transaksi_detail_id'] ?>" style="display:none">
              <div class="card">
                <!-- Header -->
                <div class="card-header bg-info">
                  <h3 class="card-title">Logsheet - <?= $data_jenis['jenis_nama'] ?></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- Header -->
                <!-- Body -->
                <div class="card-body">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Uji</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama" placeholder="Jenis Uji" value="<?php echo $data_jenis['jenis_nama'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Deskripsi</label>
                          <div class="input-group col-md-8">
                            <textarea name="log_deskripsi" id="log_deskripsi" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample"></textarea>
                          </div>
                        </div>
                      </div>
                      <!-- Kanan -->
                      <!-- Rumus -->
                      <?php if (!empty($data_rumus)): ?>
                        <?php foreach ($data_rumus as $k => $val): ?>
                          <?php
                          $param_parameter_rumus_detail['id_parameter'] = $val['detail_multiple_rumus_id'];
                          $data_parameter_rumus_detail = $this->M_rumus_multiple->getParameterRumus($param_parameter_rumus_detail);

                          $rumus = $val['parameter_rumus'].' = ';
                          foreach ($data_parameter_rumus_detail as $val_rumus_detail) {
                            $rumus .= ($val_rumus_detail['rumus_jenis'] == 'I') ? $val_rumus_detail['detail_parameter_rumus'] : $val_rumus_detail['rumus_detail_input'];
                          }
                          ?>
                          <input type="text" name="rumus_id[<?= $val['detail_multiple_rumus_id'] ?>][]" value="<?= $val['detail_multiple_rumus_id'] ?>" style="display:none">
                          <h5 style="background-color:aqua;" class="text-center font-weight-bold col-12"><?= $rumus ?></h5>
                          <!-- Table -->
                          <table width="100%" class="table table-striped table-bordered table_logsheet" cellspacing="0" cellpadding="0" id="table_logsheet">
                            <thead>
                              <tr>
                                <td width="150">Kode / Urut</td>
                                <?php foreach ($data_parameter_rumus_detail as $val_rumus_detail) : ?>
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
                              <?php $random = $key.$k; ?>
                              <tr>
                                <td>
                                  <input type="text" name="random_temp[]" id="random_temp_<?= $random ?>" value="<?= $random ?>" style="display:none">
                                  <input type="text" name="logsheet_id[<?= $val['detail_multiple_rumus_id'] ?>][]" id="logsheet_id_<?= $random ?>" value="<?= $val['detail_multiple_rumus_id'] ?>" class="form-control" style="display:none">
                                  <input type="text" name="logsheet_detail_urut" id="logsheet_detail_urut_<?= $random ?>" value="<?= $k + 1 ?>" class="form-control" readonly>
                                </td>
                                <?php foreach ($data_parameter_rumus_detail as $val_rumus_detail): ?>
                                  <?php if ($val_rumus_detail['rumus_detail_input'] != null): ?>
                                    <td style="display: none;">
                                      <input type="text" id="logsheet_detail_detail_rumus_isi_<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>_<?= $random; ?>" name="logsheet_detail_rumus_isi[<?= $val['detail_multiple_rumus_id'] ?>][<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>]" value="<?php echo ($val_rumus_detail['rumus_detail_input']); ?>" style="display:none;">
                                    </td>
                                  <?php else: ?>
                                    <td>
                                      <input type="text" id="logsheet_detail_detail_rumus_isi_<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>_<?= $random; ?>" name="logsheet_detail_rumus_isi[<?= $val['detail_multiple_rumus_id'] ?>][<?= $val_rumus_detail['detail_parameter_rumus_id'] ?>]" value="<?php echo ($val_rumus_detail['rumus_detail_input']); ?>" class="form-control" onkeypress="return numberWithComma(event)" >
                                    </td>
                                  <?php endif ?>
                                <?php endforeach ?>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_metoda[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="rumus_metoda_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" class="form-control" value="<?= $val['metode'] ?>">
                                </td>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_satuan[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="rumus_satuan_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" class="form-control" value="<?= $val['satuan_parameter'] ?>">
                                </td>
                                <td>
                                  <input type="text" name="logsheet_detail_rumus_hasil[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" onClick="lihatHasil(this.id)" class="form-control" readonly>
                                </td>
                                <td>
                                  <textarea name="logsheet_kesimpulan[<?= $value['transaksi_detail_id'] ?>][<?= $val['detail_multiple_rumus_id'] ?>]" id="logsheet_kesimpulan_<?= $val['detail_multiple_rumus_id'] ?>_<?= $random ?>" cols="30" rows="3" class="form-control" placeholder="Silahkan masukan keterangan yang diperlukan"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- Table -->
                        <?php endforeach ?>
                      <?php else: ?>
                        <h3 style="background-color: orange;" class="text-center font-weight-bold col-12">Data parameter rumus belum ada dimaster silahkan input terlebih dahulu (Logsheet tidak akan bisa diproses)</h3>
                      <?php endif ?>
                      <!-- Rumus -->
                    </div>
                  </div>
                </div>
                <!-- Body -->
              </div>
            <?php endforeach ?>
            <!-- Tombol -->
            <div class="card-footer">
              <button type="button" id="kembali" class="btn btn-default border-dark no-print" onclick="kembali_multiple()">Kembali</button>
              <button type="submit" id="simpan" class="btn btn-success" style="float:right;" >Simpan</button>
              <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>
            </div>
            <!-- Tombol -->
            <!-- Transaksi Detail -->
          </form>
          <!-- modal -->
          <div class="modal fade" id="modal_lihat">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"> $judul </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="form_modal_lihat">
                  <input type="hidden" id="jadwal_id" name="jadwal_id" value="">
                  <div class="modal-body">
                    <div class="card-body row" id="div_document" style="height: 400px;">
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- modal -->
          <div class="modal fade" id="modal_batal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Batal</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form_batal">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row col-md-12">
                          <label class="col-md-4">Alasan Pembatalan</label>
                          <div class="input-group col-md-8">
                            <input type="text" name="transaksi_batal_alasan" id="transaksi_batal_alasan" class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_batal">Close</button>
                  <button type="button" class="btn btn-primary" id="simpan_batal">Batal</button>
                  <button class="btn btn-primary" type="button" id="loading_batal" disabled style="display: inline-block;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="modal_tunda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tunda</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form_tunda">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row col-md-12">
                          <label class="col-md-4">Alasan Penundaan</label>
                          <div class="input-group col-md-8">
                            <input type="text" name="transaksi_tunda_alasan" id="transaksi_tunda_alasan" class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_tunda">Close</button>
                  <button type="button" class="btn btn-primary" id="simpan_tunda">Tunda</button>
                  <button class="btn btn-primary" type="button" id="loading_tunda" disabled style="display: inline-block;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->