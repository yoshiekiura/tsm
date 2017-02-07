<h2>Detail Pesan Admin</h2>
<br />
<?php
if(!empty($message_detail)) {
    $no = $offset + 1;
    echo '<div class="box">';
    foreach($message_detail as $row) {
        if($row->message_sender_network_id == $parent_sender_network_id){
            $style = 'style="text-align:right !important;"';
            $information = $parent_sender_network_code . ' / ' . $parent_sender_member_name;
        }
        else {
            $style = 'style="text-align:left !important;"';
            $information = $parent_receiver_network_code . ' / ' . $parent_receiver_member_name . ' &nbsp;&nbsp;<i class="icon-comment"></i>';
        }
        
        echo '<div class="box-title" style="font-size:11pt; color:#0D638F;">';
        echo '<div style="float:left;">#' . $no . '&nbsp;&nbsp;~&nbsp;&nbsp;' . $information . '</div>';
        echo '<div style="float:right;"><small><i>' . convert_datetime($row->message_input_datetime, 'id') . '</i></small></div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';
        
        echo '<div class="box-body form">';
        echo '<div class="form-body">';
        echo '<div class="form-group">';
        echo '<div class="col-md-12">';
        echo '<div style="border-bottom:1px solid #ddd; margin-top:15px; margin-bottom:15px;">';
        echo '<h4>&raquo; ' . $row->message_title . '</h4>';
        echo '</div>';
        echo '<p>' . nl2br($row->message_content) . '</p><br />';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        $no++;
    }
    echo '</div>';
    
    echo '<div style="text-align:right;">' . $pagination . '</div>';
}
?>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Balas Pesan</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('network_code', $responder_code); ?>
        <?php echo form_hidden('message_par_id', $message_id); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('message_title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : 'Re: ' . $parent_message_title, 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Isi Pesan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('content', (isset($this->arr_flashdata['input_content'])) ? $this->arr_flashdata['input_content'] : '', 'cols="60" rows="10" class="form-control"'); ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Kirim</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>