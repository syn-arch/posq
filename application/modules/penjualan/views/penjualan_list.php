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
                        <?php if ($access['u']) : ?>
                            <a href="#update-status" data-toggle="modal" class="btn btn-info update_status"><i class="fa fa-check"></i> Update Status</a>
                        <?php endif ?>
                        <?php if ($access['d']) : ?>
                            <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk"><i class="fa fa-trash"></i> Hapus Terpilih</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group">
                                <label for="">Dari</label>
                                <input type="date" class="form-control" name="dari" value="<?= $this->input->get('dari') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sampai</label>
                                <input type="date" class="form-control" name="sampai" value="<?= $this->input->get('sampai') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="id_status" id="id_status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <?php foreach ($data_status as $row) : ?>
                                        <option <?= $this->input->get('id_status') == $row->id_status ? 'selected' : '' ?> value="<?= $row->id_status ?>"><?= $row->nama_status ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <form action="<?php echo site_url('penjualan/index'); ?>" class="form-inline" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <span class="input-group-btn">
                                    <?php
                                    if ($q <> '') {
                                    ?>
                                        <a href="<?php echo site_url('penjualan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                    }
                                    ?>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                        <tr>
                            <th>No</th>
                            <?php if ($access['d']) : ?>
                                <th><input type="checkbox" name="hapus_bulk" id="hapus_bulk" class="check_all"></th>
                            <?php endif ?>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Sales</th>
                            <th>Marketplace</th>
                            <th>Nomor Invoice</th>
                            <th>Nomor Pesanan</th>
                            <th>Daftar Produk</th>
                            <th class="text-right">Sub Total</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach ($penjualan_data as $penjualan) {
                        ?>
                            <?php $status = $this->db->get_where('status',  ['id_status' => $penjualan->id_status])->row(); ?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <?php if ($access['d']) : ?>
                                    <td><input type="checkbox" class="data_checkbox" name="data[]" value="<?php echo $penjualan->id_penjualan ?>"></td>
                                <?php endif ?>
                                <td><?php echo $penjualan->tanggal ?></td>
                                <td><?php echo $penjualan->nama_pelanggan ?></td>
                                <td><?php echo $penjualan->nama_user ?></td>
                                <td><?php echo $penjualan->nama_marketplace ?></td>
                                <td><?php echo $penjualan->nomor_invoice ?></td>
                                <td><?php echo $penjualan->no_pesanan ?></td>
                                <td>
                                    <ul>
                                        <?php
                                        $this->db->where('id_penjualan', $penjualan->id_penjualan);
                                        $produk = $this->db->get('detail_penjualan')->result();
                                        foreach ($produk as $row) :
                                        ?>
                                            <li><?= $row->nama_produk ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </td>
                                <td class="text-right"><?php echo number_format($penjualan->sub_total, 0, '', '.') ?></td>
                                <td><?php echo $penjualan->keterangan ?></td>
                                <td>
                                    <button class="btn btn-<?= $status->warna ?>"><?php echo $penjualan->nama_status ?></button>
                                </td>
                                <td>
                                    <a href=" <?php echo site_url('penjualan/read/' . $penjualan->id_penjualan) ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    <?php if ($access['u']) : ?>
                                        <a href="<?php echo site_url('penjualan/update/' . $penjualan->id_penjualan) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <?php endif ?>
                                    <?php if ($access['d']) : ?>
                                        <a data-href="<?php echo site_url('penjualan/delete/' . $penjualan->id_penjualan) ?>" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                        <?php echo anchor(site_url('penjualan/excel/' . $this->input->get('dari') . '/' . $this->input->get('sampai') . '/' . $this->input->get('id_status') ), 'Excel', 'class="btn btn-primary"'); ?>
                        <?php echo anchor(site_url('penjualan/pdf'), 'PDF', 'class="btn btn-primary"'); ?>

                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLongTitle">Ubah Status</h4>
            </div>
            <div class="modal-body">
                <form class="form-update-status">
                    <div class="form-group">
                        <div class="input-group input-group">
                            <select name="id_status" id="id_status" class="form-control">
                                <?php foreach ($data_status as $row) : ?>
                                    <option value="<?= $row->id_status ?>"><?= $row->nama_status ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-shapes"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>
    const table_name = 'penjualan';
    $(".form-update-status").submit(function(e) {
        e.preventDefault();

        var data = [];

        $(':checkbox:checked').each(function(i) {
            data[i] = $(this).val();
        });

        if (data.length == 0) {
            swal({
                title: "Gagal!",
                text: 'Anda Belum Memilih Data',
                icon: "error"
            })
            return
        }

        swal({
            title: "Apakah anda yakin?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    method: "post",
                    url: base_url + table_name + '/update_bulk',
                    data: {
                        data: data,
                        id_status: $('#id_status').val()
                    },
                    success: function(data) {
                        swal('Berhasil', 'Data berhail diubah', 'success');

                        setTimeout(() => {
                            window.location.href = base_url + table_name
                        }, 1000);
                    }
                })

            }
        });
    })
</script>
