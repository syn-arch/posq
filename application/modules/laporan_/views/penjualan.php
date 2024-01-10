<div class="row no-print">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo $judul ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="">
                            <div class="form-group">
                                <label for="">Dari</label>
                                <input value="<?= $this->input->get('dari') ?>" type="date" class="form-control" name="dari">
                            </div>
                            <div class="form-group">
                                <label for="">Dari</label>
                                <input value="<?= $this->input->get('sampai') ?>" type="date" class="form-control" name="sampai">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($this->input->get('dari')) : ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border no-print">
                    <div class="pull-left">
                        <div class="box-title">
                            <h4><?php echo $judul ?></h4>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="#mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th class="text-right">Harga Modal</th>
                                    <th class="text-right">Harga Jual</th>
                                    <th class="text-right">Laba</th>
                                    <th class="text-right">Terjual</th>
                                    <th class="text-right">Total Harga Modal</th>
                                    <th class="text-right">Total Harga Jual</th>
                                    <th class="text-right">Total Laba</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_terjual = 0;
                                $total_jual = 0;
                                $total_laba = 0;
                                ?>
                                <?php foreach ($laporan as $index => $row) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $row['nama_produk'] ?></td>
                                        <td class="text-right"><?= number_format($row['harga_modal'], 0, '', '.') ?></td>
                                        <td class="text-right"><?= number_format($row['harga_jual'], 0, '', '.') ?></td>
                                        <td class="text-right"><?= number_format($row['harga_jual'] - $row['harga_modal'], 0, '', '.') ?></td>
                                        <td class="text-right"><?= $row['terjual'] ?></td>
                                        <td class="text-right"><?= number_format($row['harga_modal'] * $row['terjual'], 0, '', '.') ?></td>
                                        <td class="text-right"><?= number_format($row['harga_jual'] * $row['terjual'], 0, '', '.') ?></td>
                                        <td class="text-right"><?= number_format(($row['harga_jual'] - $row['harga_modal']) * $row['terjual'], 0, '', '.') ?></td>
                                    </tr>
                                    <?php
                                    $total_jual += $row['harga_jual'] * $row['terjual'];
                                    $total_laba += ($row['harga_jual'] - $row['harga_modal']) * $row['terjual'];
                                    ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><?= number_format($total_jual, 0, '', '.') ?></td>
                                    <td class="text-right"><?= number_format($total_laba, 0, '', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
