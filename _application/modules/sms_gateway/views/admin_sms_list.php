<script type="text/javascript">
function check_all(form_name, input_name, start) {
  master = document.getElementById(input_name);
  form_obj = document.getElementById(form_name);

  i = start;
  input_element = input_name + "["+ i +"]";
  input_obj = document.getElementById(input_element);
  while(input_obj != null)
  {
    input_obj = document.getElementById(input_element);
    input_obj.checked = master.checked;

    i = i + 1;
    input_element = input_name + "["+ i +"]";
    input_obj = document.getElementById(input_element);
  }
}
</script>
<?php
$no = $this->uri->segment(7,0) + 1;
?>
<h2>Daftar SMS</h2>
<form action="<?php echo base_url() ?>admin/sms_gateway/sms_list" method="post" name="search_form">
    <table class="table table-striped table-hover" id="table-search" cellpadding="0" cellspacing="0" width="100%">
        <tr class="title warning"><th colspan="2">Form Pencarian</th></tr>
        <tr>
            <td>Kata Kunci</td>
            <td>
                <div class="input-append">
                    <div class="col-md-6  offset-0">
                        <input type="text" name="search_value" value="<?php if ($this->uri->segment(5)) echo $this->uri->segment(5); ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="search_option" class="form-control">
                                <option value="network_mid"<?php if ($this->uri->segment(6) == 'network_mid') echo " selected=\"selected\" "; ?>>Member ID</option>
                                <option value="member_name"<?php if ($this->uri->segment(6) == 'member_name') echo " selected=\"selected\" "; ?>>Nama</option>
                                <option value="member_mobilephone"<?php if ($this->uri->segment(6) == 'member_mobilephone') echo " selected=\"selected\" "; ?>>No HP</option>
                            </select>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Tipe SMS</td>
            <td>
                <div class="input-append">
                    <div class="col-md-2">
                        <div class="input-group">
                            <select name="sms_type" class="form-control">
                                <option value="0">Semua</option>
                                <option value="single"<?php if ($this->uri->segment(4) == 'single') echo " selected=\"selected\" "; ?>>Personal</option>
                                <option value="broadcast"<?php if ($this->uri->segment(4) == 'broadcast') echo " selected=\"selected\" "; ?>>Broadcast</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6  offset-0"><button type="submit" name="search" value="Cari" class="btn btn-success"><span>Cari</span></button></div>
                </div>
            </td>
        </tr>
    </table>
</form>
<hr>
<br />
<form action="" method="post" name="list">
    <div style="float:left;" class="btn-group">
        <button type="submit" name="form_single" value="Kirim SMS" class="btn btn-primary"><span>Kirim SMS</span></button>
        <button type="submit" name="form_broadcast" value="Kirim Broadcast" class="btn btn-primary"><span>Kirim Broadcast</span></button>
        <button type="submit" name="delete" value="Hapus" class="btn btn-danger"><span>Hapus</span></button>
    </div><div class="clearfix"></div>
  <br />
  <table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
    <thead>
      <tr align="center" class="title warning">
        <th width="15"><input class="checkbox" type="checkbox" name="item" id="item" onclick="check_all('list', 'item', <?php echo $no;?>)" /></th>
        <th width="15">#</th>
        <th width="110">Member ID</th>
        <th>Nama</th>
        <th width="120">No HP</th>
        <th>Pesan</th>
        <th width="140">Tanggal</th>
      </tr>
    </thead>
    <tbody>
<?php
if($sms_list)
{
  foreach($sms_list as $row)
  {
      $content = substr($row['sms_gateway_content'], 0, 50);
    ?>
      <tr>
        <td align="center" style="padding:2px; "><input type="checkbox" name="item[<?php echo $no; ?>]" id="item[<?php echo $no; ?>]" value="<?php echo $row['sms_gateway_id']; ?>"></td>
        <td align="right" style="padding:2px; "><?php echo $no; ?>.</td>
        <td align="center" style="padding:2px; "><?php echo $row['network_code']; ?></td>
        <td style="padding:2px; "><?php echo $row['member_name']; ?></td>
        <td style="padding:2px; "><?php echo $row['sms_gateway_mobilephone']; ?></td>
        <td style="padding:2px; "><?php echo $row['sms_gateway_content']; ?></td>
        <td align="center" style="padding:2px; "><?php echo $row['sms_gateway_datetime']; ?></td>
      </tr>
    <?php
    $no++;
  }
}
?>
      <tr class="footer"><td colspan="7" align="right"><div class="pagination">&nbsp;<?php echo $paging; ?></div></td></tr>
    </tbody>
  </table>
</form>