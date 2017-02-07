<form action="<?php echo base_url(); ?>products/search" method="post">
    <input type="text" name="keyword" value="product search..." onfocus="if(this.value=='product search...') this.value=''; this.className='text-search focus'" onblur="if(this.value=='') { this.value='product search...'; this.className='text-search blur'; }" class="text-search blur" />
    <input type="submit" name="search" value="GO" class="button-search" />
</form>