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
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class=\"box-body\">
             <div class=\"row\">
                    <div class=\"col-md-10\"></div>
                    <div class=\"col-md-2\">
                        <form action=\"<?php echo site_url('$c_url/index'); ?>\" class=\"form-inline\" method=\"get\">
                            <div class=\"input-group\">
                                <input type=\"text\" class=\"form-control\" name=\"q\" value=\"<?php echo \$q; ?>\">
                                <span class=\"input-group-btn\">
                                    <?php
                                    if (\$q <> '') {
                                    ?>
                                        <a href=\"<?php echo site_url('$c_url'); ?>\" class=\"btn btn-default\">Reset</a>
                                    <?php
                                    }
                                    ?>
                                    <button class=\"btn btn-primary\" type=\"submit\">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered table-striped\" width=\"100%\">
                        <tr>
                            <th>No</th>
                            <?php if (\$access['d']): ?>
                                <th><input type=\"checkbox\" name=\"hapus_bulk\" id=\"hapus_bulk\" class=\"check_all\"></th>
                            <?php endif ?>
                            ";
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
$string .= "\n\t\t<th>Action</th>
                                        </tr>";
$string .= "<?php
                                        foreach ($" . $c_url . "_data as \$$c_url)
                                        {
                                            ?>
                                            <tr>";

$string .= "\n\t\t\t
                            <td><?php echo ++\$start ?></td>
                            <?php if (\$access['d']): ?>
                            <td><input type=\"checkbox\" class=\"data_checkbox\" name=\"data[]\" value=\"<?php echo $" . $c_url . "->" . $pk . " ?>\"></td>
                            <?php endif ?>";
foreach ($non_pk as $index => $row) {

    if ($join) {
        if (in_array($row['column_name'], $id_table_join)) {
            $string .= "\n\t\t\t<td><?php echo $" . $c_url . "->nama_" . $table_join[$index] . " ?></td>";
        } else {
            if (isset($_POST['ada_gambar'])) {
                $kolom_gambar = $_POST['kolom_gambar'];
                if ($row['column_name'] == $kolom_gambar) {
                    $string .= "\n\t\t\t<td><img src='<?php echo base_url('assets/img/$table_name/'.$" . $c_url . "->" . $row['column_name'] . ") ?>' width='100'></td>";
                } else {
                    $string .= "\n\t\t\t<td><?php echo $" . $c_url . "->" . $row['column_name'] . " ?></td>";
                }
            } else {
                $string .= "\n\t\t\t<td><?php echo $" . $c_url . "->" . $row['column_name'] . " ?></td>";
            }
        }
    } else {
        if (isset($_POST['ada_gambar'])) {
            $kolom_gambar = $_POST['kolom_gambar'];
            if ($row['column_name'] == $kolom_gambar) {
                $string .= "\n\t\t\t<td><img src='<?php echo base_url('assets/img/$table_name/'.$" . $c_url . "->" . $row['column_name'] . ") ?>' width='100'></td>";
            } else {
                $string .= "\n\t\t\t<td><?php echo $" . $c_url . "->" . $row['column_name'] . " ?></td>";
            }
        } else {
            $string .= "\n\t\t\t<td><?php echo $" . $c_url . "->" . $row['column_name'] . " ?></td>";
        }
    }
}

$string .= "<td>
                                        <a href=\"<?php echo site_url('" . $table_name . "/read/' . $" . $c_url . "->" . $pk . " ) ?>\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a>
                                        <?php if (\$access['u']): ?>
                                        <a href=\"<?php echo site_url('" . $table_name . "/update/' . $" . $c_url . "->" . $pk . " ) ?>\" class=\"btn btn-warning\"><i class=\"fa fa-edit\"></i></a>
                                        <?php endif ?>
                                        <?php if (\$access['d']): ?>
                                        <a data-href=\"<?php echo site_url('" . $table_name . "/delete/' . $" . $c_url . "->" . $pk . " ) ?>\" class=\"btn btn-danger hapus-data\"><i class=\"fa fa-trash\"></i></a>
                                        <?php endif ?>
                                     </td>";
$string .=  "\n\t\t</tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class=\"row\">
                        <div class=\"col-md-6\">
                            <a href=\"#\" class=\"btn btn-primary\">Total Record : <?php echo \$total_rows ?></a>";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}
$string .= "\n\t    
                        </div>
                        <div class=\"col-md-6 text-right\">
                            <?php echo \$pagination ?>
                        </div>
                    </div>
                 
            </div>
        </div>
    </div>
</div>

<script>
    const table_name = '" . $table_name . "';
</script>
";

$hasil_view_list = createFile($string, $target . $module . "/views/" . $v_list_file);
