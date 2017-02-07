<div class="panel panel-default">
    <?php if (!empty($page_title)): ?>
    <div class="panel-heading"><h3><?php echo $page_title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <?php echo isset($page_content) ? $page_content : ''; ?>
    </div>														
</div>