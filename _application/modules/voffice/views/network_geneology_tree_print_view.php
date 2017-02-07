<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Jaringan Geneologi (Tree)</title>
        <style>
            @media print { .notPrinted { display: none; } }

            body {
                font-family:tahoma, verdana, courier new;
                font-size:9pt;
            }

            small {
                font-size:8pt;
            }

            .hr11 {
                height:2px;
                border-top:1px solid #aaa;
                border-bottom:1px solid #aaa;
            }

            a {
                color:#ccc;
                font-size:9pt;
            }
        </style>
        <?php
        if(isset($extra_head_content)) {
            echo $extra_head_content;
        }
        ?>
    </head>
    <body>
        <a href="javascript:print()" class="notPrinted"><img src="<?php echo $addons_tree_dir; ?>/images/print.gif" /> Print</a>
        <div id="treecontrol" class="notPrinted">
            <a title="Collapse the entire tree below" href="#"><img src="<?php echo $addons_tree_dir; ?>/images/minus.gif" /> Collapse All</a>&nbsp;&nbsp;
            <a title="Expand the entire tree below" href="#"><img src="<?php echo $addons_tree_dir; ?>/images/plus.gif" /> Expand All</a>
            <!--<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>-->
        </div>
        <h2>JARINGAN MEMBER &middot; <?php echo $top_network_code; ?> &middot; <?php echo $top_member_name; ?></h2>
        <ul id="geneology-tree" class="treeview-gray">
            <?php echo $str_data; ?>
        </ul>
        <script>
            $(document).ready(function() {

                $("#geneology-tree").treeview({
                    animated: "fast",
                    collapsed: true,
                    unique: false,
                    control: "#treecontrol",
                    persist: "cookie",
                    cookieId: "geneology-gray"
                });

            });
        </script>
        <script>window.print();</script>
    </body>
</html>