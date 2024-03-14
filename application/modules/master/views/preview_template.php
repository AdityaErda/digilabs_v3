<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 -->
<style type="text/css">
    .dataTables_scrollHead {
        overflow: auto !important;
    }
</style>

<!-- CONTAINER -->
<!-- <div class="content-wrapper"> -->
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
                            <label class="float-right">&nbsp;</label>
                        </div>&nbsp;
                        <!-- Header -->
                        <!-- Body -->
                        <div class="card-body">
                            <!-- Table -->
                            <div class="row">
                                <?php foreach ($template_detail as $key_td => $val_td) :  ?>
                                    <?php $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
                                    ?>
                                    <div class="card-header col-12">
                                        <h3 class="card-title">
                                            <?= $val_td['rumus_nama'] ?> =
                                            <strong>
                                                <?php foreach ($list_rumus as $lr) {
                                                    echo ($lr['rumus_detail_nama'] != null) ? $lr['rumus_detail_nama'] : $lr['rumus_detail_input'];
                                                } ?>
                                            </strong>
                                        </h3>
                                        <br />
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group col-12 row">
                                            <table id="<?= $val_td['rumus_id'] ?>_" class="table table-bordered table-striped datatables" width="100%">
                                                <?php $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id'])); ?>
                                                <thead id="header_<?= $val_td['rumus_id'] ?>_">
                                                    <tr>
                                                        <th>No</th>
                                                        <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                                                            <th><?= $val_dr['rumus_detail_nama']; ?></th>
                                                        <?php endforeach; ?>
                                                        <th>Metoda</th>
                                                        <th>Satuan</th>
                                                        <th>Hasil</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="body_<?= $val_td['rumus_id'] ?>_">
                                                    <tr>
                                                        <td>
                                                            1
                                                            <input type="text" name="logsheet_detail_urut[][]" id="logsheet_detail_urut" value="1" style="display:none">
                                                            <input type="text" value="1" name="logsheet_detail_urut_baris[][]" id="logsheet_detail_urut_baris" style="display:none">'
                                                        </td>
                                                        <?php foreach ($detail_rumus as $key_dr => $val_dr) :

                                                        ?>
                                                            <?php
                                                            if ($val_dr['rumus_detail_input'] != null) {
                                                            ?>
                                                                <td>
                                                                    <input type="text" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>" name="rumus_detail_isi[][<?= $val_td['rumus_id'] ?>][]" class="form-control" value="<?= $val_dr['rumus_detail_input'] ?>" readonly>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td>
                                                                    <input type="number" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>" name="rumus_detail_isi[][<?= $val_td['rumus_id'] ?>][]" class="form-control">
                                                                </td>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                        <td>
                                                            <input type="text" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>" name="rumus_detail_isi[][<?= $val_td['rumus_id'] ?>][]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>" name="rumus_detail_isi[][<?= $val_td['rumus_id'] ?>][]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control hasil_<?= $val_td['rumus_id'] ?>" id="hasil_<?= $val_td['rumus_id'] ?>" name="hasil_<?= $val_td['rumus_id'] ?>[]  " onclick="fun_hitung(`<?= $val_td['rumus_id'] ?>`);" readonly placeholder="klik u/ hasil">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>


                        </div>

                        <!-- Table -->
                        <!-- Modal -->
                    </div>
                    <!-- Body -->
                </div>
            </div>
        </div>
        <!-- DIV DATA DIRI -->

        <!-- DIV DETAIL LOGSHEET-->
        <div class="col-md-12" id="div_detail" style="display: none;">
            <div class="col-md-12">
                <form id="form_logsheet">
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header bg-warning">
                            <input type="hidden" id="logsheet_id" name="logsheet_id">
                            <input type="hidden" id="id_logsheet_detail" name="id_logsheet_detail">
                            <input type="hidden" id="template_logsheet_id" name="template_logsheet_id">
                            <h3 class="card-title">Template LogSheet <span id="label_nama_logsheet"></span>
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="div_rumus">
                        </div>
                        <div class="card-footer">
                            <button type="button" id="simpan" class="col-2 btn btn-success float-right">Simpan</button>
                        </div>
                        <!-- Rumus -->
                    </div>
                </form>
            </div>

        </div>
        <!-- DIV DETAIL LOGSHEET -->
    </div>
    <!-- </div> -->
</section>
<!-- Container Body -->
</div>
<!-- CONTAINER -->