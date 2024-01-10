<div class="box box-danger">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul . ' ' . $this->input->get('dari') . ' - ' . $this->input->get('sampai') ?></h4>
        </div>
        <div class="pull-right">
            <?php if ($this->input->get('dari') && $this->input->get('sampai')) : ?>
                <a target="_blank" href="<?php echo base_url('laporan/cetak_per_barang/' . $golongan . '/' . $this->input->get('dari') . '/' . $this->input->get('sampai') . '/' . $this->input->get('id_outlet')) ?>" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
                <a href="<?php echo base_url('laporan/export_per_barang/' . $golongan . '/' . $this->input->get('dari') . '/' . $this->input->get('sampai') . '/' . $this->input->get('id_outlet')) ?>" class="btn btn-success"><i class="fa fa-sign-in"></i> Export Excel</a>
            <?php endif ?>
            <a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6">
                <form action="">
                    <div class="form-group">
                        <label for="">Dari Tanggal</label>
                        <input type="date" name="dari" id="dari" class="form-control" value="<?php echo $this->input->get('dari') ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai Tanggal</label>
                        <input type="date" name="sampai" id="sampai" class="form-control" value="<?php echo $this->input->get('sampai') ?>">
                    </div>
                    <div class="form-group <?php if (form_error('id_outlet')) echo 'has-error' ?>">
                        <label for="id_outlet">Outlet</label>
                        <select name="id_outlet" id="id_outlet" class="form-control">
                            <option value="">Semua Outlet</option>
                            <?php foreach ($outlet as $row) : ?>
                                <option value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php echo form_error('id_outlet', '<small style="color:red">', '</small>') ?>
                    </div>
                    <div class="form-group <?php if (form_error('golongan')) echo 'has-error' ?>">
                        <label for="golongan">Golongan</label>
                        <select name="golongan" id="golongan" class="form-control">
                            <option <?php echo $this->input->get('golongan') == 'golongan_1' ? 'selected' : '' ?> value="golongan_1">Golongan 1</option>
                            <option <?php echo $this->input->get('golongan') == 'golongan_2' ? 'selected' : '' ?> value="golongan_2">Golongan 2</option>
                            <option <?php echo $this->input->get('golongan') == 'golongan_3' ? 'selected' : '' ?> value="golongan_3">Golongan 3</option>
                            <option <?php echo $this->input->get('golongan') == 'golongan_4' ? 'selected' : '' ?> value="golongan_4">Golongan 4</option>
                        </select>
                        <?php echo form_error('golongan', '<small style="color:red">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <?php if ($this->input->get('dari') && $this->input->get('sampai')) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Barcode</th>
                                    <th>Nama Barang</th>
                                    <th>Terjual</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>Profit</th>
                                    <th class="sum">Total</th>
                                    <th>Laba</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $harga_beli = 0;
                                foreach ($laporan as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['id_barang'] ?></td>
                                        <td><?= $row['barcode'] ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['barang_terjual'] ?></td>
                                        <td><?= number_format($row['harga_pokok']) ?></td>
                                        <td><?= number_format($row['harga_jual']) ?></td>
                                        <td><?= number_format($row['diskon']) ?></td>
                                        <td><?= number_format($row['profit']) ?></td>
                                        <td><?= number_format($row['total']) ?></td>
                                        <td class="laba"><?= number_format($row['laba']) ?></td>
                                    </tr>
                                    <?php $harga_beli += $row['harga_pokok'] ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="box-footer">
        <?php if ($this->input->get('dari') && $this->input->get('sampai')) : ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th>Pendapatan Golongan 1</th>
                            <td><?php echo "Rp. " . number_format($pendapatan_1) ?></td>
                            <th>Laba Golongan 1</th>
                            <td><?php echo "Rp. " . number_format($laba_1) ?></td>
                        </tr>
                        <tr>
                            <th>Pendapatan Golongan 2</th>
                            <td><?php echo "Rp. " . number_format($pendapatan_2) ?></td>
                            <th>Laba Golongan 2</th>
                            <td><?php echo "Rp. " . number_format($laba_2) ?></td>
                        </tr>
                        <tr>
                            <th>Pendapatan Golongan 3</th>
                            <td><?php echo "Rp. " . number_format($pendapatan_3) ?></td>
                            <th>Laba Golongan 3</th>
                            <td><?php echo "Rp. " . number_format($laba_3) ?></td>
                        </tr>
                        <tr>
                            <th>Pendapatan Golongan 4</th>
                            <td><?php echo "Rp. " . number_format($pendapatan_4) ?></td>
                            <th>Laba Golongan 4</th>
                            <td><?php echo "Rp. " . number_format($laba_4) ?></td>
                        </tr>
                        <tr>
                            <th>Potongan Pendapatan</th>
                            <td><?= "Rp. " . number_format($potongan_penjualan) ?></td>
                        </tr>
                        <tr>
                            <th>Diskon Pendapatan (%)</th>
                            <td><?= number_format($diskon_penjualan) ?></td>
                        </tr>
                        <tr>
                            <th>Total Pendapatan Semua Golongan</th>
                            <td><?php echo "Rp. " . number_format($penjualan_bersih) ?></td>
                            <th>Total Laba Semua Golongan</th>
                            <td><?php echo "Rp. " . number_format($penjualan_bersih - $harga_beli) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
