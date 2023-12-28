<!doctype html>
<html>
    <head>
        <title>Pelanggan</title>
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
        <h2>Pelanggan</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Pelanggan</th>
		<th>Alamat</th>
		<th>No Telepon</th>
		<th>Email</th>
		
            </tr><?php
            foreach ($pelanggan_data as $pelanggan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pelanggan->nama_pelanggan ?></td>
		      <td><?php echo $pelanggan->alamat ?></td>
		      <td><?php echo $pelanggan->no_telepon ?></td>
		      <td><?php echo $pelanggan->email ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>