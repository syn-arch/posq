<?php
$this->db->join('role', 'id_role', 'left');
$user = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

$pengaturan = $this->db->get('pengaturan')->row();
if (!$user) {
    $this->session->sess_destroy();
    redirect('login', 'refresh');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="base_url" content="<?php echo base_url() ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $judul ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="icon" href="<?php echo base_url('assets/img/pengaturan/') . $pengaturan->favicon ?>" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('assets/lte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/lte/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/lte/') ?>bower_components/select2/dist/css/select2.min.css">
    <!-- nestable -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/nestable2/dist/jquery.nestable.min.css">
    <!-- icon picker -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/lte/') ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/lte/') ?>dist/css/skins/skin-blue.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dashboard-style.css">

    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/lte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
    <!-- sweetalert -->
    <script src="<?php echo base_url('assets/sweetalert/sweetalert.min.js') ?>"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini <?= $this->uri->segment(1) == 'penjualan' ? 'sidebar-collapse' : '' ?>">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><i class="fa fa-calendar"></i></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b><i class="fa fa-calendar"></i> <?php echo date("d-m-Y") ?></b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <i class="fa fa-user fa-lg"></i>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"><?php echo $user['nama_user'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <?php $gambar_user = $user['gambar'] == '' ? 'default.png' : $user['gambar'] ?>
                                    <img src="<?php echo base_url('assets/img/user/') . $gambar_user ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $user['nama_user'] ?>
                                        <small><?php echo $this->session->userdata('level'); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url('profil') ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN MENU</li>

                    <?php
                    $this->db->select('*');
                    $this->db->where('id_role', $this->session->userdata('id_role'));
                    $this->db->order_by('urutan', 'asc');
                    $this->db->join('menu', 'id_menu');
                    $this->db->join('role', 'id_role');
                    $menu = $this->db->get('akses_role')->result_array();
                    ?>

                    <?php foreach ($menu as $row) : ?>
                        <?php if ($row['ada_submenu'] == 0 && $row['submenu'] == 0) : ?>
                            <li <?php echo $row['nama_menu'] == $judul ? 'class="active"' : '' ?>><a href="<?php echo base_url($row['url']) ?>"><i class="<?php echo $row['icon'] ?>"></i> <span><?php echo $row['nama_menu'] ?></span></a></li>
                        <?php elseif ($row['ada_submenu'] == 1 && $row['submenu'] == 0) : ?>
                            <?php
                            $this->db->where('nama_menu', $judul);
                            $this->db->where('submenu !=', 0);
                            $menu_parent = $this->db->get('menu')->row_array();
                            if ($menu_parent) {
                                $id_menu_parent = $menu_parent['submenu'];
                                $nama_menu_parent = $this->db->get_where('menu', ['id_menu' => $id_menu_parent])->row_array()['nama_menu'];
                            }
                            ?>
                            <li class="treeview 
                <?php
                            if ($menu_parent) {
                                echo $row['nama_menu'] == $nama_menu_parent ? 'active' : '';
                            }
                ?>
                ">
                                <a href="#"><i class="<?php echo $row['icon'] ?>"></i> <span><?php echo $row['nama_menu'] ?></span>
                                    <span class="pull-right-container">
                                        <i class="fas fa-chevron-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php
                                    $this->db->select('*');
                                    $this->db->where('id_role', $this->session->userdata('id_role'));
                                    $this->db->where('submenu', $row['id_menu']);
                                    $this->db->order_by('urutan', 'asc');
                                    $this->db->join('menu', 'id_menu');
                                    $this->db->join('role', 'id_role');
                                    $submenu = $this->db->get('akses_role')->result_array();
                                    ?>
                                    <?php foreach ($submenu as $row_submenu) : ?>
                                        <li <?php echo $row_submenu['nama_menu'] == $judul ? 'class="active"' : '' ?>><a class="<?= $row_submenu['nama_menu'] == "Buka Laci" ? 'buka_laci' : '' ?>" href="<?php echo base_url($row_submenu['url']) ?>"><i class="<?php echo $row_submenu['icon'] ?>"></i> <?php echo $row_submenu['nama_menu'] ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>

                    <li><a href="<?php echo base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>

                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <?php if ($this->uri->segment(1) != 'penjualan') : ?>
                <section class="content-header">
                    <h1>
                        <?php echo $judul ?>
                    </h1>
                </section>
            <?php endif ?>

            <section class="content container-fluid">

                <?php if ($error = $this->session->flashdata('error')) : ?>
                    <span class="alert-error hidden d-error"><?php echo $error ?></span>
                <?php endif ?>
                <?php if ($warning = $this->session->flashdata('warning')) : ?>
                    <span class="alert-warning hidden d-warning"><?php echo $warning ?></span>
                <?php endif ?>
                <?php if ($success = $this->session->flashdata('success')) : ?>
                    <span class="alert-success hidden d-success"><?php echo $success ?></span>
                <?php endif ?>
                <?php if ($message = $this->session->flashdata('message')) : ?>
                    <span class="alert-message hidden d-message"><?php echo $message ?></span>
                <?php endif ?>

                <!-- custom -->
                <script src="<?php echo base_url('assets/js/alert.js') ?>"></script>
