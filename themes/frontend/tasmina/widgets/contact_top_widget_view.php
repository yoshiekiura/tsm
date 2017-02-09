<!-- Contact Us Top Widget -->
<ul class="sosmed">
    <?php
    if ($query->num_rows() > 0) {

        foreach ($query->result() as $row_contact_us) {
            $clearhtml = trim(strip_tags($row_contact_us->contact_us_content));
            if(filter_var($clearhtml, FILTER_VALIDATE_EMAIL)) {
                $classname = 'envelope';
                $action = 'mailto:' . $clearhtml;
            } else {
                $classname = 'phone';
                $action = '#';
            }
        ?>
            <li>
                <span><i class="fa fa-<?php echo $classname ?>"></i> <?php echo $row_contact_us->contact_us_title ?></span> <a style="color: #6d0019;" href="<?php echo $action ?>"><?php echo $clearhtml ?></a>
            </li>
        <?php
        }
    } else {
        echo 'Maaf, Kontak kami belum dimuat.';
    }
    ?>
</ul>
<!-- End Contact Us Top Widget -->