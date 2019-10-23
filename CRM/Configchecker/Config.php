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
 * Configurations
 */
class CRM_Configchecker_Config {

  private static $singleton = NULL;
  private static $settings  = NULL;

  /**
   * get the config instance
   */
  public static function singleton() {
    if (self::$singleton === NULL) {
      self::$singleton = new CRM_Mailingtools_Config();
    }
    return self::$singleton;
  }

  /**
   * Get a single setting
   *
   * @param $name          string setting name
   * @param $default_value mixed  default value
   * @return mixed setting
   */
  public function getSetting($name, $default_value = NULL) {
    $settings = self::getSettings();
    return CRM_Utils_Array::value($name, $settings, $default_value);
  }

  /**
   * get Configchecker settings
   *
   * @return array
   */
  public function getSettings() {
    if (self::$settings === NULL) {
      self::$settings = CRM_Core_BAO_Setting::getItem('de.systopia.Configchecker', 'Configchecker_settings');
    }

    return self::$settings;
  }

  /**
   * set Configchecker settings
   *
   * @param $settings array
   */
  public function setSettings($settings) {
    self::$settings = $settings;
    CRM_Core_BAO_Setting::setItem($settings, 'de.systopia.Configchecker', 'Configchecker_settings');
  }

  /**
   * Install a scheduled job if there isn't one already
   */
  public static function installScheduledJob() {
    $config = self::singleton();
    $jobs = $config->getScheduledJobs();
    if (empty($jobs)) {
      // none found? create a new one
      civicrm_api3('Job', 'create', array(
        'api_entity'    => 'Configchecker',
        'api_action'    => 'verifyconfiguration',
        'run_frequency' => 'Daily',
        'name'          => E::ts('Verify Configuration'),
        'description'   => E::ts('Verifies Configuration for e.g. PHP, and matches against configured values. In case of a difference, a notification email will be sent.'),
        'is_active'     => '0'));
    }
  }

  /**
   * get all scheduled jobs that trigger the dispatcher
   */
  public function getScheduledJobs() {
    if ($this->jobs === NULL) {
      // find all scheduled jobs calling Sqltask.execute
      $query = civicrm_api3('Job', 'get', array(
        'api_entity'   => 'Configchecker',
        'api_action'   => 'verifyconfiguration',
        'option.limit' => 0));
      $this->jobs = $query['values'];
    }
    return $this->jobs;
  }
}
