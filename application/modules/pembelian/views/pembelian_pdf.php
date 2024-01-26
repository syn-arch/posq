<!doctype html>
<html>

<head>
    <title>pembelian</title>
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
    <h2>pembelian</h2>
    <table class="word-table" style="margin-bottom: 10px">
        <tr>
            <th>No</th>
            <th>Id Pelanggan</th>
            <th>Id User</th>
            <th>Id Marketplace</th>
            <th>Id Status</th>
            <th>Nomor Invoice</th>
            <th>Tanggal</th>
            <th>Sub Total</th>
            <th>Diskon</th>
            <th>Total</th>
            <th>Bayar</th>
            <th>Keterangan</th>

        </tr><?php
                foreach ($pembelian_data as $pembelian) {
                ?>
            <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $pembelian->id_pelanggan ?></td>
                <td><?php echo $pembelian->id_user ?></td>
                <td><?php echo $pembelian->id_marketplace ?></td>
                <td><?php echo $pembelian->id_status ?></td>
                <td><?php echo $pembelian->nomor_invoice ?></td>
                <td><?php echo $pembelian->tanggal ?></td>
                <td><?php echo $pembelian->sub_total ?></td>
                <td><?php echo $pembelian->diskon ?></td>
                <td><?php echo $pembelian->total ?></td>
                <td><?php echo $pembelian->bayar ?></td>
                <td><?php echo $pembelian->keterangan ?></td>
            </tr>
        <?php
                }
        ?>
    </table>
</body>

</html>
