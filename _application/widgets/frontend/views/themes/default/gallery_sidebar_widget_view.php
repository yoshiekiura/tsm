<?php
$slideshow_data = '';
if ($query_gallery->num_rows() > 0) {
    foreach ($query_gallery->result() as $row_gallery) {
        $image = $row_gallery->gallery_image;
        if ($image != '' && file_exists(_doc_root . _dir_gallery . 'thumb-' . $image)) {
            //$slideshow_data .= '<img src="' . base_url() . 'media/' . _dir_gallery . '200/150/' . 'thumb-' . $image . '" alt="' . $row_gallery->gallery_title . '" title="' . $row_gallery->gallery_title . '" />';
            $slideshow_data .= '<img src="' . base_url() . _dir_gallery . 'thumb-' . $image . '" alt="' . $row_gallery->gallery_title . '" width="200" height="150" title="' . $row_gallery->gallery_title . '" />';
        }
    }
}
?>
<a href="<?php echo base_url(); ?>gallery" title="Gallery">
    <div class="slideshow-gallery">
        <?php echo $slideshow_data; ?>
    </div>
</a>