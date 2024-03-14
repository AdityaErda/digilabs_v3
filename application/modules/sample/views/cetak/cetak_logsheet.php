<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table border="1" style="width: 100%;border:1px solid black;text-align: left;border-collapse: collapse;">
    <thead>
      <tr>
        <th colspan="4">LEMBAR KERJA <?php echo ($inbox['transaksi_nomor']); ?></th>
      </tr>
      <tr>
        <th>Jenis</th>
        <th><?php echo $inbox_detail[0]['jenis_nama'] ?></th>
        <th>No Lab</th>
        <th><?php echo $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></th>
      </tr>
      <tr>
        <th>Tanda</th>
        <th><?php echo $inbox_detail[0]['transaksi_detail_identitas'] ?></th>
        <th>Tanggal Terima</th>
        <th><?php echo ($logsheet['logsheet_tgl_terima']); ?></th>
      </tr>
      <tr>
        <th>Catatan</th>
        <th><?php echo $inbox_detail[0]['transaksi_detail_catatan'] ?></th>
        <th>Tanggal Sampling</th>
        <th><?php echo ($logsheet['logsheet_tgl_sampling']); ?></th>
      </tr>
      <tr>
        <th>Sertifikat</th>
        <th><?php echo $inbox['transaksi_nomor'] ?></th>
        <th>Jam Sampling</th>
        <th><?php echo ($logsheet['logsheet_jam_sampling']); ?></th>
      </tr>

    </thead>
  </table>
  <br>

  <table border="1" style="width: 100%;border:1px solid black;text-align: left;border-collapse: collapse;">
    <thead>
      <tr>
        <th colspan="4">Detail <?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></th>
      </tr>
      <?php foreach ($logsheet_detail as $detail) : ?>
        <tr>
          <th>Jenis</th>
          <th><?php echo $detail['logsheet_detail_nama'] ?></th>
          <th>Metoda</th>
          <th><?php echo $detail['logsheet_detail_metoda'] ?></th>
        </tr>
        <tr>
          <th>Satuan</th>
          <th><?php echo $detail['logsheet_detail_unit'] ?></th>
          <th>Rumus</th>
          <th>-</th>
        </tr>
    </thead>

    <table border="1" style="width: 100%;border:1px solid black;text-align: left;border-collapse: collapse;">
      <thead>
        <tr>
          <th>No</th>
          <th>Vol Orsat</th>
          <th>Vol Sisa Gas</th>
          <th>Hasil</th>
          <!-- <th>Aksi</th> -->
        </tr>
      </thead>
      <tbody class="tbody" id="tbody">
        <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="<?= $detail['logsheet_detail_urut'] ?>" hidden>
        <input type="text" id="logsheeet_detail_id" name="logsheet_detail_id[0]" value="<?= $detail['logsheet_detail_id'] ?>" class="logsheet_detail_id" hidden>
        <tr class="tr" id="tr">
          <!-- <input type="text" id="logsheet_isi_urut" name="logsheet_isi_urut" value="1"> -->
          <?php foreach ($this->M_inbox->getLogsheetDetailDetail(array('logsheet_detail_id' => $detail['logsheet_detail_id'])) as $key1 => $value1) :  ?>
            <td class="td">
              <input type="text" id="param_urut_1" name="param_urut[0][]" value="<?= $value1['logsheet_detail_detail_isi_urut'] ?>" hidden>
              <!-- <input type="text" class="form-control" id="param_1" name="param_isi[0][]" value="" readonly> -->
              <?= $value1['logsheet_detail_detail_isi'] ?>
            </td>
            <!--                               <td class="td">
          <input type="text" id="param_urut_1" name="param_urut[0][]" value="2">
          <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
        </td>
        <td class="td">
          <input type="text" id="param_urut_1" name="param_urut[0][]" value="3">
          <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
        </td>
        <td class="td">
          <input type="text" id="param_urut_1" name="param_urut[0][]" value="4">
          <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
        </td>-->
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>

  <?php endforeach; ?>

  </thead>
  </table>


  <br>
  <br>

  <table border="1" style="width: 50%;border:1px solid black;text-align: left;border-collapse: collapse;">
    <thead>
      <tr>
        <th>
          Analisis
        </th>
        <th>
          Reviewer
        </th>
      </tr>
      <tr>
        <th height="2cm">
          <?php echo $logsheet['logsheet_analisis'] ?>
        </th>
        <th>
          <?php echo $logsheet['logsheet_analisis'] ?>
        </th>
      </tr>
    </thead>
  </table>
</body>

</html>
<script>
  window.print();
</script>