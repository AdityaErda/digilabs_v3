<style type="text/css">
  .dataTables_scrollHead {
    overflow: auto !important;
  }
</style>

<!-- CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $judul ?> <?= $kurva['kurva_nama'] ?></h1>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Header -->

  <!-- Container Body -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- TABLE -->
        <!-- DIV KURVA -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-warning">
                <h3 class="card-title">Kurva</h3>
              </div>
              <div class="card-body">
                <table id="table_kurva1" class="table table-bordered table-striped" style="width:100%">
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
              </div>
            </div>
          </div>
        </div>
        <!-- DIV KURVA -->
        <!-- TABLE -->

      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->