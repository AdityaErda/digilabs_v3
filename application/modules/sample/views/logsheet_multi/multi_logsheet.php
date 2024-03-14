<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<!-- <style type="text/css">
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
</style> -->

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
					<!-- <form id="" method="POST"> -->
					<form id="form_logsheet" method="POST">
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
								<input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?php echo $multisample_group['transaksi_id'] ?>">
								<input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?php echo $multisample_group['transaksi_detail_status'] ?>">
								<input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?php echo $multisample_group['id_transaksi_non_rutin'] ?>">
								<input type="text" style="display: none;" name="header_menu" value="<?= $this->input->get('header_menu') ?>">
								<input type="text" style="display: none;" name="menu_id" value="<?= $this->input->get('menu_id') ?>">
								<input type="text" style="display: none;" name="template_logsheet_id" value="<?= $this->input->get('template_logsheet_id') ?>">
								<input type="text" style="display: none;" name="logsheet_multiple_id" value="<?= $this->input->get('transaksi_detail_group') ?>" id="logsheet_multiple_id">
								<input type="text" style="display: none;" name="transaksi_detail_group" value="<?= $this->input->get('transaksi_detail_group') ?>" id="transaksi_detail_group">
								<input type="text" style="display: none;" name="transaksi_tipe" value="<?= $multisample_group['transaksi_tipe'] ?>" id="transaksi_tipe">

								<!-- deklarasi data awal -->

								<div class="col-12">
									<div class="row">
										<div class="col-6">
											<div class="form-group row col-12">
												<label class="col-md-4">Jenis Sample</label>
												<div class="input-group col-md-8">
													<input type="text" class="form-control" id="logsheet_jenis_id" name="logsheet_jenis_id" placeholder="Judul" value="<?= $multisample_group['jenis_id'] ?>" readonly style="display:none">
													<input type="text" class="form-control" id="logsheet_jenis_sample" name="logsheet_jenis_sample" placeholder="Judul" value="<?= $multisample_group['jenis_nama'] ?>" readonly>
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
											<div class="form-group row col-12">
												<label class="col-md-4">File Excel</label>
												<div class="input-group col-md-8">
													<a href="<?= base_url('dokumen_logsheet/' . $multisample_group['logsheet_file_excel']) ?>" download>Download</a>
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
													<input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima" value="<?= $multisample_group['logsheet_tgl_terima'] ?>">
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
													<input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= $multisample_group['logsheet_tgl_uji'] ?>">
												</div>
											</div>

											<div class="form-group row col-12">
												<label class="col-md-4">Asal Sample</label>
												<div class="input-group col-md-8">
													<input type="text" class="form-control" id="logsheet_asal_sample" name="logsheet_asal_sample" placeholder="Asal Sample" value="<?= $multisample_group['logsheet_asal_sample'] ?>">
												</div>
											</div>
											<div class="form-group row col-12">
												<label class="col-md-4">Pengambilan Sample Oleh</label>
												<div class="input-group col-md-8">
													<select name="logsheet_pengolah_sample" id="logsheet_pengolah_sample" class="form-control select2">
														<?php foreach ($pengolah_sample as $key => $val) : ?>
															<option <?php if ($val['pengambil_sample'] == $multisample_group['logsheet_pengolah_sample']) echo 'selected' ?> value="<?= $val['pengambil_sample'] ?>"><?= $val['pengambil_sample'] ?></option>
														<?php endforeach; ?>
													</select>
													<!-- <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value=""> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Memorandum -->
						<?php foreach ($multi_detail as $key_md => $val_md) : ?>
							<div class="card">
								<!-- Header -->
								<div class="card-header bg-warning">
									<h3 class="card-title"> Detail Sample </h3>
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
														<label class="col-md-4">Nomor Sample</label>
														<div class="input-group col-md-8">
															<input type="text" name="transaksi_detail_id_temp[]" value="<?= $val_md['transaksi_detail_id'] ?>" style="display: none;">
															<input style="display:none;" type="text" name="logsheet_id[]" value="<?= $val_md['logsheet_id'] ?>">
															<input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor[]" placeholder="Nomor Sample" value="<?= $val_md['transaksi_detail_nomor_sample'] ?>" readonly>
														</div>
													</div>
													<div class="form-group row col-12">
														<label class="col-md-4">Identitas</label>
														<div class="input-group col-md-8">
															<input type="text" class="form-control" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Nomor Sample" value="<?= $val_md['transaksi_detail_identitas'] ?>" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row col-12">
														<label class="col-md-4">Deskripsi</label>
														<div class="input-group col-md-8">
															<textarea name="log_deskripsi[]" id="log_deskripsi" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample"><?= $val_md['logsheet_deskripsi'] ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<!-- Rumus -->

											<div class="row">
												<?php foreach ($template_detail as $key_td => $val_td) :  ?>
													<?php $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
													?>
													<?php $logsheet_level_2_group = $this->M_inbox->getLogsheetDetailGroup(array('logsheet_multiple_id' => $val_md['logsheet_multiple_id'], 'logsheet_id' => $val_md['logsheet_id'], 'rumus_id' => $val_td['rumus_id']));
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
													</div>
													<?php foreach ($logsheet_level_2_group as $key_llg2 => $val_llg2) : ?>
														<div class="card-body col-12 row">
															<div class="col-6">
																<div class="form-group row col-12">
																	<label class="col-md-4">Metoda</label>
																	<div class="input-group col-md-8">
																		<input type="text" class="form-control" id="rumus_metoda_<?= $key_td ?>" name="rumus_metoda" readonly value="<?= $val_llg2['rumus_metoda'] ?>">
																	</div>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group row col-12">
																	<label class="col-md-4">Satuan</label>
																	<div class="input-group col-md-8">
																		<input type="text" class="form-control" name="rumus_satuan" id="rumus_satuan_<?= $key_td ?>" readonly value="<?= $val_llg2['rumus_satuan'] ?>">
																	</div>
																</div>
															</div>
														<?php endforeach; ?>
														<div class=" card-body">
															<div class="form-group col-12 row">
																<table class="table table-bordered datatables table-responsive-lg" width="100%">
																	<thead>
																		<tr>
																			<th>No</th>
																			<?php $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id']));
																			foreach ($detail_rumus as $key_dr => $val_dr) : ?>
																				<th><?= $val_dr['rumus_detail_nama']; ?></th>
																			<?php endforeach; ?>
																			<th>Hasil</th>
																		</tr>
																	</thead>
																	<?php $logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('logsheet_multiple_id' => $val_md['logsheet_multiple_id'], 'logsheet_id' => $val_md['logsheet_id'], 'rumus_id' => $val_td['rumus_id']));
																	?>
																	<?php foreach ($logsheet_level_2 as $key_ll2 => $val_ll2) : ?>
																		<tbody>
																			<tr>
																				<td>
																					<?= $key_ll2 + 1 ?>
																				</td>
																				<?php
																				$logsheet_level_3 = $this->M_inbox->getLogsheetDetailDetail(array('logsheet_detail_id' => $val_ll2['logsheet_detail_id']));
																				foreach ($logsheet_level_3 as $key_ll3 => $val_ll3) :
																					$background = '';
																					if ($val_ll3['rumus_jenis'] == 'A') {
																						$background = 'gray';
																					}
																				?>
																					<td style="background-color: <?= $background ?>;">
																						<?= $val_ll3['rumus_detail_isi']; ?>
																					</td>
																				<?php endforeach; ?>
																				<td>
																					<?= $val_ll2['rumus_hasil'] ?>
																				</td>
																			</tr>
																		</tbody>
																	<?php endforeach; ?>
																	<tfoot>
																		<tr>
																			<th colspan="<?= count($logsheet_level_3) + 1; ?>">Rerata</th>
																			<td><?= $logsheet_level_3[0]['rumus_avg'] ?></td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													<?php endforeach ?>
														</div>
														<!-- Rumus -->
														<hr>
											</div>
											<!-- this -->
										</div>
									</div>
									<!-- </form> -->

								<?php endforeach; ?>
								<div class="card-footer">
									<button type="button" id="close" class="btn   btn-custom btn-default border-dark" onclick="kembali_inbox()">Kembali</button>
									<button type="button" id="draft" class="btn   btn-custom btn-warning border-dark">Draft</button>
									<button type="button" id="reupload" class="btn   btn-custom btn-info border-dark">Upload Ulang</button>
									<button type="button" id="simpan" class="btn  btn-custom btn-success float-right">Olah Data</button>
								</div>
								</div>
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