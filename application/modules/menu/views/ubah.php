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
                    <a href="<?php echo base_url('menu') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="box-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <form action="" method="post">
                              <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu'] ?>">
                               <div class="form-group <?php if(form_error('nama_menu')) echo 'has-error'?>">
                                   <label for="nama_menu">Nama Menu</label>
                                   <input type="text" id="nama_menu" name="nama_menu" class="form-control nama_menu <?php if(form_error('nama_menu')) echo 'is-invalid'?>" placeholder="Nama Menu" value="<?php echo $menu['nama_menu'] ?>">
                                   <?php echo form_error('nama_menu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="icon">Icon</label>
                                   <input autocomplete="off" type="text" id="icon" name="icon" class="form-control iconpicker icon <?php if(form_error('icon')) echo 'is-invalid'?>" placeholder="Icon" value="<?php echo  $menu['icon'] ?>">
                                   <?php echo form_error('icon', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="menu_utama">Menu Utama?</label>
                                   <select name="menu_utama" id="menu_utama" class="form-control menu_utama">
                                       <option value="1" <?php if( $menu['submenu'] == 0 &&  $menu['ada_submenu'] == 0 || $menu['ada_submenu'] != 0) echo 'selected' ?>>YA</option>
                                       <option value="0" <?php if( $menu['submenu'] != 0 &&  $menu['ada_submenu'] == 0) echo 'selected' ?>>TIDAK</option>
                                   </select>
                                   <?php echo form_error('menu_utama', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group pilih_menu">
                                   <label for="submenu">Menu Utama</label>
                                   <select name="submenu" id="submenu" class="form-control submenu">
                                       <option value="0"  <?php echo  $menu['ada_submenu'] == 0 ? 'selected' : '' ?>>-</option>
                                       <?php foreach ($menu_utama as $row): ?>
                                           <option  <?php echo  $menu['submenu'] == $row['id_menu'] ? 'selected' : '' ?> value="<?php echo $row['id_menu'] ?>"><?php echo $row['nama_menu'] ?></option>
                                       <?php endforeach ?>
                                   </select>
                                   <?php echo form_error('submenu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="ada_submenu">Ada Submenu?</label>
                                   <select name="ada_submenu" id="ada_submenu" class="form-control ada_submenu">
                                       <option value="1" <?php echo  $menu['ada_submenu'] == 1 ? 'selected' : '' ?>>YA</option>
                                       <option value="0" <?php echo  $menu['ada_submenu'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                                   </select>
                                   <?php echo form_error('ada_submenu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group <?php if(form_error('url')) echo 'has-error'?>">
                                   <label for="url">Url</label>
                                   <input type="text" id="url" name="url" class="form-control url <?php if(form_error('url')) echo 'is-invalid'?>" placeholder="Url" value="<?php echo  $menu['url'] ?>">
                                   <?php echo form_error('url', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="crudable">CRUD ?</label>
                                   <select name="crudable" id="crudable" class="form-control crudable">
                                       <option value="1" <?php echo  $menu['crudable'] == 1 ? 'selected' : '' ?>>YA</option>
                                       <option value="0" <?php echo  $menu['crudable'] == 0 ? 'selected' : '' ?>>TIDAK</option>
                                   </select>
                                   <?php echo form_error('crudable', '<small style="color:red">','</small>') ?>
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
</div>
