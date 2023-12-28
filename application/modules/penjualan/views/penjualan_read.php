
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo $judul ?></h4>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="box-title">
                        <a href="<?php echo base_url('penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                 <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                     <table class="table">
	    <tr><td>Nama Pelanggan</td><td><?php echo $nama_pelanggan; ?></td></tr>
	    <tr><td>Nama User</td><td><?php echo $nama_user; ?></td></tr>
	    <tr><td>Nama Marketplace</td><td><?php echo $nama_marketplace; ?></td></tr>
	    <tr><td>Nama Status</td><td><?php echo $nama_status; ?></td></tr>
	    <tr><td>Nomor Invoice</td><td><?php echo $nomor_invoice; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td>Sub Total</td><td><?php echo $sub_total; ?></td></tr>
	    <tr><td>Diskon</td><td><?php echo $diskon; ?></td></tr>
	    <tr><td>Total</td><td><?php echo $total; ?></td></tr>
	    <tr><td>Bayar</td><td><?php echo $bayar; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>