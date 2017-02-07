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
                    <div class="panel-heading"><h3>Berita</h3></div>
                    <div class="panel-body">
                        <h2 class="title">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h2>
                        <br>
                        <span><i class="fa fa-calendar"></i>&nbsp;<small>Jumat, 14 November 2014</small>&nbsp;</span> | &nbsp; 
                        <span><i class="fa fa-clock-o"></i>&nbsp; <small>16.02 WIB</small>&nbsp;</span> | &nbsp; 
                        <span><i class="fa fa-gear"></i>&nbsp; <small><a href="./news_list.php">Berita</a></small>&nbsp;</span> | &nbsp; 
                        <hr>
                        <p style="text-align: left; color: #333;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                        <br>
                        <img src="uploads/news/mekkah.jpg">
                        <br><br>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                        <br>
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