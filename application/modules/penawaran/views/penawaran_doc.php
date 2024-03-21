<!doctype html>
<html>
    <head>
        <title>Penawaran</title>
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
        <h2>Penawaran</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Penawaran</th>
		<th>Produk</th>
		<th>Lampiran</th>
		<th>Keterangan</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($penawaran_data as $penawaran)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $penawaran->nama_penawaran ?></td>
		      <td><?php echo $penawaran->produk ?></td>
		      <td><?php echo $penawaran->lampiran ?></td>
		      <td><?php echo $penawaran->keterangan ?></td>
		      <td><?php echo $penawaran->status ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>