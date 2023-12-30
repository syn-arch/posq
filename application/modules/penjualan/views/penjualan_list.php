<?php

$menu = $this->uri->segment(1);
$id_menu = $this->db->get_where('menu', ['url' => $menu])->row_array()['id_menu'];
$id_role = $this->session->userdata('id_role');

$this->db->select('c, u ,d');
$this->db->where('id_menu', $id_menu);
$this->db->where('id_role', $id_role);
$access = $this->db->get('akses_role')->row_array();

?>

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
                        <?php if ($access['d']) : ?>
                            <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk"><i class="fa fa-trash"></i> Hapus Terpilih</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <form action="<?php echo site_url('penjualan/index'); ?>" class="form-inline" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <span class="input-group-btn">
                                    <?php
                                    if ($q <> '') {
                                    ?>
                                        <a href="<?php echo site_url('penjualan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                    }
                                    ?>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                        <tr>
                            <th>No</th>
                            <?php if ($access['d']) : ?>
                                <th><input type="checkbox" name="hapus_bulk" id="hapus_bulk" class="check_all"></th>
                            <?php endif ?>
                            <th>Pelanggan</th>
                            <th>Sales</th>
                            <th>Marketplace</th>
                            <th>Status</th>
                            <th>Nomor Invoice</th>
                            <th>Tanggal</th>
                            <th>Sub Total</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr><?php
                                foreach ($penjualan_data as $penjualan) {
                                ?>
                            <tr>

                                <td><?php echo ++$start ?></td>
                                <?php if ($access['d']) : ?>
                                    <td><input type="checkbox" class="data_checkbox" name="data[]" value="<?php echo $penjualan->id_penjualan ?>"></td>
                                <?php endif ?>
                                <td><?php echo $penjualan->nama_pelanggan ?></td>
                                <td><?php echo $penjualan->nama_user ?></td>
                                <td><?php echo $penjualan->nama_marketplace ?></td>
                                <td><?php echo $penjualan->nama_status ?></td>
                                <td><?php echo $penjualan->nomor_invoice ?></td>
                                <td><?php echo $penjualan->tanggal ?></td>
                                <td><?php echo number_format($penjualan->sub_total, 0, '', '.') ?></td>
                                <td><?php echo number_format($penjualan->diskon, 0, '', '.') ?></td>
                                <td><?php echo number_format($penjualan->total, 0, '', '.') ?></td>
                                <td><?php echo number_format($penjualan->bayar, 0, '', '.') ?></td>
                                <td><?php echo $penjualan->keterangan ?></td>
                                <td>
                                    <a href="<?php echo site_url('penjualan/read/' . $penjualan->id_penjualan) ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    <?php if ($access['u']) : ?>
                                        <a href="<?php echo site_url('penjualan/update/' . $penjualan->id_penjualan) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <?php endif ?>
                                    <?php if ($access['d']) : ?>
                                        <a data-href="<?php echo site_url('penjualan/delete/' . $penjualan->id_penjualan) ?>" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php
                                }
                        ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                        <?php echo anchor(site_url('penjualan/excel'), 'Excel', 'class="btn btn-primary"'); ?>
                        <?php echo anchor(site_url('penjualan/pdf'), 'PDF', 'class="btn btn-primary"'); ?>

                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const table_name = 'penjualan';
</script>
