<?php $pengaturan = $this->db->get('pengaturan')->row_array(); ?>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $this->db->get('pelanggan')->num_rows() ?></h3>

                <p>Data Pelanggan</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url('pelanggan') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $this->db->get('supplier')->num_rows() ?></h3>

                <p>Data Supplier</p>
            </div>
            <div class="icon">
                <i class="fa fa-folder"></i>
            </div>
            <a href="<?php echo base_url('supplier') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $this->db->get('kategori')->num_rows() ?></h3>

                <p>Data Kategori</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="<?php echo base_url('kategori') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3><?= $this->db->get('produk')->num_rows() ?></h3>

                <p>Data Produk</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="<?php echo base_url('produk') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Hari Ini</span>
                <span class="info-box-number">
                    <?php
                    $this->db->select_sum('total', 'total');
                    $this->db->where('DATE(tanggal)', date('Y-m-d'));
                    $hari_ini =  $this->db->get('penjualan')->row()->total;
                    echo number_format($hari_ini, 0, '', '.');
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Bulan Ini</span>
                <span class="info-box-number">
                    <?php
                    $this->db->select_sum('total', 'total');
                    $this->db->where('MONTH(tanggal)', date('m'));
                    $this->db->where('YEAR(tanggal)', date('Y'));
                    $bulan_ini =  $this->db->get('penjualan')->row()->total;
                    echo number_format($bulan_ini, 0, '', '.');
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Tahun Ini</span>
                <span class="info-box-number">
                    <?php
                    $this->db->select_sum('total', 'total');
                    $this->db->where('YEAR(tanggal)', date('Y'));
                    $tahun_ini =  $this->db->get('penjualan')->row()->total;
                    echo number_format($tahun_ini, 0, '', '.');
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pendapatan</span>
                <span class="info-box-number">
                    <?php
                    $this->db->select_sum('total', 'total');
                    $total =  $this->db->get('penjualan')->row()->total;
                    echo number_format($total, 0, '', '.');
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">Data Stok</h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($produk as $row) : ?>
                                <tr>
                                    <td><?= $no+1 ?></td>
                                    <td><?= $row->nama_produk ?></td>
                                    <td><?= $row->stok ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
