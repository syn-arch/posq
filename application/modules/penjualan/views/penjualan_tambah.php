<style>
    .penjualan-item {
        display: block;
        height: 250px;
        overflow: auto;
    }

    .thead-item,
    .penjualan-item tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    thead {
        width: calc(100% - 1em)
    }

    table {
        width: 400px;
    }

    .font_small {
        font-size: 14px;
    }
</style>

<form action="" method="POST">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="pull-left">
                        <h4 class="box-title">Invoice : <?= no_invoice() ?></h4>
                        <input type="hidden" name="no_invoice" value="<?= no_invoice() ?>">
                    </div>
                    <div class="pull-right">
                        <h4 class="box-title">Sales : <?= $this->session->userdata('nama_user') ?></h4>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="input-group input-group">
                            <input type="datetime-local" value="<?= date('Y-m-d H:i:s') ?>" name="tanggal" id="tanggal" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <select name="id_pelanggan" id="id_pelanggan" class="form-control select2">
                                <?php foreach ($pelanggan as $row) : ?>
                                    <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-user-check"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <select name="id_marketplace" id="id_marketplace" class="form-control select2">
                                <?php foreach ($marketplace as $row) : ?>
                                    <option value="<?= $row->id_marketplace ?>"><?= $row->nama_marketplace ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-store"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <select name="id_status" id="id_status" class="form-control select2">
                                <?php foreach ($status as $row) : ?>
                                    <option value="<?= $row->id_status ?>"><?= $row->nama_status ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-shapes"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-item">
                                <tr>
                                    <th width="35%">Nama</th>
                                    <th width="15%">Qty</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right" width="20%">Subtotal</th>
                                    <th class="text-right" width="10%"><i class="fa fa-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody class="penjualan-item">

                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tr>
                            <td>Sub Total</td>
                            <td><input type="text" class="form-control sub-total" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td><input type="text" class="form-control diskon" value="0"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><input type="text" class="form-control total" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>Bayar</td>
                            <td><input type="text" class="form-control bayar" placeholder="Bayar" required></td>
                        </tr>
                        <tr>
                            <td>Kembalian</td>
                            <td><input type="text" class="form-control kembalian" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border" style="font-size: 30px;">
                    <div class="pull-left">Sub Total</div>
                    <div class="pull-right">Rp. <span class="sub-total">0</span></div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th width="40%">Nama Produk</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produk as $row) : ?>
                                    <tr>
                                        <td><?= $row->nama_produk ?></td>
                                        <td><?= number_format($row->harga_jual, 0, '', '.') ?></td>
                                        <td><?= $row->stok ?></td>
                                        <td><button class="btn btn-primary tambah-cart" data-id="<?= $row->id_produk ?>"><i class=" fa fa-plus"></i></button></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {

        function rupiah(angka) {
            let rupiah = '';
            let angkarev = angka.split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++) {
                if (i % 3 === 0) {
                    rupiah += angkarev.substr(i, 3) + '.';
                }
            }
            return (
                rupiah
                .split('', rupiah.length - 1)
                .reverse()
                .join('')
            );
        }

        function get_subtotal() {
            let sub_total = 0;

        }

        $(document).on('click', '.tambah-cart', function(e) {
            e.preventDefault();

            const id_produk = $(this).data('id')

            $.get(base_url + 'produk/get_by_id/' + id_produk, function(data) {
                $('.penjualan-item').append(`
                    <tr>
                        <input type="hidden" name="id_produk[]" value="${data.id_produk}">
                        <input type="hidden" name="nama_produk[]" value="${data.nama_produk}">
                        <input type="hidden" name="harga_jual[]" value="${data.harga_jual}">
                        <td width="35%">${data.nama_produk}</td>
                        <td width="15%"><input type="number" class="form-control" name="qty[]" value="1" min="0"></td>
                        <td class="text-right">${rupiah(data.harga_jual)}</td>
                        <td class="text-right" width="20%"><input type="text" readonly class="form-control text-right" value="${rupiah(data.harga_jual)}" ></td>
                        <td class="text-right" width="10%"><button class="btn btn-danger hapus-cart"><i class="fa fa-trash"></i></button></td>
                    </tr>
                `);
            });
        });

        $(document).on('click', '.hapus-cart', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
    })
</script>
