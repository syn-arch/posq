<?php

$menu = $this->uri->segment(1);
$id_menu = $this->db->get_where('menu', ['url' => $menu])->row_array()['id_menu'];
$id_role = $this->session->userdata('id_role');

$this->db->select('c, u ,d');
$this->db->where('id_menu', $id_menu);
$this->db->where('id_role', $id_role);
$access = $this->db->get('akses_role')->row_array();

?>

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
                        <a href="<?php echo base_url('user/export') ?>" class="btn btn-success"><i class="fas fa-sign-out-alt"></i> Export Excel</a>
                        <?php if ($access['c']) : ?>
                            <a href="<?php echo base_url('user/tambah') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table-user">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Sales</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Marketplace</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let up = '<?php echo $access['u'] ?>';
    let del = '<?php echo $access['d'] ?>';
</script>
