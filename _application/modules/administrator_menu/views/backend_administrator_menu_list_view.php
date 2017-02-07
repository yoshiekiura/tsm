<?php
$menu_par_id = $this->uri->segment(4, 0);
if($menu_par_id != 0) {
    $title = 'Sub Menu "' . $menu_par_title . '"';
    $data_url = '../get_data/' . $menu_par_id;
    $add_url = '../add/' . $menu_par_id;
    $act_show_url = '../act_show';
} else {
    $title = 'Menu';
    $data_url = 'get_data';
    $add_url = 'add';
    $act_show_url = 'act_show';
}
?>
<h2>Data <?php echo $title; ?></h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $data_url; ?>',
        dataType: 'json',
        colModel: [
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
            <?php
            if($menu_par_id == 0) {
            ?>
            { display: 'Sub', name: 'submenu', width: 40, sortable: false, align: 'center', datasource: false },
            <?php
            }
            ?>
            { display: 'Aktif', name: 'administrator_menu_is_active', width: 40, sortable: false, align: 'center' },
            //{ display: 'Ikon', name: 'administrator_menu_icon', width: 40, sortable: false, align: 'center', datasource: false },
            { display: 'Ikon', name: 'administrator_menu_class', width: 40, sortable: false, align: 'center', datasource: false },
            { display: 'Judul', name: 'administrator_menu_title', width: 200, sortable: false, align: 'left' },
            { display: 'Link', name: 'administrator_menu_link', width: 500, sortable: false, align: 'left' },
        ],
        buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: add_menu },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '<?php echo base_url('backend/administrator_menu/act_show') ?>' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '<?php echo base_url('backend/administrator_menu/act_show') ?>' },
            { separator: true },
            { display: 'Up', name: 'up', bclass: 'sort_up', onpress: act_sort, urlaction: '<?php echo base_url('backend/administrator_menu/act_show') ?>' },
            { separator: true },
            { display: 'Down', name: 'down', bclass: 'sort_down', onpress: act_sort, urlaction: '<?php echo base_url('backend/administrator_menu/act_show') ?>' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo base_url('backend/administrator_menu/act_show') ?>' },
        ],
        searchitems: [
            { display: 'Judul', name: 'administrator_menu_title', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'administrator_menu_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "administrator_menu_order_by",
        sortorder: "asc",
        usepager: true,
        title: '',
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '270',
        resizable: false,
        singleSelect: false
    });

    function add_menu() {
        window.location.href = '<?php echo $add_url; ?>';
    }

    
</script>