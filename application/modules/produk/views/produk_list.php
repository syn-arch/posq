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
                            <a href="javascrip:void(0)" class="btn btn-danger hapus_bulk"><i class="fa fa-trash"></i> Hapus Terpilih</a>
                        <?php endif ?>
                        <?php if ($access['c']) : ?>
                            <a href="<?php echo base_url('produk/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                        <?php endif ?>
                        <?php echo anchor(site_url('produk/excel'), '<i class="fas fa-sign-out-alt"></i> Excel', 'class="btn btn-success"'); ?>
                        <?php echo anchor(site_url('produk/pdf'), '<i class="fas fa-sign-out-alt"></i> Pdf', 'class="btn btn-danger"'); ?>

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
                                <th>Nama Kategori</th>
                                <th>Nama Produk</th>
                                <th>SKU</th>
                                <th>Satuan</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(number);
            }

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
                var t = $(".dt").DataTable({
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
                        "url": "produk/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_produk",
                            "orderable": false
                        },
                        {
                            "data": "hapus_bulk",
                            "orderable": false,
                            "className": "text-center"
                        },
                        {
                            "data": "nama_kategori"
                        }, {
                            "data": "nama_produk"
                        }, {
                            "data": "sku"
                        }, {
                            "data": "satuan"
                        }, {
                            "data": "harga_modal",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "harga_jual",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "stok"
                        }, {
                            "data": "gambar",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/produk/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
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
                        "url": "produk/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_produk",
                            "orderable": false
                        },
                        {
                            "data": "nama_kategori"
                        }, {
                            "data": "nama_produk"
                        }, {
                            "data": "sku"
                        }, {
                            "data": "satuan"
                        }, {
                            "data": "harga_modal",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "harga_jual",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "stok"
                        }, {
                            "data": "gambar",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/produk/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
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
                        "url": "produk/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_produk",
                            "orderable": false
                        },
                        {
                            "data": "hapus_bulk",
                            "orderable": false,
                            "className": "text-center"
                        },
                        {
                            "data": "nama_kategori"
                        }, {
                            "data": "nama_produk"
                        }, {
                            "data": "sku"
                        }, {
                            "data": "satuan"
                        }, {
                            "data": "harga_modal",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "harga_jual",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "stok"
                        }, {
                            "data": "gambar",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/produk/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
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
                        "url": "produk/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id_produk",
                            "orderable": false
                        },
                        {
                            "data": "nama_kategori"
                        }, {
                            "data": "nama_produk"
                        }, {
                            "data": "sku"
                        }, {
                            "data": "satuan"
                        }, {
                            "data": "harga_modal",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "harga_jual",
                            "render": function(data, type, row, meta) {
                                return rupiah(data)
                            },
                        }, {
                            "data": "stok"
                        }, {
                            "data": "gambar",
                            "render": function(data, type, row, meta) {
                                return '<img src="<?php echo base_url('assets/img/produk/') ?>' + data + '" width="100">';
                            }
                        }, {
                            "data": "keterangan"
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
        const table_name = 'produk';
    </script>
