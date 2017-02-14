<div class="panel panel-default" id="block-list">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <?php
        if ($query_reward->num_rows() > 0) {
            $row = $query_reward->row();
            $reward_bonus = $row->reward_bonus;

            if ($row->reward_image != '' && file_exists(_dir_reward . $row->reward_image)) {
                $reward_image = '<a href="' . base_url() . _dir_reward . $row->reward_image . '" rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="thumbnail" style="width: 100%;"><img src="' . base_url() . 'media/' . _dir_reward . '360/360/' . $row->reward_image . '" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';
            } else {
                $reward_image = '<a href="' . $themes_url . '/uploads/default.jpg" rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="thumbnail" style="width: 100%;"><img src="' . $themes_url . '/uploads/default.jpg" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';
            }
        ?>
        
        <div class="row-fluid" style="margin-top: 10px;">
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
    </div>
    <div class="panel-footer">
        <?php if(count($data_member_qualified) > 0) { ?>
        <h4><strong>DAFTAR MEMBER PENERIMA REWARD</strong></h4>
            <table class="table table-striped table-hover">
                <tr class="active">
                    <th width="10%">No.</th>
                    <th width="40%">Nama Member</th>
                    <th width="30%">Tanggal Qualified Reward</th>
                </tr>
                <?php 
                $no =1;
                $offset = $this->uri->segment(4);
                foreach ($data_member_qualified as $list_member) { 
                    $nomer = $offset + $no;
                    echo '
                        <tr>
                        <td>'.$nomer.'</td>
                        <td>'.$list_member->member_name.'</td>
                        <td>'.convert_date($list_member->tanggal_claim, 'id').'</td>
                    </tr>';
                    $no++;
                } ?>
            </table>
             <ul class="pagination">
                <?php echo $pagination;?>
            </ul>
            <?php 
        } else {
            echo '<h3> Belum ada member yang qualified reward '.$reward_bonus.'</h3>';
        }
        
    } else {
        $reward_bonus = '';
        echo '<div class="row-fluid text-center" style="padding-top: 10px;"><div class="col-md-12"><h3>Reward Tidak Ditemukan</h3></div></div>';
    }
    ?>
    </div>
</div>