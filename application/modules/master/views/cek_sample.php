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
								<table id="table" class="table table-bordered table-striped" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama LogSheet</th>
											<th>Update</th>
											<th>Aktif</th>
											<th>Detail</th>
											<th>Import</th>
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
								<!-- Rumus -->
							</div>
						</form>
					</div>

				</div>
				<!-- DIV DETAIL LOGSHEET -->

				<!-- MODAL IMPORT -->
				<div class="modal fade" id="modal_import">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><?= $judul ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form id="form_modal_import">
								<input type="text" id="template_logsheet_id_import" name="template_logsheet_id_import">
								<div class="modal-body">
									<div class="card-body row">
										<div class="col-12">
											<div class="form-group row col-md-12">
												<label class="col-md-4">File</label>
												<div class="input-group col-md-8">
													<input type="file" class="form-control" id="cek_sample_file" name="cek_sample_file">
												</div>
											</div>
											<div class="form-group row col-md-12">
												<label class="col-md-4">Batasan Baris</label>
												<div class="input-group col-md-8">
													<input type="number" name="cek_sample_batas" id="cek_sample_batas" class="form-control" min="1">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer justify-content-between">
									<button type="button" id="close_import" class="btn btn-default" data-dismiss="modal" onclick="fun_close_import()">Close</button>
									<button type="submit" class="btn btn-success" id="simpan">Simpan</button>
									<button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
								</div>
							</form>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>

				<!-- MODAL IMPORT -->



			</div>
		</div>
	</section>
	<!-- Container Body -->
</div>
<!-- CONTAINER -->