<?php if ($rs_slider != false) : ?>
    <div id="slider-image" class="nivoSlider">
        <?php
        $i = 1;
        foreach ($rs_slider as $row_slider) {
            echo '<img src="'._dir_slider.$row_slider->slider_image.'" alt="Image '.$i.'" border="0" />';
            $i++;
        }
        ?>
    </div>
<?php endif; ?>