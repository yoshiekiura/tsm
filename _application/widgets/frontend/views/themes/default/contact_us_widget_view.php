<?php echo $this->session->flashdata('confirmation'); ?>
<br />
<h3>List Your Data Below</h3>
<?php echo form_open('page/act_contactus', array('class' => 'form')); ?>
<p>
    <label for="name">Full Name <small>&nbsp;(required)</small></label><br />
    <?php echo form_dropdown('title', $options_title, $member_title, 'id="title"'); ?>
    <?php echo form_input('name', $member_name, 'id="name" style="width:322px;"'); ?>
</p>
<p>
    <label for="email">E-mail <small>&nbsp;(required)</small></label><br />
    <?php echo form_input('email', $member_email, 'id="email" style="width:300px;"'); ?>
</p>
<p>
    <label for="company">Company</label><br />
    <?php echo form_input('company', $member_company, 'id="company" style="width:400px;"'); ?>
</p>
<p>
    <label for="main_business">Main Business</label><br />
    <?php echo form_textarea('main_business', $member_main_business, 'id="main_business"'); ?>
</p>
<p>
    <label for="country_id">State <small>&nbsp;(required)</small></label><br />
    <?php echo form_dropdown('country_id', $options_country, $member_country_id, 'id="country_id" style="width:420px;"'); ?>
</p>
<p>
    <label for="telephone">Phone Number</label><br />
    <?php echo form_input('telephone', $member_telephone, 'id="telephone" style="width:200px;"'); ?>
</p>
<p>
    <label for="interest">Interest <small>&nbsp;(required)</small></label><br />
    <?php echo form_textarea('interest', '', 'id="interest" style="height:200px;"'); ?>
</p>
<p>
    <?php echo form_submit('submit', 'Send'); ?>
</p>
<?php echo form_close(); ?>