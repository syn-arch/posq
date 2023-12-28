<?php

$string = "
<?php 

\$menu = \$this->uri->segment(1);
\$id_menu = \$this->db->get_where('menu', ['url' => \$menu])->row_array()['id_menu'];
\$id_role = \$this->session->userdata('id_role');

\$this->db->select('c, u ,d');
\$this->db->where('id_menu', \$id_menu);
\$this->db->where('id_role', \$id_role);
\$access = \$this->db->get('akses_role')->row_array();

?>

<div class=\"row\">
    <div class=\"col-xs-12\">
        <div class=\"box box-primary\">
            <div class=\"box-header with-border\">
                <div class=\"pull-left\">
                    <div class=\"box-title\">
                        <h4><?php echo \$judul ?></h4>
                    </div>
                </div>
                <div class=\"pull-right\">
                    <div class=\"box-title\">
                        <?php if (\$access['d']): ?>
                        <a href=\"javascrip:void(0)\" class=\"btn btn-danger hapus_bulk\"><i class=\"fa fa-trash\"></i> Hapus Terpilih</a>
                        <?php endif ?>
                        <?php if (\$access['c']): ?>
                            <a href=\"<?php echo base_url('" . $c_url . "/create') ?>\" class=\"btn btn-primary\"><i class=\"fa fa-plus\"></i> Tambah Data</a>
                        <?php endif ?>";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/excel'), '<i class=\"fas fa-sign-out-alt\"></i> Excel', 'class=\"btn btn-success\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/word'), '<i class=\"fas fa-sign-out-alt\"></i> Word', 'class=\"btn btn-warning\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/pdf'), '<i class=\"fas fa-sign-out-alt\"></i> Pdf', 'class=\"btn btn-danger\"'); ?>";
}
$string .= "\n\t
                    </div>
                </div>
            </div>
            <div class=\"box-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered table-striped dt\" width=\"100%\" id=\"#mytable\">
                       <thead>
                    <tr>
                    <th>No</th>
                    <?php if (\$access['d']): ?>
                    <th><input type=\"checkbox\" name=\"hapus_bulk\" id=\"hapus_bulk\" class=\"check_all\"></th>
                    <?php endif ?>";
foreach ($non_pk as $index => $row) {
    if ($join) {
        if (in_array($row['column_name'], $id_table_join)) {
            $string .= "\n\t\t<th>Nama " . ucfirst($table_join[$index]) . "</th>";
        } else {
            $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
        }
    } else {
        $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
    }
}
$string .= "\n\t\t    
                                <th>Action</th>
                                </tr>
                                </thead>";

$column_non_pk = array();
foreach ($non_pk as $index => $row) {

    if ($join) {
        if (in_array($row['column_name'], $id_table_join)) {
            $column_non_pk[] .= "{\"data\": \"nama_" . $table_join[$index] . "\"}";
        } else {
            if (isset($_POST['ada_gambar'])) {
                $kolom_gambar = $_POST['kolom_gambar'];
                if ($row['column_name'] == $kolom_gambar) {
                    $column_non_pk[] .= "{
                                            \"data\": \"" . $row['column_name'] . "\",
                                            \"render\" : function (data, type, row, meta) {
                                                return '<img src=\"<?php echo base_url('assets/img/$table_name/') ?>'+data+'\" width=\"100\">';
                                            }
                                        }";
                } else {
                    $column_non_pk[] .= "{\"data\": \"" . $row['column_name'] . "\"}";
                }
            } else {
                $column_non_pk[] .= "{\"data\": \"" . $row['column_name'] . "\"}";
            }
        }
    } else {
        if (isset($_POST['ada_gambar'])) {
            $kolom_gambar = $_POST['kolom_gambar'];
            if ($row['column_name'] == $kolom_gambar) {
                $column_non_pk[] .= "{
                                        \"data\": \"" . $row['column_name'] . "\",
                                        \"render\" : function (data, type, row, meta) {
                                            return '<img src=\"<?php echo base_url('assets/img/$table_name/') ?>'+data+'\" width=\"100\">';
                                        }
                                    }";
            } else {
                $column_non_pk[] .= "{\"data\": \"" . $row['column_name'] . "\"}";
            }
        } else {
            $column_non_pk[] .= "{\"data\": \"" . $row['column_name'] . "\"}";
        }
    }
}
$col_non_pk = implode(',', $column_non_pk);

