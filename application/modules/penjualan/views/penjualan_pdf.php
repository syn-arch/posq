<!doctype html>
<html>
    <head>
        <title>Penjualan</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Penjualan</h2>
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
            foreach ($penjualan_data as $penjualan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $penjualan->id_pelanggan ?></td>
		      <td><?php echo $penjualan->id_user ?></td>
		      <td><?php echo $penjualan->id_marketplace ?></td>
		      <td><?php echo $penjualan->id_status ?></td>
		      <td><?php echo $penjualan->nomor_invoice ?></td>
		      <td><?php echo $penjualan->tanggal ?></td>
		      <td><?php echo $penjualan->sub_total ?></td>
		      <td><?php echo $penjualan->diskon ?></td>
		      <td><?php echo $penjualan->total ?></td>
		      <td><?php echo $penjualan->bayar ?></td>
		      <td><?php echo $penjualan->keterangan ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>