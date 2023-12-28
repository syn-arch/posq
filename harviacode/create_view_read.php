<?php

$string = "
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
                        <a href=\"<?php echo base_url('" . $c_url . "') ?>\" class=\"btn btn-primary\"><i class=\"fa fa-arrow-left\"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class=\"box-body\">
                 <div class=\"row\">
                    <div class=\"col-md-2\"></div>
                    <div class=\"col-md-8\">
                     <table class=\"table\">";
foreach ($non_pk as $index => $row) {

    if ($join) {
        if (in_array($row['column_name'], $id_table_join)) {
            $string .= "\n\t    <tr><td>Nama " . ucfirst($table_join[$index]) . "</td><td><?php echo \$nama_" . $table_join[$index] . "; ?></td></tr>";
        } else {
            if (isset($_POST['ada_gambar'])) {
                $kolom_gambar = $_POST['kolom_gambar'];
                if ($row['column_name'] == $kolom_gambar) {
                    $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><img class=\"img-responsive\" src='<?php echo base_url('assets/img/$table_name/'.$" . $row['column_name'] . ") ?>'></td></tr>";
                } else {
                    $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><?php echo $" . $row["column_name"] . "; ?></td></tr>";
                }
            } else {
                $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><?php echo $" . $row["column_name"] . "; ?></td></tr>";
            }
        }
    } else {
        if (isset($_POST['ada_gambar'])) {
            $kolom_gambar = $_POST['kolom_gambar'];
            if ($row['column_name'] == $kolom_gambar) {
                $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><img class=\"img-responsive\" src='<?php echo base_url('assets/img/$table_name/'.$" . $row['column_name'] . ") ?>'></td></tr>";
            } else {
                $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><?php echo $" . $row["column_name"] . "; ?></td></tr>";
            }
        } else {
            $string .= "\n\t    <tr><td>" . label($row["column_name"]) . "</td><td><?php echo $" . $row["column_name"] . "; ?></td></tr>";
        }
    }
}
$string .= "\n\t</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";


$hasil_view_read = createFile($string, $target . $module . "/views/" . $v_read_file);
