<?php $this->load->view('template/header_2'); ?>

<!-- Main -->
<div id="main-container">
    <div class="container">
        <div id="title-bar">
            <div class="container">
                <br>
                <h3 style="text-align: center;padding-bottom: 0;">Login Member Area</h3>
            </div>
        </div>

        <!-- widget Login -->
        <div class="panel panel-default" id="widget-login">
            <div class="panel-heading">
                <h4><small>LOGIN</small> MEMBER AREA</h4>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">
                        <?php
                        if (isset($this->arr_flashdata['confirmation'])) {
                            echo '<div class="alert alert-danger">' . $this->arr_flashdata['confirmation'] . '</div>';
                        }
                        ?>
                        <form action="<?php echo base_url(); ?>voffice/login/verify" method="post" role="form" class="login-form">
                            <?php echo form_hidden('uri_string', uri_string()); ?>      
                            <div class="form-group">
                                <label for="memberid">Kode Member</label>
                                <input name="username" size="50" value="" maxlength="50" type="text" placeholder="Kode Member" style="margin-bottom: 0;" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="passwordid">Password</label>
                                <input name="password" size="50" value="" maxlength="50" type="password" placeholder="Password" style="margin-bottom: 0;" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="securecode">Kode Unik</label><br>
                                <img src="<?php echo site_url('voffice/login/captcha/widget'); ?>" style="margin-right: 8px; border: 1px solid #DDD;"><br>
                                <input name="kode_unik" size="20" value="" maxlength="20" type="text" placeholder="Kode Unik" style="width:50%; margin-bottom: 0;" class="form-control" autocomplete="off">
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Login">Login Member&nbsp;&crarr;</button>
                        </form>
                    </div>

                    <div class="col-md-5">
                        <center><img src="<?php echo base_url('assets/images/site/' . $this->site_configuration['logo']); ?>" style="margin-top: 5px;height:100px;"></center>
                        <br><br>
                        <p>Silahkan masukkan Member ID dan password anda, untuk masuk ke halaman virtual office member.</p>
                        <br>
                        <!-- <a href="#" class="btn btn-default btn-block"><i class="glyphicon glyphicon-question-sign"></i>&nbsp; Lupa Password?</a> -->
                        <!-- <a href="#" class="btn btn-default btn-block"><i class="glyphicon glyphicon-cog"></i>&nbsp; Kontak Admin</a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- widget Login -->
    </div>
    <!-- end container -->

    <?php
    $frontend_widget = new widget();
    $frontend_widget->run('widget/frontend_billboard_widget');
    ?>
</div>
<!-- /Main -->

<?php $this->load->view('template/footer'); ?>