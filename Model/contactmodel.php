<?php
// C:\wamp64\www\V\Model\contactmodel.php

class ContactModel {
    // Get admin email (returns the configured MAIL_FROM email)
    public function getAdminEmail() {
        // Returns the email configured in mailconfig.php
        // You can change MAIL_FROM in mailconfig.php to receive emails at a different address
        return defined('MAIL_FROM') ? MAIL_FROM : 'v4volunteering0000@gmail.com';
    }
}
?>