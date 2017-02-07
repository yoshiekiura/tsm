<?php if ($rs_links != false) : ?>
    <div class="footer-box" id="fsocnet">
        <h1>SOCIAL NETWORKING</h1>
        <ul>
    <?php
    foreach ($rs_links as $row_links) {
        echo '<li><a href="' . $row_links->links_url . '" target="_blank" title="' . $row_links->links_description . '">' . $row_links->links_title . '</a></li>';
    }
    ?>
        </ul>
    </div>
<?php endif; ?>