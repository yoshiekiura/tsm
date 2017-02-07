<h2>Ubah Data Grup Administrator</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $arr_input_item = array();
    if (isset($this->arr_flashdata['input_item'])) {
        $arr_input_item = $this->arr_flashdata['input_item'];
    } elseif(!isset($this->arr_flashdata['input_type'])) {
        $arr_input_item = $arr_checked_menu;
    }

    $allitem_checked = false;
    if (isset($this->arr_flashdata['input_allitem'])) {
        $allitem_checked = $this->arr_flashdata['input_allitem'];
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Grup Administrator</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <?php if ($this->session->userdata('administrator_group_type') == 'superuser') { ?>
                    <div class="form-group">
                        <label class="control-label col-md-2">Tipe Grup</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_dropdown('type', $type_options, (isset($this->arr_flashdata['input_type'])) ? $this->arr_flashdata['input_type'] : $row->administrator_group_type, 'id="type" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo form_hidden('type', 'administrator');
                }
                ?>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Grup</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->administrator_group_title, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div id="privilege_menu" class="form-group">
                    <label class="control-label col-md-2">Hak Akses</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">

                            <div class="checkbox">
                                <label>
                                    <?php echo form_checkbox(array('name' => 'allitem', 'checked' => $allitem_checked, 'value' => true, 'id' => 'item', 'onclick' => 'check_all(\'item\', 1)')); ?> <strong>Pilih Semua</strong>
                                </label>
                            </div>
                            <?php
                            // cari root menu
                            if (array_key_exists('0', $arr_menu_privilege)) {
                                echo '<div id="block_menu_item_0">';

                                // urutkan root menu berdasarkan menu_order_by
                                ksort($arr_menu_privilege[0]);

                                // ekstrak root menu
                                $x = 1;
                                foreach ($arr_menu_privilege[0] as $rootmenu_sort => $rootmenu_value) {

                                    $rootmenu_check = false;
                                    $rootmenu_check = (in_array($rootmenu_value->administrator_menu_id, $arr_input_item)) ? true : false;

                                    $rootmenu_checkbox_data = array();
                                    $rootmenu_checkbox_data['name'] = 'item[' . $x . ']';
                                    $rootmenu_checkbox_data['id'] = 'item_' . $x;
                                    $rootmenu_checkbox_data['value'] = $rootmenu_value->administrator_menu_id;
                                    $rootmenu_checkbox_data['checked'] = $rootmenu_check;
                                    $rootmenu_checkbox_data['class'] = 'menu_item';

                                    echo '<div class="checkbox" style="margin:10px 0 10px 25px;"><label>' . form_checkbox($rootmenu_checkbox_data) . '&nbsp;<strong>' . $rootmenu_value->administrator_menu_title . '</strong></label></div>';

                                    // cari submenu 1
                                    if (array_key_exists($rootmenu_value->administrator_menu_id, $arr_menu_privilege)) {
                                        echo '<div id="block_menu_' . $rootmenu_checkbox_data['id'] . '">';

                                        // urutkan submenu 1 berdasarkan menu_order_by
                                        ksort($arr_menu_privilege[$rootmenu_value->administrator_menu_id]);

                                        // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
                                        foreach ($arr_menu_privilege[$rootmenu_value->administrator_menu_id] as $submenu_1_sort => $submenu_1_value) {
                                            $x++;
                                            $submenu_1_check = false;
                                            $submenu_1_check = (in_array($submenu_1_value->administrator_menu_id, $arr_input_item)) ? true : false;

                                            $submenu_1_checkbox_data = array();
                                            $submenu_1_checkbox_data['name'] = 'item[' . $x . ']';
                                            $submenu_1_checkbox_data['id'] = 'item_' . $x;
                                            $submenu_1_checkbox_data['value'] = $submenu_1_value->administrator_menu_id;
                                            $submenu_1_checkbox_data['checked'] = $submenu_1_check;
                                            $submenu_1_checkbox_data['class'] = 'menu_item';

                                            echo '<div class="checkbox" style="margin:0 0 5px 50px;"><label>' . form_checkbox($submenu_1_checkbox_data) . '&nbsp;' . $rootmenu_value->administrator_menu_title . ' &raquo; ' . $submenu_1_value->administrator_menu_title . '</label></div>';

                                            // cari submenu 2
                                            if (array_key_exists($submenu_1_value->administrator_menu_id, $arr_menu_privilege)) {
                                                echo '<div id="block_menu_' . $submenu_1_checkbox_data['id'] . '">';

                                                // urutkan submenu 2 berdasarkan menu_order_by
                                                ksort($arr_menu_privilege[$submenu_1_value->administrator_menu_id]);

                                                // ekstrak submenu 2 yang par_id adalah menu_id dari sub menu 1
                                                foreach ($arr_menu_privilege[$submenu_1_value->administrator_menu_id] as $submenu_2_sort => $submenu_2_value) {
                                                    $x++;
                                                    $submenu_2_check = false;
                                                    $submenu_2_check = (in_array($submenu_2_value->administrator_menu_id, $arr_input_item)) ? true : false;

                                                    $submenu_2_checkbox_data = array();
                                                    $submenu_2_checkbox_data['name'] = 'item[' . $x . ']';
                                                    $submenu_2_checkbox_data['id'] = 'item_' . $x;
                                                    $submenu_2_checkbox_data['value'] = $submenu_2_value->administrator_menu_id;
                                                    $submenu_2_checkbox_data['checked'] = $submenu_2_check;
                                                    $submenu_2_checkbox_data['class'] = 'menu_item';

                                                    echo '<div class="checkbox" style="margin:0 0 5px 75px;"><label>' . form_checkbox($submenu_2_checkbox_data) . '&nbsp;' . $submenu_1_value->administrator_menu_title . ' &raquo; ' . $submenu_2_value->administrator_menu_title . '</label></div>';

                                                    // cari submenu 3
                                                    if (array_key_exists($submenu_2_value->administrator_menu_id, $arr_menu_privilege)) {
                                                        echo '<div id="block_menu_' . $submenu_2_checkbox_data['id'] . '">';

                                                        // urutkan submenu 3 berdasarkan menu_order_by
                                                        ksort($arr_menu_privilege[$submenu_2_value->administrator_menu_id]);

                                                        // ekstrak submenu 3 yang par_id adalah menu_id dari sub menu 2
                                                        foreach ($arr_menu_privilege[$submenu_2_value->administrator_menu_id] as $submenu_3_sort => $submenu_3_value) {
                                                            $x++;
                                                            $submenu_3_check = false;
                                                            $submenu_3_check = (in_array($submenu_3_value->administrator_menu_id, $arr_input_item)) ? true : false;

                                                            $submenu_3_checkbox_data = array();
                                                            $submenu_3_checkbox_data['name'] = 'item[' . $x . ']';
                                                            $submenu_3_checkbox_data['id'] = 'item_' . $x;
                                                            $submenu_3_checkbox_data['value'] = $submenu_3_value->administrator_menu_id;
                                                            $submenu_3_checkbox_data['checked'] = $submenu_3_check;
                                                            $submenu_3_checkbox_data['class'] = 'menu_item';

                                                            echo '<div class="checkbox" style="margin:0 0 5px 100px;"><label>' . form_checkbox($submenu_3_checkbox_data) . '&nbsp;' . $submenu_2_value->administrator_menu_title . ' &raquo; ' . $submenu_3_value->administrator_menu_title . '</label></div>';
                                                        }
                                                        echo '</div>';
                                                    }
                                                }
                                                echo '</div>';
                                            }
                                        }
                                        echo '</div>';
                                    }
                                    $x++;
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-2 col-md-10">
                            <button name="update" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            var group_type = $("#type").val();
            if(group_type == "superuser") {
                $("#privilege_menu").hide();
            } else {
                $("#privilege_menu").show();
            }

            $("#type").change(function(){
                var group_type = $(this).val();
                if(group_type == "superuser") {
                    $("#privilege_menu").hide();
                } else {
                    $("#privilege_menu").show();
                }
            });

            $("#privilege_menu .menu_item").click(function() {
                var id = $(this).attr('id');
                if($("#" + id).is(':checked')) {
                    //change nested parents checked
                    //var parents = $(this).parent().parent().parent().parent().parent();
                    var parents = $(this).parent().parent().parent();
                    while (parents.attr('id') != 'block_menu_item_0' && id != 'block_menu_item_0') {
                        var parent_id = parents.attr('id');
                        $("#" + parent_id.substring(parent_id.lastIndexOf('block_menu_') + 11)).prop('checked', true);
                        parents = parents.parent();
                    }

                    //change child all item checked
                    $("#block_menu_" + id + " .menu_item").prop('checked', true);
                } else {
                    //change child all item unchecked
                    $("#block_menu_" + id + " .menu_item").prop('checked', false);
                }
            });

        });
    </script>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>