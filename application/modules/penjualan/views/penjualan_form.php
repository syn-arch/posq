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
                        <a href="<?php echo base_url('penjualan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group <?php if (form_error('id_pelanggan')) echo 'has-error' ?> ">
                                <label for="id_pelanggan">Nama Pelanggan</label>
                                <select class="form-control select2" name="id_pelanggan">
                                    <option>-- Silahkan Pilih --</option>
                                    <?php foreach ($pelanggan as $row) : ?>
                                        <option value="<?php echo $row->id_pelanggan ?>" <?php echo $row->id_pelanggan == $id_pelanggan ? 'selected' : ''  ?>> <?php echo $row->nama_pelanggan ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_pelanggan', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('id_user')) echo 'has-error' ?> ">
                                <label for="id_user">Nama User</label>
                                <select class="form-control select2" name="id_user">
                                    <option>-- Silahkan Pilih --</option>
                                    <?php foreach ($user as $row) : ?>
                                        <option value="<?php echo $row->id_user ?>" <?php echo $row->id_user == $id_user ? 'selected' : ''  ?>> <?php echo $row->nama_user ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_user', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('id_marketplace')) echo 'has-error' ?> ">
                                <label for="id_marketplace">Nama Marketplace</label>
                                <select class="form-control select2" name="id_marketplace">
                                    <option>-- Silahkan Pilih --</option>
                                    <?php foreach ($marketplace as $row) : ?>
                                        <option value="<?php echo $row->id_marketplace ?>" <?php echo $row->id_marketplace == $id_marketplace ? 'selected' : ''  ?>> <?php echo $row->nama_marketplace ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_marketplace', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('id_status')) echo 'has-error' ?> ">
                                <label for="id_status">Nama Status</label>
                                <select class="form-control select2" name="id_status">
                                    <option>-- Silahkan Pilih --</option>
                                    <?php foreach ($status as $row) : ?>
                                        <option value="<?php echo $row->id_status ?>" <?php echo $row->id_status == $id_status ? 'selected' : ''  ?>> <?php echo $row->nama_status ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_status', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('nomor_invoice')) echo 'has-error' ?> ">
                                <label for="nomor_invoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice" id="nomor_invoice" placeholder="Nomor Invoice" value="<?php echo $nomor_invoice; ?>" />
                                <?php echo form_error('nomor_invoice', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('tanggal')) echo 'has-error' ?> ">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" />
                                <?php echo form_error('tanggal', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('sub_total')) echo 'has-error' ?> ">
                                <label for="sub_total">Sub Total</label>
                                <input type="text" class="form-control" name="sub_total" id="sub_total" placeholder="Sub Total" value="<?php echo $sub_total; ?>" />
                                <?php echo form_error('sub_total', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('diskon')) echo 'has-error' ?> ">
                                <label for="diskon">Diskon</label>
                                <input type="text" class="form-control" name="diskon" id="diskon" placeholder="Diskon" value="<?php echo $diskon; ?>" />
                                <?php echo form_error('diskon', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('total')) echo 'has-error' ?> ">
                                <label for="total">Total</label>
                                <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" />
                                <?php echo form_error('total', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('bayar')) echo 'has-error' ?> ">
                                <label for="bayar">Bayar</label>
                                <input type="text" class="form-control" name="bayar" id="bayar" placeholder="Bayar" value="<?php echo $bayar; ?>" />
                                <?php echo form_error('bayar', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('keterangan')) echo 'has-error' ?> ">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                                <?php echo form_error('keterangan', '<small style="color:red">', '</small>') ?>
                            </div>
                            <input type="hidden" name="id_penjualan" value="<?php echo $id_penjualan; ?>" />
                            <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </div>
</div>
