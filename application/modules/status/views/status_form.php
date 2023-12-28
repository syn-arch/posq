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
                        <a href="<?php echo base_url('status') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group <?php if(form_error('nama_status')) echo 'has-error'?> ">
                                            <label for="nama_status">Nama Status</label>
                                            <input type="text" class="form-control" name="nama_status" id="nama_status" placeholder="Nama Status" value="<?php echo $nama_status; ?>" />
                                            <?php echo form_error('nama_status', '<small style="color:red">','</small>') ?>
                                        </div>
	    <div class="form-group <?php if(form_error('warna')) echo 'has-error'?> ">
                                            <label for="warna">Warna</label>
                                            <input type="text" class="form-control" name="warna" id="warna" placeholder="Warna" value="<?php echo $warna; ?>" />
                                            <?php echo form_error('warna', '<small style="color:red">','</small>') ?>
                                        </div>
	    <input type="hidden" name="id_status" value="<?php echo $id_status; ?>" /> 
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