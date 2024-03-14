<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<?php
$session = $this->session->userdata();

$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();

?>
<!--CONTAINER -->
<div class="content-wrapper" style="display: contents;">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1><?= $judul ?></h1> -->
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
          <!-- FILTER -->
          <!-- Memorandum -->
          <div class="card">
            <!-- Header -->
            <div class="card-header bg-primary">
              <h3 class="card-title">Detail Surat</h3>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body row">
              <div class="col-12">
                <div class="row">
                  <table border="0" width="100%" style="border:none" cellspacing="2" cellpadding="2">
                    <tr>
                      <th width="15%">Judul</th>
                      <td width="35%"><?= $sample['transaksi_judul'] ?></td>
                      <th width="15%">Reviewer</th>
                      <td width="35%"><?= $sample['nik_reviewer'] . ' - ' . $sample['nama_reviewer'] . ' - ' . $sample['title_reviewer'] ?></td>
                    </tr>
                    <tr>
                      <th>Kecepatan Tanggap</th>
                      <td><?php switch ($sample['transaksi_kecepatan_tanggap']) {
                        case '1':
                        echo 'Biasa';
                        break;
                        case '2':
                        echo 'Segera';
                        break;
                        case '3':
                        echo 'Sangat Segera';
                        break;
                        default:
                              # code...
                        break;
                      } ?></td>
                      <th>Approver</th>
                      <td><?= $sample['nik_approver'] . ' - ' . $sample['nama_approver'] . ' - ' . $sample['title_approver'] ?></td>
                    </tr>
                    <tr>
                      <th>Kode Klasifikasi</th>
                      <td><?= $sample['klasifikasi_nama'] ?> - <?= $sample['klasifikasi_kode'] ?></td>
                      <th>Drafter</th>
                      <td><?= $sample['nik_reviewer'] . ' - ' . $sample['nama_reviewer'] . ' - ' . $sample['title_reviewer'] ?></td>
                    </tr>
                    <tr>
                      <th>Sifat</th>
                      <td><?php switch ($sample['transaksi_sifat']) {
                        case '1':
                        echo 'Rahasia';
                        break;
                        case '0':
                        echo 'Biasa';
                        break;
                        default:
                              # code...
                        break;
                      } ?></td>
                      <th>Tujuan</th>
                      <td><?= $sample['nik_reviewer'] . ' - ' . $sample['nama_reviewer'] . ' - ' . $sample['title_reviewer'] ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Memorandum -->

          <div class="card">
            <!-- Header -->
            <div class="card-header bg-warning">
              <h3 class="card-title"> Detail Sample</h3>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body">
              <div class="row">
                <table border="0" width="100%" style="border:none" cellspacing="2" cellpadding="2">
                  <tr>
                    <th width="15%">Peminta Jasa</th>
                    <td><?= $sample['peminta_jasa_nama'] ?></td>
                  </tr>
                  <tr>
                    <th>PIC Pengirim Sample</th>
                    <td><?= $sample['nik_pic_pengirim'] . ' - ' . $sample['nama_pic_pengirim'] . ' - ' . $sample['title_pic_pengirim'] ?></td>
                  </tr>
                  <tr>
                    <th>Pic Telepon</th>
                    <td><?= $sample['transaksi_pic_telepon'] ?></td>
                  </tr>
                  <tr>
                    <th>Ext Pengirim Sample</th>
                    <td><?= $sample['transaksi_pic_ext'] ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <!-- </form> -->


          <div class="card">
            <!-- Header -->
            <div class="card-header bg-info">
              <h3 class="card-title"> Detail Item</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <table width="100%" border="1" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:center">
                  <tr style="background-color:gray">
                    <th>No Urut</th>
                    <th>Jenis Sample</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Jumlah Sample</th>
                    <th>Identitas Sample</th>
                    <th>Deskripsi Parameter</th>
                  </tr>
                  <?php foreach ($sample_detail as $key => $detail) : ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td><?= $detail['jenis_nama'] ?></td>
                      <td><?= $detail['sample_pekerjaan_nama'] ?></td>
                      <td><?= $detail['transaksi_detail_jumlah'] ?></td>
                      <td><?= $detail['transaksi_detail_identitas'] ?></td>
                      <td><?= $detail['transaksi_detail_deskripsi_parameter'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>

          </div>
          <!-- Modal Disposisi -->
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->
<script>
  window.print();
  window.onfocus = setTimeout(() => {
    window.close()
  }, 2000);
</script>