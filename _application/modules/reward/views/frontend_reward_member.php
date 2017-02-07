
<?php
if ($query_reward->num_rows() > 0) {
    $row = $query_reward->row();

    if ($row->reward_image != '' && file_exists(_dir_reward . $row->reward_image)) {
        $reward_image = '<a href="' . base_url() . _dir_reward . $row->reward_image . '" rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="thumbnail" style="width: 100%;"><img src="' . base_url() . 'media/' . _dir_reward . '360/360/' . $row->reward_image . '" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';

    } else {
        $reward_image = '<a href="' . base_url() . _dir_reward . 'default.png " rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="thumbnail" style="width: 100%;"><img src="' . base_url() . 'media/' . _dir_reward . '280/280/default.png" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';
    }
?>
    
<h4>Reward</h4>
<h2><?php echo $row->reward_bonus;?></h2>
<hr>
    
<div class="row">
    <div class="col-md-5">
    <?php echo $reward_image; ?>
    </div>
    <div class="col-md-7">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <strong class="required">SYARAT REWARD : </strong>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td width="130px"><strong>Jaringan Kiri</strong></td>
                        <td>: <?php echo $row->reward_cond_node_left;?> Member</td>
                    </tr>
                    <tr>
                        <td><strong>Jaringan Kanan</strong></td>
                        <td>: <?php echo $row->reward_cond_node_right;?> Member</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<br>
<?php
} 
?>

<?php if(!empty($query_member) ) {
    
?>
<h4><strong>DAFTAR MEMBER PENERIMA REWARD</strong></h4>
    <table class="table table-striped table-hover">
        <tr class="active">
            <th width="10%">No.</th>
            <th width="40%">Nama Member</th>
            
            <th width="30%">Tanggal Qualified Reward</th>
        </tr>
        <?php 
        $no =1;
        $offset = $this->uri->segment(5);
        foreach ($query_member as $list_member) { 
            $nomer = $offset + $no;
            echo '
                <tr>
                <td>'.$nomer.'</td>
                <td>'.$list_member->member_name.'</td>
                
                <td>'.convert_date($list_member->tanggal_reward,'id').'</td>
            </tr>';
            $no++;
        } ?>
    </table>
     <ul class="pagination">
        <?php echo $pagination;?>
    </ul>
    <?php 


} else {
    echo '<h2> Belum ada member yang qualified reward '.$row->reward_bonus.'</h2>';
}
?>
