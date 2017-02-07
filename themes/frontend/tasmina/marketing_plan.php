<?php include('template/header_2.php'); ?>

<!-- Main -->
<div id="main-container">
    <div class="container">
        <!-- breadcrumb -->
        <div id="breadcrumbs">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active">Data</li>
                </ol>
            </div>
        </div>
        <!-- breadcrumb -->

        <div class="row">
            <?php include('template/widget_side.php'); ?>

            <!-- main side -->
            <div class="col-md-9" id="main-side">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Marketing Plan</h3></div>
                    <div class="panel-body">
                        <div id="widget-mplan">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#plan-autoreward" role="tab" data-toggle="tab">Auto Reward</a></li>
                                <li><a href="#plan-sponsor" role="tab" data-toggle="tab">Bonus Sponsor</a></li>
                                <li><a href="#plan-generasi" role="tab" data-toggle="tab">Bonus Generasi</a></li>
                                <li><a href="#plan-pasangan" role="tab" data-toggle="tab">Bonus Pasangan</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="plan-autoreward">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="uploads/gallery/formstack1.jpg" rel="prettyPhoto[gallery02]" title="You can add caption to pictures." class="thumbnail">
                                                <img src="uploads/gallery/formstack1.jpg" alt="autoreward" class="img-thumbnail img-responsive">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, dolore et, veniam perspiciatis, quos ut, ipsa numquam at laborum aspernatur dolorem optio eos similique. Voluptates dignissimos voluptas, reprehenderit fugiat nam.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="plan-sponsor">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="uploads/gallery/formstack1.jpg" rel="prettyPhoto[gallery02]" title="You can add caption to pictures." class="thumbnail">
                                                <img src="uploads/gallery/formstack1.jpg" alt="autoreward" class="img-thumbnail img-responsive">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, dolore et, veniam perspiciatis, quos ut, ipsa numquam at laborum aspernatur dolorem optio eos similique. Voluptates dignissimos voluptas, reprehenderit fugiat nam.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="plan-generasi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="uploads/gallery/formstack1.jpg" rel="prettyPhoto[gallery02]" title="You can add caption to pictures." class="thumbnail">
                                                <img src="uploads/gallery/formstack1.jpg" alt="autoreward" class="img-thumbnail img-responsive">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, dolore et, veniam perspiciatis, quos ut, ipsa numquam at laborum aspernatur dolorem optio eos similique. Voluptates dignissimos voluptas, reprehenderit fugiat nam.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="plan-pasangan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="uploads/gallery/formstack1.jpg" rel="prettyPhoto[gallery02]" title="You can add caption to pictures." class="thumbnail">
                                                <img src="uploads/gallery/formstack1.jpg" alt="autoreward" class="img-thumbnail img-responsive">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, dolore et, veniam perspiciatis, quos ut, ipsa numquam at laborum aspernatur dolorem optio eos similique. Voluptates dignissimos voluptas, reprehenderit fugiat nam.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- main side -->
        </div>
    </div>
    <!-- end container -->

    <div id="section-2">
        <div id="widget_fullpromo">
            <div class="container">
                <img src="uploads/promo/promo-2.jpg" class="promo_img">
                <div class="promo_link">
                    <h4>Daftarkan diri anda berhaji dan umroh bersama kami.<a href="#" class="btn btn-default">DAFTAR SEKARANG</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main -->

<?php include('template/footer.php'); ?>