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
                            <div class="card-header">
                                <h3 class="card-title"><?= $judul ?></h3>
                            </div>
                            <!-- Header -->
                            <!-- Body -->
                            <div class="card-body">
                                <form action="<?= base_url('master/rumus_multiple/insertImport'); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-8 row">
                                            <label class="col-md-4">Pilih File Excel</label>
                                            <input class="col-md-8" type="file" name="file_import">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" name="upload" value="Upload" class="btn btn-primary">
                                            <a href="<?= base_url('master/rumus_multiple/insertTable?import_kode=' . $_GET['import_kode']) ?>" class="btn btn-danger">Import</a>
                                            <a href="<?= base_url('master/rumus_multiple/index?header_menu=0&menu_id=0') ?>" class="btn btn-warning">Kembali</a>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('upload/import_perhitungan_sample_multiple.xls') ?>">Sample Excel</a>
                                </form>
                                <br><br>
                                <!-- Table -->
                                <table id="table" class="table table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Jenis sample</th>
                                            <th>Metode</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Table -->
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