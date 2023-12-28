<!doctype html>
<html>
    <head>
        <title>Marketplace</title>
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
        <h2>Marketplace</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Marketplace</th>
		<th>Gambar</th>
		<th>Link Toko</th>
		
            </tr><?php
            foreach ($marketplace_data as $marketplace)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $marketplace->nama_marketplace ?></td>
		      <td><?php echo $marketplace->gambar ?></td>
		      <td><?php echo $marketplace->link_toko ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>