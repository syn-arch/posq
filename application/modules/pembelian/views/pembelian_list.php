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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dt" width="100%" id="#mytable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No</th>
                                <?php if ($access['d']) : ?>
                                    <th><input type="checkbox" name="hapus_bulk" id="hapus_bulk" class="check_all"></th>
                                <?php endif ?>
                                <th>Sales</th>
                                <th>Marketplace</th>
                                <th>Status</th>
                                <th>No Invoice</th>
                                <th>No Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Daftar Produk</th>
                                <th>Tanggal</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
                            <select name="id_status" id="id_status_baru" class="form-control">
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
    const table_name = 'pembelian';
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
                        id_status: $('#id_status_baru').val()
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

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }
    
    let up = '<?php echo $access['u'] ?>';
    let del = '<?php echo $access['d'] ?>';

    let dari = '<?php echo $this->input->get('dari') ?>';
    let sampai = '<?php echo $this->input->get('sampai') ?>';
    let id_status = '<?php echo $this->input->get('id_status') ?>';

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
                "url": `pembelian/json?dari=${dari}&sampai=${sampai}&id_status=${id_status}`,
                "type": "POST"
            },
            columns: [{
                    "data": "nama_pelanggan",
                    "visible": false
                },
                {
                    "data": "id_pembelian",
                    "orderable": false
                },
                {
                    "data": "hapus_bulk",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nama_user"
                }, {
                    "data": "nama_marketplace"
                }, {
                    "data": "nama_status"
                }, {
                    "data": "nomor_invoice"
                }, {
                    "data": "no_pesanan"
                }, {
                    "data": "data_pelanggan"
                }, {
                    "data": "data_produk"
                }, {
                    "data": "tanggal"
                }, {
                    "data": "sub_total",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return rupiah(data);
                    }
                }, {
                    "data": "diskon",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return rupiah(data);
                    }
                }, {
                    "data": "total",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return rupiah(data);
                    }
                }, {
                    "data": "bayar",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return rupiah(data);
                    }
                }, {
                    "data": "keterangan"
                }, {
                    "data": "lampiran",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return '<img src="<?php echo base_url('assets/img/pembelian/') ?>' + data + '" width="100">';
                    }
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
                "url": `pembelian/json?dari=${dari}&sampai=${sampai}&id_status=${id_status}`,
                "type": "POST"
            },
            columns: [{
                    "data": "nama_pelanggan",
                    "visible": false
                },
                {
                    "data": "id_pembelian",
                    "orderable": false
                },
                {
                    "data": "nama_user"
                }, {
                    "data": "nama_marketplace"
                }, {
                    "data": "nama_status"
                }, {
                    "data": "nomor_invoice"
                }, {
                    "data": "no_pesanan"
                }, {
                    "data": "data_pelanggan"
                }, {
                    "data": "data_produk"
                }, {
                    "data": "tanggal"
                }, {
                    "data": "sub_total",

                }, {
                    "data": "diskon",

                }, {
                    "data": "total",

                }, {
                    "data": "bayar",

                }, {
                    "data": "keterangan"
                }, {
                    "data": "lampiran",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return '<img src="<?php echo base_url('assets/img/pembelian/') ?>' + data + '" width="100">';
                    }
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
                "url": `pembelian/json?dari=${dari}&sampai=${sampai}&id_status=${id_status}`,
                "type": "POST"
            },
            columns: [{
                    "data": "nama_pelanggan",
                    "visible": false
                },
                {
                    "data": "id_pembelian",
                    "orderable": false
                },
                {
                    "data": "hapus_bulk",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nama_user"
                }, {
                    "data": "nama_marketplace"
                }, {
                    "data": "nama_status"
                }, {
                    "data": "nomor_invoice"
                }, {
                    "data": "no_pesanan"
                }, {
                    "data": "data_pelanggan"
                }, {
                    "data": "data_produk"
                }, {
                    "data": "tanggal"
                }, {
                    "data": "sub_total",

                }, {
                    "data": "diskon",

                }, {
                    "data": "total",

                }, {
                    "data": "bayar",

                }, {
                    "data": "keterangan"
                }, {
                    "data": "lampiran",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return '<img src="<?php echo base_url('assets/img/pembelian/') ?>' + data + '" width="100">';
                    }
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
                "url": `pembelian/json?dari=${dari}&sampai=${sampai}&id_status=${id_status}`,
                "type": "POST"
            },
            columns: [{
                    "data": "nama_pelanggan",
                    "visible": false
                },
                {
                    "data": "id_pembelian",
                    "orderable": false
                },
                {
                    "data": "nama_user"
                }, {
                    "data": "nama_marketplace"
                }, {
                    "data": "nama_status"
                }, {
                    "data": "nomor_invoice"
                }, {
                    "data": "no_pesanan"
                }, {
                    "data": "data_pelanggan"
                }, {
                    "data": "data_produk"
                }, {
                    "data": "tanggal"
                }, {
                    "data": "sub_total",

                }, {
                    "data": "diskon",

                }, {
                    "data": "total",

                }, {
                    "data": "bayar",

                }, {
                    "data": "keterangan"
                }, {
                    "data": "lampiran",
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return '<img src="<?php echo base_url('assets/img/pembelian/') ?>' + data + '" width="100">';
                    }
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
</script>
