<!DOCTYPE html>
<html lang="en">
<style>
  .table {
    width: 100%;
    border: 1px solid #000000;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
</style>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $judul ?></title>
</head>

<body>
  <?php foreach ($rumus as $value) : ?>
    <strong><?php echo ($value['jenis_nama']) ?></strong>
    <table class="table" border="1">
      <thead>
        <tr>
          <th width="35%">Identitas</th>
          <th width="15%">Harga</th>
          <th width="35%">Rumus</th>
          <th width="15%">Harga Rumus</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = $this->db->query("SELECT * FROM sample.sample_identitas WHERE jenis_id = '" . $value['jenis_id'] . "'");
        ?>
        <?php foreach ($sql->result_array() as $values) : ?>
          <tr>
            <td><?= $values['identitas_nama'] ?></td>
            <td><?= $values['identitas_harga'] ?></td>
            <td>(Harga * Jumlah Tenaga Kerja) + Biaya Tambahan</td>
            <td><?= $values['identitas_harga_total'] ?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endforeach; ?>

</body>

</html>

<script>
  window.print();
</script>