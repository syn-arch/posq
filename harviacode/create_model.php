<?php

$string = "<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class " . $m . " extends CI_Model
{

    public \$table = '$table_name';
    public \$id = '$pk';
    public \$order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }";

if ($jenis_tabel <> 'reguler_table') {

    $column_all = array();
    foreach ($all as $row) {
        if ($join) {
            if (in_array(str_replace('id_', '', $row['column_name']), $table_join)) {
                foreach ($table_join as $index => $tb) {
                    if ($row['column_name'] == 'id_' . $tb) {
                        $column_all[] = $tb . '.id_' . $tb;
                    }
                }
            } else {
                $column_all[] = $row['column_name'];
            }
        } else {
            $column_all[] = $row['column_name'];
        }
    }
    if ($join) {
        foreach ($table_join as $index => $row) {
            $column_all[] = 'nama_' . $row;
        }
    }
    $columnall = implode(',', $column_all);

    $string .= "\n\n    // datatables
        function json() {

            \$menu = \$this->uri->segment(1);
            \$id_menu = \$this->db->get_where('menu', ['url' => \$menu])->row_array()['id_menu'];
            \$id_role = \$this->session->userdata('id_role');

            \$this->db->select('c, u ,d');
            \$this->db->where('id_menu', \$id_menu);
            \$this->db->where('id_role', \$id_role);
            \$access = \$this->db->get('akses_role')->row_array();

            \$this->datatables->select('" . $columnall . "');
            \$this->datatables->from('" . $table_name . "');
            //add this line for join
            //\$this->datatables->join('table2', '" . $table_name . ".field = table2.field');
            ";

    if ($join) {
        foreach ($table_join as $index => $row) {
            $string .= "\n\$this->datatables->join('$row', '" . $row . ".$primary_key[$index] = $table_name.$id_table_join[$index]');";
        }
    }

    $string .= "

            if (\$access['u'] == '1' && \$access['d'] == '1') {
                \n\$this->datatables->add_column('action', 
                '<a href=\"'  . site_url('" . $table_name . "/read/\$1') . '\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a> 
                <a href=\"'  . site_url('" . $table_name . "/update/\$1') . '\" class=\"btn btn-warning\"><i class=\"fa fa-edit\"></i></a> 
                <a data-href=\"'  . site_url('" . $table_name . "/delete/\$1') . '\" class=\"btn btn-danger hapus-data\"><i class=\"fa fa-trash\"></i></a>', '" . $pk . "');
            }else if( \$access['u'] == '1'){
                 \n\$this->datatables->add_column('action', 
                '<a href=\"'  . site_url('" . $table_name . "/read/\$1') . '\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a> 
                <a href=\"'  . site_url('" . $table_name . "/update/\$1') . '\" class=\"btn btn-warning\"><i class=\"fa fa-edit\"></i></a>', '" . $pk . "');
            } else if(\$access['d'] == '1'){
                \n\$this->datatables->add_column('action', 
                '<a href=\"'  . site_url('" . $table_name . "/read/\$1') . '\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a> 
                <a data-href=\"'  . site_url('" . $table_name . "/delete/\$1') . '\" class=\"btn btn-danger hapus-data\"><i class=\"fa fa-trash\"></i></a>', '" . $pk . "');
            }else{
                 \n\$this->datatables->add_column('action', '<a href=\"'  . site_url('" . $table_name . "/read/\$1') . '\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a>','" . $pk . "');
            }

           

            if (\$access['d'] == '1') {
                \$this->datatables->add_column('hapus_bulk', 
                '<input type=\"checkbox\" class=\"data_checkbox\" name=\"data[]\" value=\"$1\">', '" . $pk . "');
            }else{
                \$this->datatables->add_column('hapus_bulk','', '" . $pk . "');
            }
            return \$this->datatables->generate();
        }";
}

$string .= "\n\n    // get all
    function get_all()
    {
        ";

$column_all = array();
foreach ($all as $row) {
    if ($join) {
        foreach ($table_join as $index => $tb) {
            if ($row['column_name'] == 'id_' . $tb) {
                $column_all[] = $tb . '.id_' . $tb;
            }
        }
    }
}

$columnall = implode(',', $column_all);
$string .= "\$this->db->select('*, $columnall');";

if ($join) {
    foreach ($table_join as $index => $row) {
        $string .= "\n\$this->db->join('$row', '" . $row . ".$primary_key[$index] = $table_name.$id_table_join[$index]', 'left');";
    }
}

$string .= "\n\$this->db->order_by(\$this->id, \$this->order);
        return \$this->db->get(\$this->table)->result();
    }

    // get data by id
    function get_by_id(\$id)
    {
        ";
$column_all = array();
foreach ($all as $row) {
    if ($join) {
        foreach ($table_join as $index => $tb) {
            if ($row['column_name'] == 'id_' . $tb) {
                $column_all[] = $tb . '.id_' . $tb;
            }
        }
    }
}

$columnall = implode(',', $column_all);
$string .= "\$this->db->select('*, $columnall');";

if ($join) {
    foreach ($table_join as $index => $row) {
        $string .= "\n\$this->db->join('$row', '" . $row . ".$primary_key[$index] = $table_name.$id_table_join[$index]', 'left');";
    }
}

$string .= "\n\$this->db->where(\$this->id, \$id);
        return \$this->db->get(\$this->table)->row();
    }
    
    // get total rows
    function total_rows(\$q = NULL) {
        \$this->db->like('$pk', \$q);";
$column_all = array();
foreach ($all as $row) {
    if ($join) {
        foreach ($table_join as $index => $tb) {
            if ($row['column_name'] == 'id_' . $tb) {
                $column_all[] = $tb . '.id_' . $tb;
            }
        }
    }
}

$columnall = implode(',', $column_all);
$string .= "\n\$this->db->select('*, $columnall');";
if ($join) {
    foreach ($table_join as $index => $row) {
        $string .= "\n\$this->db->join('$row', '" . $row . ".$primary_key[$index] = $table_name.$id_table_join[$index]', 'left');";
    }
}
foreach ($non_pk as $row) {
    if ($join) {
        if (in_array(str_replace('id_', '', $row['column_name']), $table_join)) {
            foreach ($table_join as $index => $tb) {
                if ($row['column_name'] == 'id_' . $tb) {
                    $string .= "\n\t\$this->db->or_like('$tb" . '.id_' . $tb . "', \$q);";
                }
            }
        } else {
            $string .= "\n\t\$this->db->or_like('" . $row['column_name'] . "', \$q);";
        }
    } else {
        $string .= "\n\t\$this->db->or_like('" . $row['column_name'] . "', \$q);";
    }
}

$string .= "\n\t\$this->db->from(\$this->table);
        return \$this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data(\$limit, \$start = 0, \$q = NULL) {
        \$this->db->order_by(\$this->id, \$this->order);
        \$this->db->like('$pk', \$q);";
$column_all = array();
foreach ($all as $row) {
    if ($join) {
        foreach ($table_join as $index => $tb) {
            if ($row['column_name'] == 'id_' . $tb) {
                $column_all[] = $tb . '.id_' . $tb;
            }
        }
    }
}

$columnall = implode(',', $column_all);
$string .= "\n\$this->db->select('*, $columnall');";
if ($join) {
    foreach ($table_join as $index => $row) {
        $string .= "\n\$this->db->join('$row', '" . $row . ".$primary_key[$index] = $table_name.$id_table_join[$index]', 'left');";
    }
}
foreach ($non_pk as $row) {
    if ($join) {
        if (in_array(str_replace('id_', '', $row['column_name']), $table_join)) {
            foreach ($table_join as $index => $tb) {
                if ($row['column_name'] == 'id_' . $tb) {
                    $string .= "\n\t\$this->db->or_like('$tb" . '.id_' . $tb . "', \$q);";
                }
            }
        } else {
            $string .= "\n\t\$this->db->or_like('" . $row['column_name'] . "', \$q);";
        }
    } else {
        $string .= "\n\t\$this->db->or_like('" . $row['column_name'] . "', \$q);";
    }
}

$string .= "\n\t\$this->db->limit(\$limit, \$start);
        return \$this->db->get(\$this->table)->result();
    }

    // insert data
    function insert(\$data)
    {
        \$this->db->insert(\$this->table, \$data);
    }

    // update data
    function update(\$id, \$data)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->update(\$this->table, \$data);
    }

    // delete data
    function delete(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->delete(\$this->table);
    }

}

/* End of file $m_file */
/* Location: ./application/models/$m_file */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator " . date('Y-m-d H:i:s') . " */
/* http://harviacode.com */";




$hasil_model = createFile($string, $target . $module . "/models/" . $m_file);
