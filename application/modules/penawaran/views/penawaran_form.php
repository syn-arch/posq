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
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group <?php if (form_error('nama_penawaran')) echo 'has-error' ?> ">
                                <label for="nama_penawaran">Nama Penawaran</label>
                                <input type="text" class="form-control" name="nama_penawaran" id="nama_penawaran" placeholder="Nama Penawaran" value="<?php echo $nama_penawaran; ?>" />
                                <?php echo form_error('nama_penawaran', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('produk')) echo 'has-error' ?> ">
                                <label for="produk">Produk</label>
                                <textarea class="form-control" rows="3" name="produk" id="produk" placeholder="Produk"><?php echo $produk; ?></textarea>
                                <?php echo form_error('produk', '<small style="color:red">', '</small>') ?>
                            </div>

                            <?php if ($this->uri->segment('3')) : ?>
                                <div class="form-group">
                                    <a target="_blank" download href="<?php echo base_url('assets/img/penawaran/' . $lampiran) ?>">Download</a>
                                </div>
                                <div class="form-group <?php if (form_error('lampiran')) echo 'has-error' ?> ">
                                    <label for="lampiran">Lampiran</label>
                                    <input type="file" class="form-control" name="lampiran" id="lampiran" placeholder="Lampiran" value="<?php echo $lampiran; ?>" />
                                    <?php echo form_error('lampiran', '<small style="color:red">', '</small>') ?>
                                </div>
                            <?php else : ?>
                                <div class="form-group <?php if (form_error('lampiran')) echo 'has-error' ?> ">
                                    <label for="lampiran">Lampiran</label>
                                    <input required type="file" class="form-control" name="lampiran" id="lampiran" placeholder="Lampiran" value="<?php echo $lampiran; ?>" />
                                    <?php echo form_error('lampiran', '<small style="color:red">', '</small>') ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group <?php if (form_error('keterangan')) echo 'has-error' ?> ">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                                <?php echo form_error('keterangan', '<small style="color:red">', '</small>') ?>
                            </div>
                            <?php if ($judul == 'Ubah Penawaran') : ?>
                                <div class="form-group <?php if (form_error('status')) echo 'has-error' ?> ">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option <?= $status == 'Penawaran Baru' ? 'selected' : '' ?> value="Penawaran Baru">Penawaran Baru</option>
                                        <option <?= $status == 'Follow Up' ? 'selected' : '' ?> value="Follow Up">Follow Up</option>
                                        <option <?= $status == 'Deal' ? 'selected' : '' ?> value="Deal">Deal</option>
                                    </select>
                                    <?php echo form_error('status', '<small style="color:red">', '</small>') ?>
                                </div>
                            <?php endif ?>
                            <input type="hidden" name="id_penawaran" value="<?php echo $id_penawaran; ?>" />
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
