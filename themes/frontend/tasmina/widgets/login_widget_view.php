<?php if ($is_logged_in === FALSE): ?>
    <div class="well well-small widget-login" style="margin-bottom: 20px;">
        <table>
            <tbody>
                <tr valign="top">
                    <td width="30%"><img src="<?php echo base_url($themes_url) ?>/images/bg_login.png"></td>
                    <td><small class="caption">Anda dapat mengakses akun anda melalui Form Login Member dibawah ini :</small></td>
                </tr>
            </tbody>
        </table>

        <?php
        if (isset($this->arr_flashdata['login_widget_message'])) {
            echo $this->arr_flashdata['login_widget_message'];
        }
        ?>

        <form action="<?php echo base_url(); ?>voffice/login/verify" method="post">
            <?php echo form_hidden('uri_string', uri_string()); ?>      
            <center>
                <table width="100%" class="table">
                    <tbody>
                        <tr>
                            <td>
                                <input name="username" size="50" value="" maxlength="50" type="text" placeholder="Member Name" style="margin-bottom: 0;" class="form-control">
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <input name="password" size="50" value="" maxlength="50" type="password" placeholder="Password" style="margin-bottom: 0;" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?php echo site_url('voffice/login/captcha/widget'); ?>" style="margin-right: 8px; border: 1px solid #DDD;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="kode_unik" size="20" value="" maxlength="20" type="text" placeholder="Kode Unik" style="width:50%; margin-bottom: 0;" class="form-control">
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Login">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </form> 
    </div>
    <script>
        $(function() {
            $("#captcha_reload").click(function() {
                var url = '<?php echo site_url('voffice/login/captcha/widget'); ?>';
                $("#captcha_image").attr('src', url + '?' + Math.random());
            });
        });
    </script>
<?php endif ?>