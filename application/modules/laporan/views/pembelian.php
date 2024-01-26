<div class="box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul ?></h4>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
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
        <?php if ($this->input->get('dari')) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total_pembelian = 0;
                                foreach ($laporan as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['id_produk'] ?></td>
                                        <td><?= $row['nama_produk'] ?></td>
                                        <td><?= "Rp. " . number_format($row['harga_modal']) ?></td>
                                        <td><?= "Rp. " . number_format($row['harga_jual']) ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= "Rp. " . number_format($row['total_harga']) ?></td>
                                    </tr>
                                    <?php $total_pembelian += $row['total_harga'] ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total Pembelian</th>
                                    <th><?= "Rp. " . number_format($total_pembelian) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
