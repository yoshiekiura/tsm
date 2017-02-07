
<div id="block-news-list">
    <?php if($data_reward->num_rows() > 0) {
        echo '<ul class="list">';
            foreach($data_reward->result() as $row) {
                $member_qualified_reward = $this->function_lib->get_one('sys_reward_qualified','count(*)','reward_qualified_reward_id ="'.$row->reward_id.'" ');
                
                if($member_qualified_reward > 0) {
                    $member = ' ( Jumlah Member Qualified Reward : '.number_format($member_qualified_reward) .')';
                }else {
                    $member = '( Belum Ada Member Qualified Reward )';
                }
                
                if(!empty($row->reward_image)) {
                    $reward_image = '<img src="' . base_url() . 'media/' . _dir_reward . '180/300/' . $row->reward_image . '" class="img-responsive">';
                }else{
                    $reward_image = '<img src="' . base_url() . 'media/' . _dir_reward . '180/300/default.png " class="img-responsive">';
                }
                
                echo '<li>';
                    echo '<div class="row">';
                        echo '<div class="col-md-4">
                                   '.$reward_image.' 
                                </div>';
                        echo '<div class="col-md-8">
                                <div class="description">
                                    <h4>'.$row->reward_bonus.' <a href="'.base_url().'reward/member/'.$reward_type.'/'.$row->reward_id.'">'.$member.'</a></h4>
                                     
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
       