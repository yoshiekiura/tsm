<div class="span8">
    <div class="titles">
        <div class="row-fluid">
            <h2><?php echo isset($page_title)?$page_title:'';?></h2>
        </div>
    </div>
    <div class="row-fluid">
        <img src="<?php echo $themes_url;?>/images/cekkartu.jpg">
        <div class="fancyform" style="margin-top: 10px;">
            <form action="" method="post" name="frm_cek">        
                <table class="table " style="width: 98%; color: #444;">
                    <tbody>
                        <tr>
                            <th colspan="3" style="color: #4f417c; background: #f3effb;">Cek Kartu Aktivasi</th>
                        </tr>
                        <tr>
                            <td width="80" align="right">Nomor Serial</td>
                            <td>
                                <input type="text" name="serial" id="serial" placeholder="Masukkan No Serial Anda" value="" style="width: 50%; margin-bottom: 10px;"><br>
                                <input id="button" name="cek" type="submit" value="Check Serial" class="btn btn-info">
                                <div class="clearfix"><br><br></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="result" style="margin: 30px 0 0px;">
                </div>								
            </form>
        </div>										
    </div>
</div>