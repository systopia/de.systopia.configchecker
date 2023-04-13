<?php

require_once 'configchecker.civix.php';
use CRM_Configchecker_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function configchecker_civicrm_config(&$config) {
  _configchecker_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function configchecker_civicrm_install() {
  _configchecker_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function configchecker_civicrm_enable() {
  _configchecker_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_check().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_check/
 */
function configchecker_civicrm_check(&$messages) {
  $php_checker = new CRM_Configchecker_VerifierPhp();
  $php_checker->php_config_warning($messages);
  $php_checker->php_version_warning($messages);
}

/**
 * Implements hook_civicrm_check().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_check/
 */
function configchecker_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  // TODO:check version of CLI and save it to settings.
  if ($apiRequest['entity'] == 'Job' && $apiRequest['action'] == 'execute') {
    $php_checker = new CRM_Configchecker_VerifierPhp();
    $php_checker->set_php_cli_version();
  }
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *

 // */
