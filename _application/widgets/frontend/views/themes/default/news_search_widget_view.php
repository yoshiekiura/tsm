<form action="<?php echo base_url(); ?>news/search" method="post">
    <input type="text" id="search-txt" name="keyword" value="Search..." onfocus="if(this.value=='Search...') { this.value=''; }" onblur="if(this.value=='') { this.value='Search...'; }" />
    <input type="submit" id="search-btn" name="search" value=""/>
</form>