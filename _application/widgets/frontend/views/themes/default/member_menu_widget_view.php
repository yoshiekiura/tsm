<?php if ($show_menu == true): ?>
    <br />
    <div class="sbar-title">Member Menu</div>
    <ul class="accordion">
        <li><a href="<?php echo base_url(); ?>member/profile">Profile</a></li>
        <li><a href="<?php echo base_url(); ?>member/password">Password Change</a></li>
        <li><a href="<?php echo base_url(); ?>member/logout"><font color="#990000">Sign Out</font></a></li>
    </ul>
<?php endif; ?>
