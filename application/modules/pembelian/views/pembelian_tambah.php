<style>
    .pembelian-item {
        display: block;
        height: 450px;
        overflow: auto;
    }

    .thead-item,
    .pembelian-item tr {
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
                        <h4 class="box-title">Sales : <?= $this->session->userdata('nama_user') ?></h4>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="input-group input-group">
                            <input autocomplete="off" type="text" name="no_invoice" id="no_invoice" class="form-control" placeholder="No Invoice" value="<?= no_invoice(true) ?>">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <input autocomplete="off" type="text" value="" name="no_pesanan" id="no_pesanan" class="form-control" placeholder="No Pesanan">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" value="" name="nama_pelanggan" id="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan">
                            </div>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" value="" name="alamat" id="alamat" class="form-control" placeholder="Alamat">
                            </div>
                            <div class="col-md-4">
                                <input autocomplete="off" type="text" value="" name="telepon" id="telepon" class="form-control" placeholder="Telepon">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <input autocomplete="off" type="datetime-local" value="<?= date('Y-m-d H:i:s') ?>" name="tanggal" id="tanggal" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group">
                            <select name="id_marketplace" id="id_marketplace" class="form-control">
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
                            <select name="id_status" id="id_status" class="form-control">
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
                                    <th class="text-right" width="20%">Total Harga</th>
                                    <th class="text-right" width="10%"><i class="fa fa-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody class="pembelian-item">
                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tr>
                            <td>Sub Total</td>
                            <td><input type="text" class="form-control sub-total" value="0" name="sub_total" readonly></td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td><input type="text" class="form-control diskon" name="diskon" value="0"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><input type="text" class="form-control total" value="0" name="total" readonly></td>
                        </tr>
                        <tr>
                            <td>Bayar</td>
                            <td><input type="text" class="form-control bayar" placeholder="Bayar" name="bayar" required></td>
                        </tr>
                        <tr>
                            <td>Kembalian</td>
                            <td><input type="text" class="form-control kembalian" value="0" name="kembalian" readonly></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td><textarea name="keterangan" placeholder="Keterangan" id="" cols="30" rows="3" class="form-control"></textarea></td>
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

        function rupiah(angka, rp = false) {
            angka = angka.toString();
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            if (rp == true) {
                return "Rp. " + rupiah;
            } else {
                return rupiah;
            }
        }

        function clean_number(number) {
            return number.replace(/\./g, '')
        }

        function get_subtotal(just_number = false) {
            let sub_total = 0;
            $(document)
                .find(".total-harga")
                .each(function(index, element) {
                    sub_total += parseInt(clean_number($(element).val()));
                });

            const diskon = parseInt(clean_number($('.diskon').val()));

            if (just_number) {
                return sub_total - diskon;
            }

            $('.sub-total').val(rupiah(sub_total));
            $('.total').val(rupiah(sub_total - diskon));
        }

        $(document).on('click', '.tambah-cart', function(e) {
            e.preventDefault();
            const id_produk = $(this).data('id')

            let produk = $(document).find(`tr[data-id="${id_produk}"]`)

            if (produk.length > 0) {
                produk.find('.qty').val(parseInt(produk.find('.qty').val()) + 1)
                total_harga = parseInt(clean_number(produk.find('.harga-jual').text())) * parseInt(produk.find('.qty').val());
                produk.find('.total-harga').val(rupiah(total_harga))

                get_subtotal();
            } else {
                $.get(base_url + 'produk/get_by_id/' + id_produk, function(data) {
                    $('.pembelian-item').append(`
                    <tr data-id="${id_produk}">
                        <input type="hidden" name="id_produk[]" value="${data.id_produk}">
                        <input type="hidden" name="nama_produk[]" value="${data.nama_produk}">
                        <input type="hidden" name="harga_modal[]" value="${data.harga_modal}">
                        <input type="hidden" name="harga_jual[]" value="${data.harga_jual}">
                        <td width="35%">${data.nama_produk}</td>
                        <td width="15%"><input type="number" class="form-control qty" name="qty[]" autocomplete="off" value="1" min="0"></td>
                        <td class="text-right harga-jual">${rupiah(data.harga_jual)}</td>
                        <td class="text-right" width="20%"><input type="text" name="total_harga[]" readonly class="form-control text-right total-harga" value="${rupiah(data.harga_jual)}" ></td>
                        <td class="text-right" width="10%"><a class="btn btn-danger hapus-cart"><i class="fa fa-trash"></i></a></td>
                    </tr>
                `);
                    get_subtotal();
                    $(document).find('.qty').select();
                    $(document).find('.qty').focus();
                });
            }
        });

        $(document).on('keyup change', '.qty', function() {
            const qty = $(this).val();
            const harga = clean_number($(this).closest('tr').find('.harga-jual').text());

            $(this).closest('tr').find('.total-harga').val(rupiah(qty * harga));

            get_subtotal();
        })

        $(document).on('click', '.hapus-cart', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            get_subtotal();
        });

        $('.diskon').keyup(function() {
            $(this).val(rupiah($(this).val()));
            get_subtotal();
        })

        $('.bayar').keyup(function() {
            $(this).val(rupiah($(this).val()));
            const bayar = clean_number($(this).val())

            $('.kembalian').val(rupiah(bayar - get_subtotal(true)))
        })
    })
</script>
