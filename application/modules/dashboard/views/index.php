<?php $pengaturan = $this->db->get('pengaturan')->row_array(); ?>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>100</h3>

                <p>Data</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url('') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>100</h3>

                <p>Data</p>
            </div>
            <div class="icon">
                <i class="fa fa-folder"></i>
            </div>
            <a href="<?php echo base_url('') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>100</h3>

                <p>Data</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="<?php echo base_url('') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>100</h3>

                <p>Data</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="<?php echo base_url('') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Hari Ini</span>
                <span class="info-box-number">1.500.000.000</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Bulan Ini</span>
                <span class="info-box-number">1.500.000.000</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Tahun Ini</span>
                <span class="info-box-number">1.500.000.000</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">Rp</span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pendapatan</span>
                <span class="info-box-number">1.500.000.000</span>
            </div>
        </div>
    </div>
</div>
