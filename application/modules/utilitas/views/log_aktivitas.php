<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Tabel</th>
                                <th>Aksi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($log_aktivitas as $row) : ?>
                               <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row['tgl'] ?></td>
                                <td><?= $row['nama_user'] ?></td>
                                <td><?= $row['tablename'] ?></td>
                                <td><?= $row['aksi'] ?></td>
                                <td><?= $row['keterangan'] ?></td>
                               </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
