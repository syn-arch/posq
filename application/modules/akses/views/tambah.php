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
                        <a href="<?php echo base_url('user/akses') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
               <div class="row">
                <div class="col-md-2"></div>
                   <div class="col-md-8">
                       <form method="POST" enctype="multipart/form-data">
                        <div class="form-group <?php if(form_error('nama_role')) echo 'has-error'?>">
                          <label for="nama_role">Nama Role</label>
                          <input type="text" id="nama_role" name="nama_role" class="form-control nama_role " placeholder="Nama Role" value="<?php echo set_value('nama_role') ?>">
                          <?php echo form_error('nama_role', '<small style="color:red">','</small>') ?>
                        </div>
                           <div class="form-group">
                               <button type="submit" class="btn btn-primary btn-block">Submit</button>
                           </div>
                       </form>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>
