<div class="box box-danger">
    <div class="box-header with-border no-print">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul ?></h4>
        </div>
        <div class="pull-right">
            <?php if (false) : ?>
                <a href="<?= base_url('laporan/cetak_laba_rugi/' . $this->input->get('dari') . '/' . $sampai . '/' . $this->input->get('id_outlet')) ?>" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
            <?php endif ?>

            <?php if ($this->input->get('dari')) : ?>
                <a href="#" onclick="window.print()" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
            <?php endif ?>
            <a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row no-print">
            <div class="col-lg-6">
                <form action="">
                    <div class="form-group">
                        <label for="">Dari Tanggal</label>
                        <input type="date" name="dari" id="dari" class="form-control" value="<?php echo $this->input->get('dari') ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai Tanggal</label>
                        <input type="date" name="sampai" id="dari" class="form-control" value="<?php echo $this->input->get('sampai') ?>">
                    </div>
                    <div class="form-group <?php if (form_error('id_outlet')) echo 'has-error' ?>">
                        <label for="id_outlet">Outlet</label>
                        <select name="id_outlet" id="id_outlet" class="form-control">
                            <option value="">Semua Outlet</option>
                            <?php foreach ($outlet as $row) : ?>
                                <option <?php echo $row['id_outlet'] == $this->input->get('id_outlet') ? 'selected' : '' ?> value="<?php echo $row['id_outlet'] ?>"><?php echo $row['nama_outlet'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php echo form_error('id_outlet', '<small style="color:red">', '</small>') ?>
                    </div>
                    <div class="form-group <?php if (form_error('id_barang')) echo 'has-error' ?>">
                        <label for="id_barang">Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control select2">
                            <option value="">SEMUA</option>
                            <?php foreach ($barang as $row) : ?>
                                <option <?php echo $row['id_barang'] == $this->input->get('id_barang') ? 'selected' : '' ?> value="<?php echo $row['id_barang'] ?>"><?php echo $row['nama_barang'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php echo form_error('id_barang', '<small style="color:red">', '</small>') ?>
                    </div>
                    <div class="form-group <?php if (form_error('tampilkan')) echo 'has-error' ?>">
                        <label for="tampilkan">Tampilkan</label>
                        <select name="tampilkan" id="tampilkan" class="form-control">
                            <option <?php echo $this->input->get('tampilkan') == '1' ? 'selected' : '' ?> value="1">IYA</option>
                            <option <?php echo $this->input->get('tampilkan') == '0' ? 'selected' : '' ?> value="0">TIDAK</option>
                        </select>
                        <?php echo form_error('tampilkan', '<small style="color:red">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <br>
        <?php if ($this->input->get('dari')) : ?>

            <?php if ($this->input->get('tampilkan') == '1') : ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Penjualan</h4>
                        <table class="table table-bordered table-striped table-hover datatable-export">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Pokok</th>
                                    <th>Harga Jual</th>
                                    <th>Profit</th>
                                    <th>Jumlah</th>
                                    <th>Total Beli</th>
                                    <th>Total Harga</th>
                                    <th>Total Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $harga_beli = 0 ?>
                                <?php foreach ($penjualan_list as $row) : ?>
                                    <?php $harga_beli += $row['harga_pokok'] ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['tgl'])) ?></td>
                                        <td><?php echo $row['nama_barang'] ?></td>
                                        <td><?php echo number_format($row['harga_pokok_barang']) ?></td>
                                        <td><?php echo number_format($row['harga_jual']) ?></td>
                                        <td><?php echo number_format($row['harga_jual'] - $row['harga_pokok_barang']) ?></td>
                                        <td><?php echo $row['jumlah'] ?></td>
                                        <td><?php echo number_format($row['harga_pokok_barang'] * $row['jumlah']) ?></td>
                                        <td><?php echo number_format($row['total_harga']) ?></td>
                                        <td><?php echo number_format(($row['harga_jual'] - $row['harga_pokok_barang']) * $row['jumlah']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Pembelian</h4>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembelian_list as $row) : ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['tgl'])) ?></td>
                                        <td><?php echo $row['nama_barang'] ?></td>
                                        <td><?php echo number_format($row['harga_beli']) ?></td>
                                        <td><?php echo $row['jumlah'] ?></td>
                                        <td><?php echo number_format($row['total_harga']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            <?php endif ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordere">
                            <tr>
                                <th width="40%">
                                    <h3>Penjualan</h3>
                                </th>
                            </tr>
                            <tr>
                                <th width="70%">Penjualan Kotor</th>
                                <td><?php echo "Rp. " . number_format($penjualan) ?></td>
                            </tr>
                            <tr>
                                <th>Potongan Penjualan</th>
                                <td><?php echo "Rp. " . number_format($potongan_penjualan) ?></td>
                            </tr>
                            <tr>
                                <th>Diskon Penjualan (%)</th>
                                <td><?php echo number_format($diskon_penjualan) ?></td>
                            </tr>
                            <tr>
                                <th width="70%">Penjualan Bersih</th>
                                <td><?php echo "Rp. " . number_format($penjualan_bersih) ?></td>
                            </tr>
                            <tr>
                                <th width="40%">
                                    <h3>Pembelian</h3>
                                </th>
                            </tr>
                            <tr>
                                <th width="70%">Pembelian Bersih</th>
                                <td><?php echo "Rp. " . number_format($pembelian_bersih) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th width="70%">
                                    <h3>Laba Penjualan</h3>
                                </th>
                                <td>
                                    <h3><?php echo "Rp. " . number_format($penjualan_bersih - $harga_beli) ?></h3>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>
                                    <h3>Macam-macam pendapatan</h3>
                                </th>
                                <td></td>
                            </tr>
                            <?php foreach ($detail_pemasukan as $row) : ?>
                                <tr>
                                    <td><?php echo $row['keterangan_biaya'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <th>Total macam-macam pendapatan</th>
                                <td><?php echo "Rp. " . number_format($pemasukan) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>
                                    <h3>Macam-macam pengeluaran</h3>
                                </th>
                                <td></td>
                            </tr>
                            <?php foreach ($detail_pengeluaran as $row) : ?>
                                <tr>
                                    <td><?php echo $row['keterangan_biaya'] ?></td>
                                    <td><?php echo "Rp. " . number_format($row['total_bayar']) ?></td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <th>Total macam-macam pengeluaran</th>
                                <td><?php echo "Rp. " . number_format($pengeluaran) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>
                                    <h3>Total Keuangan</h3>
                                </th>
                                <td>
                                    <h3><?php echo "Rp. " . number_format($penjualan_bersih - $harga_beli + $pemasukan - $pengeluaran) ?></h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
