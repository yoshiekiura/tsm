<div class="panel panel-default" id="block-list">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
    <?php if($data_reward->num_rows() > 0) {
        echo '<ul class="list">';
            foreach($data_reward->result() as $row) {
                $member_qualified_reward = $this->frontend_reward_model->get_member_qualified_reward($row->reward_id, FALSE, FALSE, TRUE);
                if($member_qualified_reward > 0) {
                    $text_msg = ' ( Jumlah Member Qualified Reward : '.number_format($member_qualified_reward) .')';
                } else {
                    $text_msg = '( Belum Ada Member Qualified Reward )';
                }
                
                if ($row->reward_image != '' && file_exists(_dir_reward . $row->reward_image)) {
                    $reward_image = '<a href="' . base_url() . _dir_reward . $row->reward_image . '" rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="img-effect img-thumbnail" style="width: 100%;"><img src="' . base_url() . 'media/' . _dir_reward . '360/360/' . $row->reward_image . '" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';
                } else {
                    $reward_image = '<a href="' . $themes_url . '/uploads/default.jpg" rel="prettyPhoto[rewards]" title="'.$row->reward_bonus.'" class="img-effect img-thumbnail" style="width: 100%;"><img src="' . $themes_url . '/uploads/default.jpg" alt="' . $row->reward_image . '" title="' . $row->reward_bonus . '" /></a>';
                }
                
                echo '<li>';
                    echo '<div class="row">';
                        echo '<div class="col-md-4">
                                   '.$reward_image.' 
                                </div>';
                        echo '<div class="col-md-8">
                                <div class="description">
                                    <h4>'.$row->reward_bonus.' <a href="'.base_url().'reward/member/'.$row->reward_id.'">'.$text_msg.'</a></h4>
                                     
                                    <p style="color: #666; margin-bottom: 15px;">
                                        '.$row->reward_note.'
                                    </p>
                                    
                                </div>
                            </div>';
                    echo '</div>';
                echo '</li>';
            }
        echo '</ul>';
    } ?>
    </div>
</div>