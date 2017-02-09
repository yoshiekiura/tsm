<?php $frontend_widget = new widget(); ?>
<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/slider'); ?>

<!-- Main -->
<div id="main-container">
    <div id="section-1">

        <?php $frontend_widget->run('menu/frontend_middle_menu_widget'); ?>
        <?php $frontend_widget->run('page_home/frontend_page_home_mainbar_widget'); ?>

        <div id="widget_info_list">
            <div class="container">
                <h3 class="title">Informasi Terbaru</h3>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#content-1" aria-controls="content-1" role="tab" data-toggle="tab" id="tab-1">Berita</a></li>
                    <li role="presentation"><a href="#content-2" aria-controls="content-2" role="tab" data-toggle="tab" id="tab-2">Tausiyah</a></li>
                    <li role="presentation"><a href="#content-3" aria-controls="content-3" role="tab" data-toggle="tab" id="tab-3">Paket Haji & Umrah</a></li>
                    <li role="presentation"><a href="#content-4" aria-controls="content-4" role="tab" data-toggle="tab" id="tab-4">Kegiatan</a></li>
                    <li role="presentation"><a href="#content-5" aria-controls="content-5" role="tab" data-toggle="tab" id="tab-5">Galeri</a></li>
                </ul>
            </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="container">
                    <?php $frontend_widget->run('widget/frontend_news_widget', 'artikel'); // for artikel ?>
                    <?php $frontend_widget->run('widget/frontend_news_widget', 'tausiyah'); // for tausiyah ?>
                    <?php $frontend_widget->run('widget/frontend_products_widget'); ?>
                    <?php $frontend_widget->run('widget/frontend_event_widget'); ?>
                    <?php $frontend_widget->run('widget/frontend_gallery_widget'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php $frontend_widget->run('widget/frontend_leader_widget'); ?>
    <?php $frontend_widget->run('widget/frontend_billboard_widget'); ?>

    <div id="section-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php $frontend_widget->run('widget/frontend_testimonial_widget') ?>
                </div>

                <div class="col-md-8" id="stats_weekly">
                    <?php $frontend_widget->run('widget/frontend_member_widget') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main -->

<?php $this->load->view('template/footer'); ?>