$string .= "\n\t    
                            </table>
                </div>
            </div>
        </div>
    </div>

        <script type=\"text/javascript\">
            $(document).ready(function() {

                let up = '<?php echo \$access['u'] ?>';
                let del = '<?php echo \$access['d'] ?>';

                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
                    return {
                        \"iStart\": oSettings._iDisplayStart,
                        \"iEnd\": oSettings.fnDisplayEnd(),
                        \"iLength\": oSettings._iDisplayLength,
                        \"iTotal\": oSettings.fnRecordsTotal(),
                        \"iFilteredTotal\": oSettings.fnRecordsDisplay(),
                        \"iPage\": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        \"iTotalPages\": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                 if (up == '1' && del == '1') {
                        var t = $(\".dt\").dataTable({
                                initComplete: function() {
                                    var api = this.api();
                                    $('#mytable_filter input')
                                            .off('.DT')
                                            .on('keyup.DT', function(e) {
                                                if (e.keyCode == 13) {
                                                    api.search(this.value).draw();
                                        }
                                    });
                                },
                                oLanguage: {
                                    sProcessing: \"loading...\"
                                },
                                processing: true,
                                serverSide: true,
                                ajax: {\"url\": \"" . $c_url . "/json\", \"type\": \"POST\"},
                                columns: [
                                    {
                                        \"data\": \"$pk\",
                                        \"orderable\": false
                                    },
                                    {
                                        \"data\" : \"hapus_bulk\",
                                        \"orderable\": false,
                                        \"className\" : \"text-center\"
                                    },
                                    " . $col_non_pk . ",
                                    {
                                        \"data\" : \"action\",
                                        \"orderable\": false,
                                        \"className\" : \"text-center\"
                                    }
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);
                                }
                            });
                    }else if( up == '1'){
                        var t = $(\".dt\").dataTable({
                            initComplete: function() {
                                var api = this.api();
                                $('#mytable_filter input')
                                        .off('.DT')
                                        .on('keyup.DT', function(e) {
                                            if (e.keyCode == 13) {
                                                api.search(this.value).draw();
                                    }
                                });
                            },
                            oLanguage: {
                                sProcessing: \"loading...\"
                            },
                            processing: true,
                            serverSide: true,
                            ajax: {\"url\": \"" . $c_url . "/json\", \"type\": \"POST\"},
                            columns: [
                                {
                                    \"data\": \"$pk\",
                                    \"orderable\": false
                                },
                                " . $col_non_pk . ",
                                {
                                    \"data\" : \"action\",
                                    \"orderable\": false,
                                    \"className\" : \"text-center\"
                                }
                            ],
                            order: [[0, 'desc']],
                            rowCallback: function(row, data, iDisplayIndex) {
                                var info = this.fnPagingInfo();
                                var page = info.iPage;
                                var length = info.iLength;
                                var index = page * length + (iDisplayIndex + 1);
                                $('td:eq(0)', row).html(index);
                            }
                        });
                    } else if(del == '1'){
                         var t = $(\".dt\").dataTable({
                            initComplete: function() {
                                var api = this.api();
                                $('#mytable_filter input')
                                        .off('.DT')
                                        .on('keyup.DT', function(e) {
                                            if (e.keyCode == 13) {
                                                api.search(this.value).draw();
                                    }
                                });
                            },
                            oLanguage: {
                                sProcessing: \"loading...\"
                            },
                            processing: true,
                            serverSide: true,
                            ajax: {\"url\": \"" . $c_url . "/json\", \"type\": \"POST\"},
                            columns: [
                                {
                                    \"data\": \"$pk\",
                                    \"orderable\": false
                                },
                                {
                                    \"data\" : \"hapus_bulk\",
                                    \"orderable\": false,
                                    \"className\" : \"text-center\"
                                },
                                " . $col_non_pk . ",
                                {
                                    \"data\" : \"action\",
                                    \"orderable\": false,
                                    \"className\" : \"text-center\"
                                }
                            ],
                            order: [[0, 'desc']],
                            rowCallback: function(row, data, iDisplayIndex) {
                                var info = this.fnPagingInfo();
                                var page = info.iPage;
                                var length = info.iLength;
                                var index = page * length + (iDisplayIndex + 1);
                                $('td:eq(0)', row).html(index);
                            }
                        });
                    }else{
                         var t = $(\".dt\").dataTable({
                            initComplete: function() {
                                var api = this.api();
                                $('#mytable_filter input')
                                        .off('.DT')
                                        .on('keyup.DT', function(e) {
                                            if (e.keyCode == 13) {
                                                api.search(this.value).draw();
                                    }
                                });
                            },
                            oLanguage: {
                                sProcessing: \"loading...\"
                            },
                            processing: true,
                            serverSide: true,
                            ajax: {\"url\": \"" . $c_url . "/json\", \"type\": \"POST\"},
                            columns: [
                                {
                                    \"data\": \"$pk\",
                                    \"orderable\": false
                                },
                                " . $col_non_pk . ",
                                {
                                    \"data\" : \"action\",
                                    \"orderable\": false,
                                    \"className\" : \"text-center\"
                                }
                            ],
                            order: [[0, 'desc']],
                            rowCallback: function(row, data, iDisplayIndex) {
                                var info = this.fnPagingInfo();
                                var page = info.iPage;
                                var length = info.iLength;
                                var index = page * length + (iDisplayIndex + 1);
                                $('td:eq(0)', row).html(index);
                            }
                        });
                    }


            });
                    const table_name = '" . $table_name . "';

        </script>";


$hasil_view_list = createFile($string, $target . $module . "/views/" . $v_list_file);
