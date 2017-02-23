<h2>Detail Pesan Member</h2>
<br />
<?php
if(!empty($message_detail)) {
    $no = $offset + 1;
    echo '<div class="box">';
    foreach($message_detail as $row) {
        if($row->message_sender_network_id == $parent_sender_network_id){
            $style = 'style="text-align:right !important;"';
            $information = $parent_sender_network_code . ' / ' . stripslashes($parent_sender_member_name);
        }
        else {
            $style = 'style="text-align:left !important;"';
            $information = $parent_receiver_network_code . ' / ' . stripslashes($parent_receiver_member_name);
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