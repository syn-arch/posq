<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border no-print">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo 'Invoice ' . $nomor_invoice ?></h4>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="box-title">
                        <a href="<?php echo base_url('penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <button onclick="window.print()" class="btn btn-info"><i class="fa fa-print"></i> Cetak</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <table class="table">
                            <tr>
                                <td>Sales</td>
                                <td><?php echo $nama_user; ?></td>
                            </tr>
                            <tr>
                                <td>Marketplace</td>
                                <td><?php echo $nama_marketplace; ?></td>
                            </tr>
                            <tr>
                                <td>No Pesanan</td>
                                <td><?php echo $no_pesanan; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $nama_status; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><?php echo $tanggal; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td><?php echo $nama_pelanggan; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?php echo $alamat; ?></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td><?php echo $telepon; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th class="text-right">Harga Jual</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail_penjualan as $index => $detail) : ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $detail['nama_produk'] ?></td>
                                            <td class="text-right"><?= number_format($detail['harga_jual'], 0, '', '.') ?></td>
                                            <td class="text-right"><?= $detail['qty'] ?></td>
                                            <td class="text-right"><?= number_format($detail['total_harga'], 0, '', '.') ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right">Sub Total</th>
                                        <td class="text-right"><?= number_format($sub_total, 0, '', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $keterangan; ?></td>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right">Diskon</th>
                                        <td class="text-right"><?= number_format($diskon, 0, '', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right">Total</th>
                                        <td class="text-right"><?= number_format($total, 0, '', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right">Bayar</th>
                                        <td class="text-right"><?= number_format($bayar, 0, '', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right">Kembalian</th>
                                        <td class="text-right"><?= number_format($bayar - $total, 0, '', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
