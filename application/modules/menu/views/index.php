<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo $judul ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="<?php echo base_url('menu/aksi_tambah_menu') ?>" method="post">
                               <div class="form-group <?php if(form_error('nama_menu')) echo 'has-error'?>">
                                   <label for="nama_menu">Nama Menu</label>
                                   <input type="text" id="nama_menu" name="nama_menu" class="form-control nama_menu <?php if(form_error('nama_menu')) echo 'is-invalid'?>" placeholder="Nama Menu" value="<?php echo set_value('nama_menu') ?>">
                                   <?php echo form_error('nama_menu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="icon">Icon</label>
                                   <input autocomplete="off" type="text" id="icon" name="icon" class="form-control iconpicker icon <?php if(form_error('icon')) echo 'is-invalid'?>" placeholder="Icon" value="<?php echo set_value('icon') ?>">
                                   <?php echo form_error('icon', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="menu_utama">Menu Utama?</label>
                                   <select name="menu_utama" id="menu_utama" class="form-control menu_utama">
                                       <option value="1">YA</option>
                                       <option value="0">TIDAK</option>
                                   </select>
                                   <?php echo form_error('menu_utama', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group pilih_menu">
                                   <label for="submenu">Menu Utama</label>
                                   <select name="submenu" id="submenu" class="form-control submenu select2">
                                       <option value="0">-</option>
                                       <?php foreach ($menu_utama as $row): ?>
                                           <option value="<?php echo $row['id_menu'] ?>"><?php echo $row['nama_menu'] ?></option>
                                       <?php endforeach ?>
                                   </select>
                                   <?php echo form_error('submenu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="ada_submenu">Ada Submenu?</label>
                                   <select name="ada_submenu" id="ada_submenu" class="form-control ada_submenu">
                                       <option value="1">YA</option>
                                       <option value="0">TIDAK</option>
                                   </select>
                                   <?php echo form_error('ada_submenu', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group <?php if(form_error('url')) echo 'has-error'?>">
                                   <label for="url">Url</label>
                                   <input type="text" id="url" name="url" class="form-control url <?php if(form_error('url')) echo 'is-invalid'?>" placeholder="Url" value="<?php echo set_value('url') ?>">
                                   <?php echo form_error('url', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <label for="crudable">CRUD ?</label>
                                   <select name="crudable" id="crudable" class="form-control crudable">
                                       <option value="1">YA</option>
                                       <option value="0">TIDAK</option>
                                   </select>
                                   <?php echo form_error('crudable', '<small style="color:red">','</small>') ?>
                               </div>
                               <div class="form-group">
                                   <button type="submit" class="btn btn-primary btn-block">Submit</button>
                               </div>
                           </form>
                       </div>
                       <div class="col-md-1"></div>
                       <div class="col-md-7">
                        <?php $this->db->order_by('urutan', 'asc'); $menu = $this->db->get_where('menu', ['submenu' => 0])->result_array(); ?>
                        <div class="dd" id="nestable3">
                            <ol class="dd-list">   
                                <?php foreach($menu as $row) : ?>
                                    <li class="dd-item dd3-item" data-id="<?= $row['id_menu'] ?>" data-nama="<?php echo $row['nama_menu'] ?>" data-urutan="<?php echo $row['urutan'] ?>">
                                        <div class="dd-handle bg-primary dd3-handle"></div>
                                        <div class="dd3-content noselect">
                                            <div class="pull-left">
                                                <i class="<?= $row['icon'] ?>"></i> <?= $row['nama_menu'] ?>
                                            </div>
                                            <div class="pull-right">
                                                <a href="<?php echo base_url('menu/edit/') . $row['id_menu'] ?>" class="btn btn-warning d-inline"><i class="fa fa-edit"></i></a>
                                                <a data-id="<?php echo $row['id_menu'] ?>" data-href="<?php echo base_url('menu/hapus/') . $row['id_menu'] ?>" class="btn btn-danger d-inline hapus-menu"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <ol class="dd-list">
                                            <?php $this->db->order_by('urutan', 'asc'); $submenu = $this->db->get_where('menu',['submenu' => $row['id_menu']])->result_array(); ?>
                                            <?php foreach($submenu as $row) : ?>
                                                <li class="dd-item dd3-item" data-id="<?= $row['id_menu'] ?>" data-nama="<?php echo $row['nama_menu'] ?>" data-urutan="<?php echo $row['urutan'] ?>"  data-menu-utama="<?php echo $row['submenu'] ?>">
                                                    <div class="dd-handle bg-primary dd3-handle"></div>
                                                    <div class="dd3-content noselect">
                                                        <div class="pull-left">
                                                            <i class="<?= $row['icon'] ?>"></i> <?= $row['nama_menu'] ?>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a href="<?php echo base_url('menu/edit/') . $row['id_menu'] ?>" class="btn btn-warning d-inline"><i class="fa fa-edit"></i></a>
                                                            <a data-id="<?php echo $row['id_menu'] ?>" data-href="<?php echo base_url('menu/hapus/') . $row['id_menu'] ?>" class="btn btn-danger d-inline hapus-menu"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ol>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
