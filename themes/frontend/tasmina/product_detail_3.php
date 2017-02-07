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
                    <div class="panel-heading"><h3>Produk</h3></div>
                    <div class="panel-body">
                        <div id="block-product">
                            <div class="item-desc">
                                <div class="item-title">
                                    <h3 class="title">ExtendLife Facial Foam</h3>
                                </div>
                                <hr>

                                <div class="item-text">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <ul class="list polaroids">
                                                <li>
                                                    <a class='takezoom' href="uploads/gallery/thumbs/produk-1.jpg" rel="prettyPhoto[gallery01]" title="You can add caption to pictures."><img src="uploads/gallery/thumbs/produk-1.jpg" alt="ExtendLife Facial Foam"/></a>
                                                </li>                                                
                                            </ul>
                                        </div>

                                        <div class="col-md-8">
                                            <h5 class="subtitle"><span>Harga :</span></h5>
                                            <table class="table table-striped table-hovered table-bordered text-center table-harga">
                                                <tbody><tr class="warning">
                                                    <td>HARGA MEMBER : </td>
                                                    <td>HARGA KONSUMEN :</td>
                                                </tr>
                                                <tr>
                                                    <td><h3 style="font-size:20px; color:#bd2c40;">Rp. 99,000,-</h3></td>
                                                    <td><h3 style="font-size:20px; color:#e58a14;">Rp. 175,000,-</h3></td>
                                                </tr>
                                            </tbody></table>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <br>

                                <div class="item-text">
                                    <h4 class="subtitle"><span>RINCIAN PRODUK :</span></h4>
                                    <table class="table table-bordered table-striped table-hover" id="table_product_3">
                                        <tbody>
                                            <tr>
                                                <th style="background: #0F1012;color: #fff;" width="30%"></th>
                                                <th style="background: #0F1012;color: #fff;" width="70%" class="active"><b>Komposisi</b></th>
                                            </tr>

                                            <tr>
                                                <th rowspan="1">
                                                    <center>
                                                        <h4 class="title">Produk 01</h4>
                                                        <a class="takezoom" rel="prettyPhoto[gallery01]" href="uploads/gallery/produk-2.jpg" title="You can add caption to pictures."><img src="uploads/gallery/produk-2.jpg" alt="Produk 01" title="Produk 01"></a>
                                                        <div class="clearfix"></div>
                                                        <br>

                                                        <p>BPOM : NA18151202176 </p>
                                                        <p>Rp. 35.000,00</p>
                                                    </center>
                                                </th>
                                                <td>
                                                    <br>
                                                    <h4>
                                                        <span class="label label-success">
                                                            <strong>Komposisi :</strong>
                                                        </span>
                                                    </h4>
                                                    <ul style="padding-left: 20px;">
                                                        <li>sucrose, aqua, cocos nucifera oil, proppylene glycol, alcohol denat, stearic acid, glycerin, triethanolamine, sodium hydroxide, sorbitol, sodium laureth sulfate, parfume, CI 16255, BHT</li>
                                                    </ul>
                                                    <br>

                                                    <h4>
                                                        <span class="label label-success">
                                                            <strong>Manfaat :</strong>
                                                        </span>
                                                    </h4>
                                                    <p>mencegah radikal bebas, mengangkat sel kulit mati, menghaluskan dan melembabkan kulit, menjadikan kulit cerah alami</p>
                                                    <br>

                                                    <h4>
                                                        <span class="label label-success">
                                                            <strong>Aturan Pakai :</strong>
                                                        </span>
                                                    </h4>
                                                    <p>gunakan di pagi hari (saat mandi)</p>
                                                    <br>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2"><br></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <br>
                                </div>
                            </div>
                        </div>  

                        <br><br>
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