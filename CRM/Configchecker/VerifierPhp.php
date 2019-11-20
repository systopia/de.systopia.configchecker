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
      // TODO: remove
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

    $system_php_val = ini_get($this->parse_config_param($php_config_name));
    if ($system_php_val != $value) {
      $this->notifications[$php_config_name]['configured'] = $value;
      $this->notifications[$php_config_name]['system']     = $system_php_val;
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
}
