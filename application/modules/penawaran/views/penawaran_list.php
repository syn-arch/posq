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
                        <?php if ($access['d']) : ?>
                            <a href="#update-status" data-toggle="modal" class="btn btn-info update_status"><i class="fa fa-check"></i> Update Status</a>
                        <?php endif ?>
                        <?php if ($access['d']) : ?>
                            <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk"><i class="fa fa-trash"></i> Hapus Terpilih</a>
                        <?php endif ?>
                        <?php if ($access['c']) : ?>
                            <a href="<?php echo base_url('penawaran/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                        <?php endif ?>
                        <?php echo anchor(site_url('penawaran/excel'), '<i class="fas fa-sign-out-alt"></i> Excel', 'class="btn btn-success"'); ?>
                        <?php echo anchor(site_url('penawaran/word'), '<i class="fas fa-sign-out-alt"></i> Word', 'class="btn btn-warning"'); ?>
                        <?php echo anchor(site_url('penawaran/pdf'), '<i class="fas fa-sign-out-alt"></i> Pdf', 'class="btn btn-danger"'); ?>

                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dt" width="100%" id="#mytable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <?php if ($access['d']) : ?>
                                    <th><input type="checkbox" name="hapus_bulk" id="hapus_bulk" class="check_all"></th>
                                <?php endif ?>
                                <th>Nama Penawaran</th>
                                <th>Produk</th>
                                <th>Lampiran</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
                                <select name="id_status" id="id_status" class="form-control satatus">
                                    <option value="Penawaran Baru">Penawaran Baru</option>
                                    <option value="Follow Up">Follow Up</option>
                                    <option value="Deal">Deal</option>
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

    <script type="text/javascript">
        $(document).ready(function() {

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
                                id_status: $('.satatus').val()
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

            let up = '<?php echo $access['u'] ?>';
            let del = '<?php echo $access['d'] ?>';

            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };

            if (up == '1' && del == '1') {
                var t = $(".dt").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                                }
                            });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "penawaran/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_penawaran",
                            "orderable": false
                        },
                        {
                            "data": "hapus_bulk",
                            "orderable": false,
                            "className": "text-center"
                        },
                        {
                            "data": "nama_penawaran"
                        }, {
                            "data": "produk"
                        }, {
                            "data": "lampiran",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/penawaran/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
                        }, {
                            "data": "status"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "className": "text-center"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            } else if (up == '1') {
                var t = $(".dt").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                                }
                            });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "penawaran/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_penawaran",
                            "orderable": false
                        },
                        {
                            "data": "nama_penawaran"
                        }, {
                            "data": "produk"
                        }, {
                            "data": "lampiran",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/penawaran/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
                        }, {
                            "data": "status"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "className": "text-center"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            } else if (del == '1') {
                var t = $(".dt").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                                }
                            });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "penawaran/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_penawaran",
                            "orderable": false
                        },
                        {
                            "data": "hapus_bulk",
                            "orderable": false,
                            "className": "text-center"
                        },
                        {
                            "data": "nama_penawaran"
                        }, {
                            "data": "produk"
                        }, {
                            "data": "lampiran",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/penawaran/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
                        }, {
                            "data": "status"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "className": "text-center"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            } else {
                var t = $(".dt").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                                }
                            });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "penawaran/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_penawaran",
                            "orderable": false
                        },
                        {
                            "data": "nama_penawaran"
                        }, {
                            "data": "produk"
                        }, {
                            "data": "lampiran",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/penawaran/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
                        }, {
                            "data": "status"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "className": "text-center"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            }


        });
        const table_name = 'penawaran';
    </script>
