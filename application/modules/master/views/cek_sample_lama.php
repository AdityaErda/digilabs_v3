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
										</tr>
									</thead>
								</table>
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
		</div>
	</section>
	<!-- Container Body -->
</div>
<!-- CONTAINER -->