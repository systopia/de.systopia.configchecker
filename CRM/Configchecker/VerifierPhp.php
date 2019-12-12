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
 * Class CRM_Configchecker_VerifierPhp
 */
class CRM_Configchecker_VerifierPhp extends CRM_Configchecker_VerifierBase {

  /**
   * CRM_Configchecker_VerifierPhp constructor.
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Verifies Config
   */
  public function verify_config() {
    $php_config = $this->get_settings("/check_php_config.*/");
    foreach ($php_config as $key => $php_value) {
      $this->verify_php_value($key, $php_value);
    }
  }

  /**
   * @param $php_config_name
   * @param $value
   * @param $result_array
   *
   */
  private function verify_php_value($php_config_name, $value) {

    $php_parameter = $this->parse_config_param($php_config_name);
    $system_php_val = ini_get($php_parameter);
    if ($system_php_val != $value) {
      $this->notifications[$php_parameter]['configured'] = $value;
      $this->notifications[$php_parameter]['system']     = $system_php_val;
      $this->log("Misconfigured PHP Config detected. Configured Value: {$value} != {$system_php_val} (php System value)");
    }
  }

  /**
   * @param $php_config_param
   *
   * @return mixed|null
   */
  private function parse_config_param($php_config_param) {
    $pattern = "/check_php_config_(?P<php_config>.*$)/";
    preg_match($pattern, $php_config_param, $matches);
    if (isset($matches['php_config'])) {
      return $matches['php_config'];
    }
    return NULL;
  }

  /**
   * @param $messages
   */
  public function php_version_warning(&$messages) {
    $config = CRM_Configchecker_Config::singleton();
    $configured_php_version = $config->getSetting('php_version');
    $live_php_version = $this->get_php_version();

    if ($configured_php_version != $live_php_version) {
      $warning = new CRM_Utils_Check_Message(
        'de.systopia.configchecker_php_version_missmatch',
        ts('PHP Version inconsistency detected between CLI and runtime. Please contact your admin'),
        ts('PHP Version inconsistency'),
        \Psr\Log\LogLevel::ALERT
      );
      $messages[] = $warning;
    }
  }

  public function set_php_cli_version() {
    $config = CRM_Configchecker_Config::singleton();
    $settings = $config->getSettings();
    $settings['php_version'] = $this->get_php_version();

    $config->setSettings($settings);
  }

  /**
   * @param $messages
   */
  public function php_config_warning(&$messages) {
    $this->verify_config();
    if (empty($this->notifications)) {
      return;
    }
    // create notification Message
    $notification_string = "<p>";
    foreach ($this->notifications as $php_config_param => $values) {
      $notification_string = $notification_string . "<li><b>{$php_config_param}</b>: Configured Value: {$values['configured']}, Detected System Value: {$values['system']}</li>";
    }
    $notification_string = $notification_string . "</p>";

    // notification object, see https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_check/
    $warning = new CRM_Utils_Check_Message(
      'de.systopia.configchecker_config_missmatch',
      $notification_string,
      ts('PHP Config mismach'),
      \Psr\Log\LogLevel::ALERT
    );
    $messages[] = $warning;
  }

  /**
   * @return string
   */
  public function get_php_version() {
    return phpversion();
  }
}
