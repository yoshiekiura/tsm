<?php echo form_open($form_action); ?>
<div style="width: 100%; display: inline-block;">
    <div class="form-group input-group col-md-6" style="padding-left: 0;">
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_input('search_network_code', (isset($this->arr_flashdata['input_search_network_code'])) ? $this->arr_flashdata['input_search_network_code'] : '', 'size="20" placeholder="Pencarian Jaringan Member (Masukkan Kode Member)" class="form-control"'); ?>
        <span class="input-group-btn">
            <button name="search" value="true" type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
        </span>
    </div>
</div>
<?php echo form_close(); ?>
<?php
if (!isset($this->arr_flashdata['notfound'])) {
    ?>
    <div class="x_panel">
        <div id="treecontrol">
            <a title="Collapse the entire tree below" href="#"><img src="<?php echo $addons_tree_dir; ?>/images/minus.gif" /> Collapse All</a>&nbsp;&nbsp;&nbsp;
            <a title="Expand the entire tree below" href="#"><img src="<?php echo $addons_tree_dir; ?>/images/plus.gif" /> Expand All</a>&nbsp;&nbsp;&nbsp;
            <a title="Tampilkan versi cetak" href="javascript:void(0)" onclick="printDiv('print-tree');return false;" target="_blank"><img src="<?php echo $addons_tree_dir; ?>/images/print.gif" /> Print</a>
            <!--<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>-->
        </div>
        <div id="print-tree">
        <h4>JARINGAN MEMBER &middot; <?php echo $top_network_code; ?> &middot; <?php echo $top_member_name; ?></h4>
        <ul id="geneology-tree" class="treeview-gray">
            <?php echo $str_data; ?>
        </ul>
        <br /><br />
        </div>
        <script>
            $(document).ready(function() {
               genealogy_tree();
            });

            function genealogy_tree()
            {
                 $("#geneology-tree").treeview({
                    animated: "fast",
                    collapsed: true,
                    unique: false,
                    control: "#treecontrol",
                    persist: "cookie",
                    cookieId: "geneology-gray"
                });
            }
        </script>
    </div>
    <?php
}
?>

<script type="text/javascript">
function get_downline(elem,root_id,upline_id,year,month)
{

        //
        elem.hide();
    //    e.preventDefault();
        var jqxhr=$.ajax({
            url:'<?php echo base_url()?>voffice/network/get_downline/'+root_id+'/'+upline_id+'/'+year+'/'+month,
            dataType:'json',
            type:'get'
        });
        jqxhr.success(function(response){
            var element_li=elem.parent().parent();
            var elem_parent=elem.parent();
            //console.log(response);
            //console.log(elem_parent.find('#end_'+upline_id));
            var status=response['status'];
            var generate_html='';
            if(status==200)
            {
                generate_html=response['ul_child'];
                element_li.find('li#parentli_'+upline_id).addClass('collapsable');
                elem_parent.find('span').before('<div class="hitarea collapsable-hitarea"></div>');
                elem_parent.find('span').after(generate_html);
                //genealogy_tree();
            }
            //

        });
        jqxhr.error(function(response){
            alert('an error has ocurred, please try again.');
            return false;

        });
        jqxhr.complete(function(){
            //alert('complete');
            //genealogy_tree();
             var originalContents = document.body.innerHTML;
             document.body.innerHTML = originalContents;

             $('#sidebar-menu li').click(function () {
                if ($(this).is('.active')) {
                    $(this).removeClass('active');
                    $('ul', this).slideUp();
                    $(this).removeClass('nv');
                    $(this).addClass('vn');
                } else {
                    $('#sidebar-menu li ul').slideUp();
                    $(this).removeClass('vn');
                    $(this).addClass('nv');
                    $('ul', this).slideDown();
                    $('#sidebar-menu li').removeClass('active');
                    $(this).addClass('active');
                }
            });

            genealogy_tree();

        });

    //elem.preventDefault;
  

}

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     window.print();
     //setTimeout(function(){ alert('ok')},300);

     document.body.innerHTML = originalContents;
     // $('#sidebar-menu li ul').slideUp();
    //$('#sidebar-menu li').removeClass('active');

     $('#sidebar-menu li').click(function () {
        if ($(this).is('.active')) {
            $(this).removeClass('active');
            $('ul', this).slideUp();
            $(this).removeClass('nv');
            $(this).addClass('vn');
        } else {
            $('#sidebar-menu li ul').slideUp();
            $(this).removeClass('vn');
            $(this).addClass('nv');
            $('ul', this).slideDown();
            $('#sidebar-menu li').removeClass('active');
            $(this).addClass('active');
        }
    });

    genealogy_tree();
}
</script>
