<div class="box box-primary">
    <div class="box-header with-border no-print">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul ?></h4>
        </div>
        <div class="pull-right">
            <a href="<?= base_url('laporan/export_persediaan') ?>?dari=<?= $this->input->get('dari') ?>&sampai=<?= $this->input->get('sampai') ?>" class="btn btn-success no-print"><i class="fa fa-sign-out"></i> Export</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row no-print">
            <div class="col-lg-6">
                <form action="">
                    <div class="form-group">
                        <label for="">Dari Tanggal</label>
                        <input type="date" name="dari" id="dari" value="<?= $this->input->get('dari') ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai Tanggal</label>
                        <input type="date" name="sampai" id="sampai" value="<?= $this->input->get('sampai') ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <?php if ($this->input->get('dari')) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No Pesanan</th>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total = 0;
                                foreach ($laporan as $row) : ?>
                                    <?php if (isset($row['id_penjualan'])) : ?>
                                        <?php
                                        $total -= $row['qty'];
                                        ?>
                                        <tr>
                                            <td><?= $row['tanggal'] ?></td>
                                            <td><a href="<?= base_url('penjualan/read/') . $row['id_penjualan'] ?>"><?= $row['nomor_invoice'] ?></a></td>
                                            <td><?= $row['nama_produk'] ?></td>
                                            <td><?= "- " . $row['qty'] ?></td>
                                            <td><?= $total ?></td>
                                        </tr>
                                    <?php else : ?>
                                        <?php
                                        $total += $row['qty'];
                                        ?>
                                        <tr>
                                            <td><?= $row['tanggal'] ?></td>
                                            <td><a href="<?= base_url('pembelian/read/') . $row['id_pembelian'] ?>"><?= $row['nomor_invoice'] ?></a></td>
                                            <td><?= $row['nama_produk'] ?></td>
                                            <td><?= "+ " . $row['qty'] ?></td>
                                            <td><?= $total ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif ?>
            </div>
    </div>
