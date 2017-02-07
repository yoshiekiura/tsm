<?php
$menu_par_id = $this->uri->segment(4, 0);
if($menu_par_id != 0) {
    $title = 'Sub Menu "' . $menu_par_title . '"';
    $data_url = $this->service_module_url.'/get_data/' . $menu_par_id;
    $add_url = '../add/' . $menu_par_id;
    $act_show_url = $this->service_module_url.'/act_show';
} else {
    $title = 'Menu';
    $data_url = $this->service_module_url.'/get_data';
    $add_url = 'add';
    $act_show_url = $this->service_module_url.'/act_show';
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
            <?php
            if($menu_par_id == 0) {
            ?>
            { display: 'Sub', name: 'submenu', width: 40, sortable: false, align: 'center', datasource: false },
            <?php
            }
            ?>
            { display: 'Judul', name: 'menu_title', width: 300, sortable: false, align: 'left' },
            { display: 'Link', name: 'menu_link', width: 400, sortable: false, align: 'left' },
            { display: 'Block', name: 'menu_block', width: 100, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'menu_is_active', width: 40, sortable: false, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Tambah', name: 'add_menu', bclass: 'add', onpress: add_menu},
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            // { display: 'Up', name: 'up', bclass: 'sort_up', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            // { separator: true },
            // { display: 'Down', name: 'down', bclass: 'sort_down', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            // { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Judul', name: 'menu_title', type: 'text', isdefault: true },
            { display: 'Block', name: 'menu_block', type: 'select', option: 'top:Top|sidebar:Sidebar|middle:Middle|bottom:Bottom' },
            { display: 'Status Aktif', name: 'menu_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "menu_order_by",
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