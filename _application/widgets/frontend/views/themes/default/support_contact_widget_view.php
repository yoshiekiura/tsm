<ul>
    <?php
    if ($contact_yahoo_id != '') {
        echo '<li>' . ymstatus($contact_yahoo_id, base_url() . 'images/support/icon_yahoo_24x24_2_on.png', base_url() . 'images/support/icon_yahoo_24x24_2_off.png', 'Yahoo! Messenger') . '</li>';
    }
    if ($contact_skype_id != '') {
        echo '<li><a href="skype:' . $contact_skype_id . '?chat" type="application/x-skype" title="Skype Chat"><img src="' . base_url() . 'images/support/icon_skype_chat_24x24_2_on.png" /></a></li>';
    }
    ?>
</ul>