<!doctype html>
<html>

<head>
    <title>Produk</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" />
    <style>
        .word-table {
            border: 1px solid black !important;
            border-collapse: collapse !important;
            width: 100%;
        }

        .word-table tr th,
        .word-table tr td {
            border: 1px solid black !important;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <h2>Produk</h2>
    <table class="word-table" style="margin-bottom: 10px">
        <tr>
            <th>No</th>
            <th>Id Kategori</th>
            <th>Nama Produk</th>
            <th>SKU</th>
            <th>Satuan</th>
            <th>Harga Modal</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Keterangan</th>

        </tr><?php
                foreach ($produk_data as $produk) {
                ?>
            <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $produk->id_kategori ?></td>
                <td><?php echo $produk->nama_produk ?></td>
                <td><?php echo $produk->sku ?></td>
                <td><?php echo $produk->satuan ?></td>
                <td><?php echo $produk->harga_modal ?></td>
                <td><?php echo $produk->harga_jual ?></td>
                <td><?php echo $produk->stok ?></td>
                <td><?php echo $produk->gambar ?></td>
                <td><?php echo $produk->keterangan ?></td>
            </tr>
        <?php
                }
        ?>
    </table>
</body>

</html>
