<!-- Contact Us Widget -->
<div class="footer-menu">
    <h4 class="title">Kontak Kami</h4>
    <ul>
        <?php
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row_contact_us) {
                $clearhtml = trim(strip_tags($row_contact_us->contact_us_content));
                if(filter_var($clearhtml, FILTER_VALIDATE_EMAIL)) {
                    $classname = 'envelope';
                    $action = 'mailto:' . $clearhtml;
                } else {
                    $classname = 'phone';
                    $action = 'javascript:void(0)';
                }
            ?>
                <li>
                    <a href="<?php echo $action ?>" class="tips" title="<?php echo $row_contact_us->contact_us_title ?>" data-original-title="<?php echo $row_contact_us->contact_us_title ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-<?php echo $classname ?> fa-stack-1x fa-inverse"></i>
                        </span>&nbsp; <?php echo $clearhtml ?>
                    </a>
                </li>
            <?php
            }
        } else {
            echo 'Maaf, Kontak kami belum dimuat.';
        }
        ?>
    </ul>
</div>
<!-- End Contact Us Widget -->