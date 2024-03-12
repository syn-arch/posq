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
                        <a href="<?php echo base_url('user') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group <?php if (form_error('id_user')) echo 'has-error' ?>">
                                <label for="id_user">ID Sales</label>
                                <input readonly="" type="text" id="id_user" name="id_user" class="form-control id_user " placeholder="ID user" value="<?php echo autoID('PTS', 'user') ?>">
                                <?php echo form_error('id_user', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('nama_user')) echo 'has-error' ?>">
                                <label for="nama_user">Nama Sales</label>
                                <input type="text" id="nama_user" name="nama_user" class="form-control nama_user" placeholder="Nama user" value="<?php echo set_value('nama_user') ?>">
                                <?php echo form_error('nama_user', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('jk')) echo 'has-error' ?>">
                                <label for="jk">Jenis Kelamin</label><br>
                                <select name="jk" id="jk" class="form-control">
                                    <option value="">-- Silahkan Pilih Jenis Kelamin --</option>
                                    <option value="L" <?php echo set_value('jk') == "L" ? 'selected' : '' ?>>Laki-Laki</option>
                                    <option value="P" <?php echo set_value('jk') == "P" ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <?php echo form_error('jk', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('alamat')) echo 'has-error' ?>">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control " placeholder="alamat"><?php echo set_value('alamat') ?></textarea>
                                <?php echo form_error('alamat', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('telepon')) echo 'has-error' ?>">
                                <label for="telepon">Telepon</label>
                                <input type="text" id="telepon" name="telepon" class="form-control telepon " placeholder="Telepon" value="<?php echo set_value('telepon') ?>">
                                <?php echo form_error('telepon', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('email')) echo 'has-error' ?>">
                                <label for="E-mail">E-mail</label>
                                <input type="text" id="E-mail" name="email" class="form-control E-mail " placeholder="E-mail" value="<?php echo set_value('email') ?>">
                                <?php echo form_error('E-mail', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('pw1')) echo 'has-error' ?>">
                                <label for="pw1">Password</label>
                                <input type="password" id="pw1" name="pw1" class="form-control pw1 " placeholder="Password" value="<?php echo set_value('pw1') ?>">
                                <?php echo form_error('pw1', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('pw2')) echo 'has-error' ?>">
                                <label for="pw2">Konfirmasi Password</label>
                                <input type="password" id="pw2" name="pw2" class="form-control pw2 " placeholder="Konfirmasi Password" value="<?php echo set_value('pw2') ?>">
                                <?php echo form_error('pw2', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('gambar')) echo 'has-error' ?>">
                                <label for="gambar">Gambar</label>
                                <input type="file" id="gambar" name="gambar" class="form-control gambar " placeholder="Gambar" value="<?php echo set_value('gambar') ?>">
                                <?php echo form_error('gambar', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('id_role')) echo 'has-error' ?>">
                                <label for="id_role">Level</label>
                                <select name="id_role" id="id_role" class="form-control">
                                    <?php foreach ($role as $row) : ?>
                                        <option value="<?php echo $row['id_role'] ?>" <?php echo set_value('id_role') == $row['id_role'] ? 'selected' : '' ?>><?php echo $row['nama_role'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('id_role', '<small style="color:red">', '</small>') ?>
                            </div>
                            <div class="form-group <?php if (form_error('id_marketplace')) echo 'has-error' ?>">
                                <label for="id_marketplace">Marketplace</label>
                                <select name="id_marketplace" id="id_marketplace" class="form-control">
                                    <option value="">-- Silahkan Pilih Marketplace ---</option>
                                    <?php foreach ($marketplace as $row) : ?>
                                        <option value="<?php echo $row['id_marketplace'] ?>"><?php echo $row['nama_marketplace'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('id_marketplace', '<small style="color:red">', '</small>') ?>
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
