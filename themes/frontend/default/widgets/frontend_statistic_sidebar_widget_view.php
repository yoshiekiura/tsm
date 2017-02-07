<span style="font-weight: bold; font-size: 16px;">Member Hari ini:</span>
<h1><?php echo $member_today;?></h1>

<div class="control-group" style="margin-top: 10px;">
    <div class="controls">
        <div class="input-prepend">
            <span class="add-on">
                <i class="icon-user-md"></i>
                <label class="control-label" for="inputIcon">Total Member</label>
            </span>
            <input class="span2 data-stats" id="inputIcon" type="text" disabled="disabled" value="<?php echo $total_member;?>">
        </div>

        <div class="input-prepend">
            <span class="add-on">
                <i class="icon-user-md"></i>
                <label class="control-label" for="inputIcon">Total Kunjungan</label>
            </span>
            <input class="span2 data-stats" id="inputIcon" type="text" disabled="disabled" value="<?php echo $this->statistik->GrandTotal();?>">
        </div>									
    </div>
</div>