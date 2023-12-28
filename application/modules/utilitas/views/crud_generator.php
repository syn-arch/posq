<?php
require_once FCPATH . 'harviacode/harviacode.php';
require_once FCPATH . 'harviacode/helper.php';
require_once FCPATH . 'harviacode/process.php';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="box-title">
                        <h4><?php echo $judul ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5">
                        <form method="POST" class="form-crud">

                            <div class="form-group">
                                <label>Pilih Tabel - <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Refresh</a></label>
                                <select id="table_name" name="table_name" class="form-control select2" onchange="setname()">
                                    <option value="">-- Pilih Tabel --</option>
                                    <?php
                                    $table_list = $hc->table_list();
                                    $table_list_selected = isset($_POST['table_name']) ? $_POST['table_name'] : '';
                                    foreach ($table_list as $table) {
                                    ?>
                                        <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <?php $jenis_tabel = isset($_POST['jenis_tabel']) ? $_POST['jenis_tabel'] : 'reguler_table'; ?>
                                    <div class="col-md-5">
                                        <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                            <label>
                                                <input type="radio" name="jenis_tabel" value="reguler_table" <?php echo $jenis_tabel == 'reguler_table' ? 'checked' : ''; ?>>
                                                Reguler Table
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                            <label>
                                                <input type="radio" name="jenis_tabel" value="datatables" <?php echo $jenis_tabel == 'datatables' ? 'checked' : ''; ?>>
                                                Serverside Datatables
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <?php $export_excel = isset($_POST['export_excel']) ? $_POST['export_excel'] : ''; ?>
                                    <label>
                                        <input type="checkbox" name="export_excel" value="1" <?php echo $export_excel == '1' ? 'checked' : '' ?>>
                                        Export Excel
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <?php $export_word = isset($_POST['export_word']) ? $_POST['export_word'] : ''; ?>
                                    <label>
                                        <input type="checkbox" name="export_word" value="1" <?php echo $export_word == '1' ? 'checked' : '' ?>>
                                        Export Word
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <?php $export_pdf = isset($_POST['export_pdf']) ? $_POST['export_pdf'] : ''; ?>
                                    <label>
                                        <input type="checkbox" name="export_pdf" value="1" <?php echo $export_pdf == '1' ? 'checked' : '' ?>>
                                        Export PDF
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <?php $ada_gambar = isset($_POST['ada_gambar']) ? $_POST['ada_gambar'] : ''; ?>
                                    <label>
                                        <input type="checkbox" class="ada_gambar" name="ada_gambar" value="1" <?php echo $ada_gambar == '1' ? 'checked' : '' ?>>
                                        Upload Gambar/File
                                    </label>
                                </div>
                            </div>
                            <div class="form-group kolom_gambar" style="<?php echo isset($_POST['ada_gambar']) ? 'display: block' : 'display: none'; ?>">
                                <label>Kolom Gambar/File</label>
                                <input type="text" id="kolom_gambar" name="kolom_gambar" value="<?php echo isset($_POST['kolom_gambar']) ? $_POST['kolom_gambar'] : '' ?>" class="form-control" placeholder="Kolom gambar / file" />
                            </div>
                            <div class="form-group">
                                <label>Custom Nama Controller</label>
                                <input type="text" id="controller" name="controller" value="<?php echo isset($_POST['controller']) ? $_POST['controller'] : '' ?>" class="form-control" placeholder="Controller Name" />
                            </div>
                            <div class="form-group">
                                <label>Custom Nama Model</label>
                                <input type="text" id="model" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : '' ?>" class="form-control" placeholder="Controller Name" />
                            </div>
                            <div class="form-group mb-5" style="margin-bottom: 50px;">
                                <div class="pull-right">
                                    <span><a href="" class="join_table"><i class="fa fa-plus"></i> Join Tabel</a></span>
                                </div>
                            </div>
                            <div class="list_join_table">
                                <?php if (isset($_POST['table_join'])) : ?>
                                    <?php foreach ($_POST['table_join'] as $index => $row) : ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select name="table_join[]" id="table_join" class="form-control">
                                                        <?php foreach ($this->db->list_tables() as $row) : ?>
                                                            <option value="<?php echo $row ?>" <?php echo $_POST['table_join'][$index] == $row ? 'selected' : '' ?>><?php echo $row ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input required type="text" class="form-control" name="primary_key[]" placeholder="Primary Key" value="<?php echo $_POST['primary_key'][$index] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <input required type="text" class="form-control" name="id_table_join[]" placeholder="Foreign Key" value="<?php echo $_POST['id_table_join'][$index] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="" class="hapus_row">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="PROSES" name="generate" class="btn btn-primary btn-block generate" />
                            </div>
                        </form>
                        <br>

                        <?php
                        foreach ($hasil as $h) {
                            echo '<p>' . $h . '</p>';
                        }
                        ?>
                    </div>
                    <div class="col-md-7">
                        <strong>Catatan *</strong>
                        <ol>
                            <li>Primary key pada tabel harus bertipe integer, auto increment dan diawali dengan id_ (contoh : id_kontak)</li>
                            <li>Pastikan url pada pengelola menu bersifat unik</li>
                            <li>Ketika menggunakan join, pastikan tabel referensi mempunyai kolom yang diawali dengan nama_ (contoh: nama_kontak)</li>
                            <li>Untuk upload gambar, masukan kolom yang akan dijadikan kolom upload gambar / file</li>
                            <li>Url menu dan nama tabel harus sama</li>
                        </ol>
                        <p><strong>&COPY; <a target="_blank" href="http://harviacode.com">harviacode.com</a></strong></p>
                    </div>
                </div>
                <script type="text/javascript">
                    $('.join_table').click(function(e) {
                        e.preventDefault();
                        $.get(base_url + 'utilitas/get_table', function(data) {
                            arr = JSON.parse(data)
                            $('.list_join_table').append(`
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="table_join[]" id="table_join" class="form-control select2">
                                        ${ arr.map(d => `<option value="${d}">${d}</option>` ).join('') }
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input required type="text" class="form-control" name="primary_key[]" placeholder="Primary Key">
                                    </div>
                                    <div class="col-md-3">
                                        <input required type="text" class="form-control" name="id_table_join[]" placeholder="Foreign Key">
                                    </div>
                                    <div class="col-md-2">
                                        <a href="" class="hapus_row">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            `);
                        })
                    });

                    $(document).on('click', '.hapus_row', function(e) {
                        e.preventDefault()
                        $(this).closest('div.form-group').remove()
                    });

                    $('.form-crud').submit(function(e) {
                        e.preventDefault()
                        swal({
                            title: "Apakah anda yakin?",
                            text: "Proses ini akan menimpa file yang telah ada. Lanjutkan?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((submit) => {
                            if (submit) {
                                $(".form-crud").off("submit").submit();
                            }
                        });
                    });

                    $('.ada_gambar').click(function() {
                        if (this.checked) {
                            $(".kolom_gambar").show()
                        } else {
                            $(".kolom_gambar").hide()
                        }
                    });

                    function capitalize(s) {
                        return s && s[0].toUpperCase() + s.slice(1);
                    }

                    function setname() {
                        var table_name = document.getElementById('table_name').value.toLowerCase();
                        if (table_name != '') {
                            document.getElementById('controller').value = capitalize(table_name);
                            document.getElementById('model').value = capitalize(table_name) + '_model';
                        } else {
                            document.getElementById('controller').value = '';
                            document.getElementById('model').value = '';
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
