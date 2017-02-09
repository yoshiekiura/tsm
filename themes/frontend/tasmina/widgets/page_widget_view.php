<?php if ($query->num_rows() > 0): ?>
<li class="col-md-3 col-sm-4 col-xs-6">
    <h4><?php echo $query->row('page_title'); ?></h4>
   	<?php echo $query->row('page_content'); ?>
</li>
<?php endif ?>