<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
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
          <form id="form_logsheet">
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
                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample" name="logsheet_nomor_sample" placeholder="Judul" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis" name="logsheet_jenis" placeholder="Judul" value="<?= $inbox_detail[0]['jenis_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Peminta Jasa</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_peminta_jasa" name="logsheet_peminta_jasa" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Permintaan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" value="<?= $inbox['transaksi_nomor'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">

                      <?php if ($inbox_detail[0]['is_sampling'] == 'y') { ?>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Sampling</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_sampling'])) ?>" readonly>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_terima'])) ?>" readonly>
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
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_uji'])) ?>" readonly>
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Asal Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_asal_sample" name="logsheet_asal_sample" placeholder="Asal Sample" value="<?= $logsheet['logsheet_asal_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Pengambilan Sample Oleh</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value="<?= $logsheet['logsheet_pengolah_sample'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Memorandum -->

            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"> Detail Sample <?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <div class="div_log">
                  <!-- this -->
                  <div class="div_log_baru">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Uji</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama" placeholder="Jenis Uji" value="<?= $logsheet['logsheet_jenis_nama'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Satuan</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_jenis_unit" name="log_jenis_unit" placeholder="Satuan" value="<?= $logsheet['logsheet_jenis_unit'] ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Metoda</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_metoda" name="log_metoda" placeholder="Metoda" value="<?= $logsheet['logsheet_metoda'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Deskripsi</label>
                          <div class="input-group col-md-8">
                            <textarea name="log_deskripsi" id="log_deskripsi" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample" readonly><?= $logsheet['logsheet_deskripsi'] ?></textarea>
                          </div>
                        </div>

                      </div>
                    </div>
                    <br>
                    <!-- Rumus -->
                    <!-- <div class="row" id="div_rumus_lama">
                      <?php foreach ($logsheet_detail as $key => $value) : ?>
                        <div class="card-header col-12">
                          <h3 class="card-title"><?= $value['rumus_nama'] ?></h3>
                        </div>
                        <div class="form-group col-12 row">
                          <table id="<?= $value['id_rumus'] ?>" class="table table-bordered table-striped datatables" width="100%">
                            <?php
                            $sql = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet_detail='" . $value['logsheet_detail_id'] . "'");
                            ?>
                            <thead>
                              <tr>
                                <?php foreach ($sql->result_array() as $key1 => $value1) : ?>
                                  <th><?= $value1['rumus_detail_nama'] ?></th>
                                <?php endforeach; ?>
                                <th>Hasil</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <?php foreach ($sql->result_array() as $key1 => $value1) :
                                 ?>
                                  <td><?= $value1['rumus_detail_isi'] ?></td>
                                <?php endforeach; ?>
                                <td><?=  $value['rumus_hasil'] ?></td>
                              </tr>
                            </tbody>
                            <tfoot id="footer_' + val.rumus_id + '">
                              <?php
                              if($value['rumus_avg']!=''){
                              ?> 
                              <td>Rata-Rata</td>
                                <td><?=$value['rumus_avg']?></td>
                              <?php
                              }                              
                              ?>
                            </tfoot>

                          </table>
                        </div>
                      <?php endforeach; ?>
                    </div> -->

                    <div class="row" id="div_rumus_lama">
                      <?php foreach ($detail_logsheet as $keyx => $valuex) : ?>
                        <div class="card-header col-12">
                          <h3 class="card-title"><?= $valuex['rumus_nama'] ?></h3>
                        </div>
                        <div class="form-group col-12 row">
                          <table id="" class="table table-bordered table-striped datatables" width="100%">
                            <?php
                            $sql_header = $this->db->query("SELECT DISTINCT rumus_detail_nama FROM sample.sample_logsheet_detail_detail where id_rumus = '".$valuex['rumus_id']."'");
                            $sql_footer = $this->db->query("SELECT DISTINCT rumus_avg FROM sample.sample_logsheet_detail where id_rumus = '".$valuex['rumus_id']."' AND logsheet_id='".$_GET['logsheet_id']."'");
                            $sql_1 = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '".$_GET['transaksi_id']."' AND a.logsheet_id = '".$_GET['logsheet_id']."' AND b.id_rumus = '".$valuex['rumus_id']."'");
                            echo $this->db->last_query();
                            
                            $jumlah_header = $sql_header->num_rows();

                          ?>
                          <thead>
                            <tr>
                              <?php foreach ($sql_header->result_array() as $key_header1 => $value_header1) : ?>
                                <?php if($value_header1['rumus_detail_nama']!=$value_header1['rumus_detail_nama']): ?>
                                  <th><?= $value_header1['rumus_detail_nama'] ?></th>
                                <?php else: ?>
                                  <th><?= $value_header1['rumus_detail_nama'] ?></th>
                                <?php endif ?>
                              <?php endforeach; ?>
                              <th>Hasil</th>
                            </tr>
                          </thead>

                          <?php
                          foreach($sql_1->result_array() as $key=>$value):

                            $sql = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet_detail='" . $value['logsheet_detail_id'] . "'");
                            ?>
                            <tbody>
                              <tr>
                                <?php foreach ($sql->result_array() as $key1 => $value1) :
                                 ?>
                                 <td><?= $value1['rumus_detail_isi'] ?></td>
                               <?php endforeach; ?>
                               <td><?=  $value['rumus_hasil'] ?></td>
                             </tr>
                           </tbody>
                         <?php endforeach;?>
                         <tfoot>
                           <tr>
                            <th colspan="<?php echo($jumlah_header)?>"> <?php echo($jumlah_header)?> Rata - rata</th>
                            <?php foreach ($sql_footer->result_array() as $key_footer1 => $value_footer1) : ?>
                              <th><?= $value_footer1['rumus_avg'] ?></th>                                
                            <?php endforeach; ?>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  <?php endforeach; ?>
                </div>
                <!-- Rumus -->
                <hr>
              </div>
              <!-- this -->
            </div>
            <div class="input-group col-md-3">
              <!-- <button type="button" id="add_log" name="add_log" class="btn btn-primary">Tambah Parameter Uji</button> -->
            </div>
          </div>
          <div class="card-body col-6">
            <table id="table" class="table table-bordered" width="50%">
              <thead>
                <tr>
                  <th>Analisis</th>
                  <th>Reviewer</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>
                    <?php if ($logsheet['logsheet_analisis'] != '') : ?>
                      <img src="<?= ($logsheet['ttd_analisis']) ? base_url('document/') . $logsheet['ttd_analisis'] : base_url('gambar/img/logo/ttd_default.jpg') ?>" style="max-width:5cm;max-height:2cm">
                    <?php endif; ?>
                  </th>
                  <th>
                    <?php if ($logsheet['logsheet_review'] != '') : ?>
                      <img src="<?= ($logsheet['ttd_review']) ? base_url('document/') . $logsheet['ttd_review'] : base_url('gambar/img/logo/ttd_default.jpg') ?>" style="max-width:5cm;max-height:2cm">
                    <?php endif; ?>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- </form> -->
          <div class="no-print">
            <div class="card-footer">
              <button type="button" id="close" class="btn btn-default border-dark" onclick="history.back()">Kembali</button>
              <button type="button" id="draft" class="btn btn-info">Draft</button>
              <button type="button" id="cetak" class="btn btn-primary">Cetak Preview</button>
              <button type="button" id="simpan" class="btn btn-success float-right">Selanjutnya</button>
            </div>
          </div>
        </div>
      </form>
      <!-- modal -->
      <div class="modal fade" id="modal_lihat">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?= $judul ?></h4>
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
              <button class="btn btn-primary" type="button" id="loading_batal" disabled style="display: none;">
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
              <button class="btn btn-primary" type="button" id="loading_tunda" disabled style="display: none;">
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