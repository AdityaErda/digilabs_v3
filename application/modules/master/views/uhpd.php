<!-- CONTAINER -->
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
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"><?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <form id="form_tenaga_kerja">
                  <!-- Table -->
                    <table id="table" class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Jabatan</th>
                          <th>UHPD</th>
                          <th>Honorarium</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value): ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <?php if ($value['tenaga_kerja_jabatan'] == '1'): ?>
                              <td>AVP</td>
                            <?php elseif ($value['tenaga_kerja_jabatan'] == '2'): ?>
                              <td>KASI</td>
                            <?php elseif ($value['tenaga_kerja_jabatan'] == '3'): ?>
                              <td>KARU</td>
                            <?php elseif ($value['tenaga_kerja_jabatan'] == '4'): ?>
                              <td>Pelaksana</td>
                            <?php else: ?>
                              <td>-</td>
                            <?php endif ?>
                            <td><input type="number" step="any" id="uhpd_<?= $value['tenaga_kerja_jabatan'] ?>" name="uhpd[<?= $value['tenaga_kerja_id'] ?>]" class="form-control" value="<?= $value['tenaga_kerja_uhpd'] ?>"></td>
                            <td><input type="number" step="any" id="honor_<?= $value['tenaga_kerja_jabatan'] ?>" name="honor[<?= $value['tenaga_kerja_id'] ?>]" class="form-control" value="<?= $value['tenaga_kerja_honorarium'] ?>"></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                    <input type="submit" class="btn btn-success col-12" value="Simpan" name="simpan">
                  <!-- Table -->
                </form>
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->