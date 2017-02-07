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

        <!-- widget Cek Kartu -->
        <div class="panel panel-default panel-gtl" id="widget-register">
            <div class="panel-heading">
                <h4><small>CEK VALIDASI</small>KARTU MEMBER</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="reg-form">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#aktivasi" role="tab" data-toggle="tab"><strong>Cek Aktivasi</strong></a></li>
                                <li><a href="#repeatorder" role="tab" data-toggle="tab"><strong>Cek Repeat Order</strong></a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Cek kartu Aktivasi -->
                                <div class="tab-pane active" id="aktivasi">
                                    <br>
                                    <h5 class="divider"><strong>Cek Kartu Aktivasi</strong></h5>
                                    <form class="form-horizontal" role="form" id="form-aktivasi">
                                        <div class="form-group">
                                            <label for="inputserial1" class="col-sm-3 control-label">Nomor Serial</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputserial1" placeholder="masukkan nomor serial...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i>&nbsp; Cek Serial</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Cek kartu Aktivasi -->

                                <!-- Cek kartu repeat order -->
                                <div class="tab-pane" id="repeatorder">
                                    <br>
                                    <h5 class="divider"><strong>Cek Kartu Repeat Order</strong></h5>
                                    <form class="form-horizontal" role="form" id="form-ro">
                                        <div class="form-group">
                                            <label for="inputserial2" class="col-sm-3 control-label">Nomor Serial</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputserial2" placeholder="masukkan nomor serial...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i>&nbsp; Cek Serial</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Cek kartu repeat order -->
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>

                    <div class="col-md-4">
                        <center><img src="images/logo.png" alt="MAI" style="width: 50%;"></center><br>
                        <small><sup class="required">*</sup>Cek Serial merupakan fitur yang dapat anda gunakan untuk melakukan pengecekan apakah serial member anda valid atau masih aktif.</small>
                        <div class="clearfix"></div>
                        <hr>
                        <center><a href="#" class="btn btn-default btn-lg"><i class="fa fa-envelope"></i>&nbsp; Kontak Admin</a></center>
                    </div>
                </div>
            </div>
        </div>
        <!-- widget Cek Kartu -->
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