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
                        <a href="<?php echo base_url('produk') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group <?php if (form_error('id_kategori')) echo 'has-error' ?> ">
                                <label for="id_kategori">Nama Kategori</label>
                                <select class="form-control select2" name="id_kategori">
                                    <option>-- Silahkan Pilih --</option>
                                    <?php foreach ($kategori as $row) : ?>
                                        <option value="<?php echo $row->id_kategori ?>" <?php echo $row->id_kategori == $id_kategori ? 'selected' : ''  ?>> <?php echo $row->nama_kategori ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_kategori', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('nama_produk')) echo 'has-error' ?> ">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
                                <?php echo form_error('nama_produk', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('satuan')) echo 'has-error' ?> ">
                                <label for="satuan">Satuan</label>
                                <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" />
                                <?php echo form_error('satuan', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('harga_modal')) echo 'has-error' ?> ">
                                <label for="harga_modal">Harga Modal</label>
                                <input type="text" class="form-control" name="harga_modal" id="harga_modal" placeholder="Harga Modal" value="<?php echo $harga_modal; ?>" />
                                <?php echo form_error('harga_modal', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('harga_jual')) echo 'has-error' ?> ">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga Jual" value="<?php echo $harga_jual; ?>" />
                                <?php echo form_error('harga_jual', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('stok')) echo 'has-error' ?> ">
                                <label for="stok">Stok</label>
                                <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" />
                                <?php echo form_error('stok', '<small style="color:red">', '</small>') ?>
                            </div>

                            <?php if ($this->uri->segment('3')) : ?>
                                <div class="form-group">
                                    <img class="img-responsive" src="<?php echo base_url('assets/img/produk/') . $gambar ?>">
                                </div>
                                <div class="form-group <?php if (form_error('gambar')) echo 'has-error' ?> ">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" value="<?php echo $gambar; ?>" />
                                    <?php echo form_error('gambar', '<small style="color:red">', '</small>') ?>
                                </div>
                            <?php else : ?>
                                <div class="form-group <?php if (form_error('gambar')) echo 'has-error' ?> ">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" value="<?php echo $gambar; ?>" />
                                    <?php echo form_error('gambar', '<small style="color:red">', '</small>') ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group <?php if (form_error('keterangan')) echo 'has-error' ?> ">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                                <?php echo form_error('keterangan', '<small style="color:red">', '</small>') ?>
                            </div>
                            <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
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
