<div class="box box-primary">
	<div class="box-header with-border">
		<div class="pull-left">
			<h4 class="box-title"><?php echo $judul ?></h4>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-lg-6">
				<form action="">
					<div class="form-group">
						<label for="">Dari Tanggal</label>
						<input type="date" name="dari" id="dari" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Sampai Tanggal</label>
						<input type="date" name="sampai" id="dari" class="form-control">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<br>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th>Kuantitas</th>
							</tr>
						</thead>
						<tbody>

							<?php $no=1; foreach ($laporan as $row): ?>
							<tr>
								<td><?= $no++ ?></td>
								<td><?= $row['id_produk'] ?></td>
								<td><?= $row['nama_produk'] ?></td>
								<td><?= $row['kuantitas'] ?></td>
							</tr>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
