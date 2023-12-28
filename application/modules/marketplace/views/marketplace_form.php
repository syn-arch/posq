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
                        <a href="<?php echo base_url('marketplace') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group <?php if(form_error('nama_marketplace')) echo 'has-error'?> ">
                                                <label for="nama_marketplace">Nama Marketplace</label>
                                                <input type="text" class="form-control" name="nama_marketplace" id="nama_marketplace" placeholder="Nama Marketplace" value="<?php echo $nama_marketplace; ?>" />
                                                <?php echo form_error('nama_marketplace', '<small style="color:red">','</small>') ?>
                                            </div>
	
                                            <?php if($this->uri->segment('3')) : ?>
                                            <div class="form-group">
                                                <img class="img-responsive" src="<?php echo base_url('assets/img/marketplace/') . $gambar ?>">
                                            </div>
                                            <div class="form-group <?php if(form_error('gambar')) echo 'has-error'?> ">
                                                <label for="gambar">Gambar</label>
                                                <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" value="<?php echo $gambar; ?>" />
                                                <?php echo form_error('gambar', '<small style="color:red">','</small>') ?>
                                            </div>
                                            <?php else: ?>
                                            <div class="form-group <?php if(form_error('gambar')) echo 'has-error'?> ">
                                                <label for="gambar">Gambar</label>
                                                <input required type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" value="<?php echo $gambar; ?>" />
                                                <?php echo form_error('gambar', '<small style="color:red">','</small>') ?>
                                            </div>
                                            <?php endif; ?>
                                            
	    <div class="form-group <?php if(form_error('link_toko')) echo 'has-error'?> ">
                                                <label for="link_toko">Link Toko</label>
                                                <input type="text" class="form-control" name="link_toko" id="link_toko" placeholder="Link Toko" value="<?php echo $link_toko; ?>" />
                                                <?php echo form_error('link_toko', '<small style="color:red">','</small>') ?>
                                            </div>
	    <input type="hidden" name="id_marketplace" value="<?php echo $id_marketplace; ?>" /> 
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