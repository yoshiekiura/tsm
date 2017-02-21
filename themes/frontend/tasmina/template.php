<?php $this->load->view('template/header_2'); ?>

<!-- Main -->
<div id="main-container">
    <div class="container">
        <!-- breadcrumb -->
        <div id="breadcrumbs">
            <div class="container">
                <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
                    <?php
                    if (isset($arr_breadcrumbs)) {
                        if (is_array($arr_breadcrumbs)) {
                            $i = 1;
                            foreach ($arr_breadcrumbs as $breadcrumbs_title => $breadcrumbs_links) {
                                if ($breadcrumbs_links != '#') {
                                    $breadcrumbs_links = base_url() . $breadcrumbs_links;
                                }
                                if ($i == count($arr_breadcrumbs)) {
                                    echo '<li class="active">' . $breadcrumbs_title . '</li>';
                                } else {
                                    echo '<li><a href="' . $breadcrumbs_links . '">' . $breadcrumbs_title . '</a></li>';
                                }
                                $i++;
                            }
                        }
                    }
                    ?>
                </ol>
            </div>
        </div>
        <!-- breadcrumb -->

        <div class="row">
            <?php $this->load->view('template/widget_side'); ?>

            <!-- main side -->
            <div class="col-md-9" id="main-side">
                <?php $this->load->view($contents); ?>
            </div>

        </div>
        <!-- main side -->
    </div>
    <!-- end container -->

    <?php
        $frontend_widget = new widget();
        $frontend_widget->run('widget/frontend_billboard_widget');
    ?>

</div>
<!-- /Main -->

<?php $this->load->view('template/footer'); ?>