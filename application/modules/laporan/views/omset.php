<div class="box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4 class="box-title"><?php echo $judul ?></h4>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6">
                <form action="">
                    <div class="form-group">
                        <label for="">Dari Tanggal</label>
                        <input type="date" name="dari" id="dari" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai Tanggal</label>
                        <input type="date" name="sampai" id="dari" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <br>
        <?php if ($this->input->get('dari')) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Net Sales</th>
                                    <th>Total Charge</th>
                                    <th>Total Sales</th>
                                    <th>Total Customer</th>
                                    <th>Total Qty</th>
                                    <th>Total Beli</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($omset as $index => $row) : ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $row['tgl_penjualan'] ?></td>
                                        <td><?php echo "Rp. " . number_format($row['net_sales']) ?></td>
                                        <td><?php echo $row['ttl_charge'] ?></td>
                                        <td><?php echo "Rp. " . number_format($row['ttl_sales']) ?></td>
                                        <td><?php echo $row['ttl_customer'] ?></td>
                                        <td><?php echo $qty[$index]['ttl_qty'] ?></td>
                                        <td><?php echo $qty[$index]['ttl_beli'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
