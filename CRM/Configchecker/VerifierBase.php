<?php
/*-------------------------------------------------------+
| SYSTOPIA Configchecker Extension                        |
| Copyright (C) 2019 SYSTOPIA                            |
| Author: P. Batroff (batroff@systopia.de)               |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

use CRM_Configchecker_ExtensionUtil as E;

/**
 * Verifier
 */
abstract class CRM_Configchecker_VerifierBase {

  protected $notifications;

  /**
   * CRM_Configchecker_VerifierBase constructor.
   */
  public function __construct() {
    $this->notifications = [];
  }

  /**
   * Gets all php related settings
   * @return mixed
   */
  abstract public function verify_config();

  /**
   * @return bool
   * @throws \Exception
   */
  public function send_notifications() {

    $config = CRM_Configchecker_Config::singleton();
    if (empty($this->notifications) || !$config->getSetting('send_notification_mail')) {
      return FALSE;
    }
    $mailer = new CRM_Configchecker_Mailer();
    // send mail
    $mailer->send_mail($this->notifications);
    return TRUE;
  }

  /**
   * @param $pattern
   *
   * @return array
   */
  protected function get_settings($pattern) {
    $config = CRM_Configchecker_Config::singleton();
    $settings = $config->getSettings();
    $result_settings = [];
    foreach ($settings as $key => $setting) {
      if (preg_match($pattern, $key, $matches)) {
        $result_settings[$key] = $setting;
      }
    }
    return $result_settings;
  }

  /**
   * @return bool
   */
  public function has_notifications() {
    if (empty($this->notifications)) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * @param $message
   */
  protected function log($message) {
    CRM_Core_Error::debug_log_message("[de.systopia.configchecker] " . $message);
  }

}
