<?php if (!empty($query)) {?>
<div id="main-slider">
    <div class="slide carousel" id="carousel-slide">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php
            foreach ($query as $_slide_i => $row_slider) {
                if (!empty($row_slider->slider_image) && file_exists(_dir_slider . $row_slider->slider_image)) {
                    $image = base_url(_dir_slider . $row_slider->slider_image);
                } else {
                    $image = '';
                }
                ?>

                <div class="item <?php if($_slide_i==0){echo 'active';} ?>">
                    <img src="<?php echo $image ?>" alt="<?php echo $row_slider->slider_title ?>">
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-slide" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-slide" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<?php } ?>