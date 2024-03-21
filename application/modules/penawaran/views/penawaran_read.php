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
                        <a href="<?php echo base_url('penawaran') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="table">
                            <tr>
                                <td>Nama Penawaran</td>
                                <td><?php echo $nama_penawaran; ?></td>
                            </tr>
                            <tr>
                                <td>Produk</td>
                                <td><?php echo $produk; ?></td>
                            </tr>
                            <tr>
                                <td>Lampiran</td>
                                <td><a target="_blank" download href="<?php echo base_url('assets/img/penawaran/' . $lampiran) ?>">Download</a></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><?php echo $keterangan; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $status; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
