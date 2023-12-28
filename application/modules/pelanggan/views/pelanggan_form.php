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
                        <a href="<?php echo base_url('pelanggan') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group <?php if(form_error('nama_pelanggan')) echo 'has-error'?> ">
                                            <label for="nama_pelanggan">Nama Pelanggan</label>
                                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $nama_pelanggan; ?>" />
                                            <?php echo form_error('nama_pelanggan', '<small style="color:red">','</small>') ?>
                                        </div>
	    <div class="form-group <?php if(form_error('alamat')) echo 'has-error'?> ">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
                                            <?php echo form_error('alamat', '<small style="color:red">','</small>') ?>
                                        </div>
	    <div class="form-group <?php if(form_error('no_telepon')) echo 'has-error'?> ">
                                            <label for="no_telepon">No Telepon</label>
                                            <input type="text" class="form-control" name="no_telepon" id="no_telepon" placeholder="No Telepon" value="<?php echo $no_telepon; ?>" />
                                            <?php echo form_error('no_telepon', '<small style="color:red">','</small>') ?>
                                        </div>
	    <div class="form-group <?php if(form_error('email')) echo 'has-error'?> ">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                                            <?php echo form_error('email', '<small style="color:red">','</small>') ?>
                                        </div>
	    <input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>" /> 
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