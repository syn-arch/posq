<!doctype html>
<html>
    <head>
        <title>Status</title>
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
        <h2>Status</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Status</th>
		<th>Warna</th>
		
            </tr><?php
            foreach ($status_data as $status)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $status->nama_status ?></td>
		      <td><?php echo $status->warna ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>