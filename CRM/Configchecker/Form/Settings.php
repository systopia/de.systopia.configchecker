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
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Configchecker_Form_Settings extends CRM_Core_Form {
  public function buildQuickForm() {

    // get current settings
    $config = CRM_Mailingtools_Config::singleton();
    $current_values = $config->getSettings();

    // add form elements
    $this->add(
      'text',
      'check_config_notification_email',
      E::ts('Notification Email'),
      array("class" => "huge"),
      TRUE
    );

    // PHP config Parameters
    // currently suport
    // - max_execution_time
    // - memory_limit
    // - input_time
    //- max_file_uploads
    //- post_max_size
    $this->add(
      'text',
      'check_config_max_execution_time',
      E::ts('PHP Max Execution Time'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'text',
      'check_config_memory_limit',
      E::ts('PHP Memory Limit'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'text',
      'check_config_input_time',
      E::ts('PHP Input Time'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'text',
      'check_config_max_file_uploads',
      E::ts('PHP Max File Uploads'),
      array("class" => "huge"),
      FALSE
    );
    $this->add(
      'text',
      'check_config_post_max_size',
      E::ts('PHP Post Max Size'),
      array("class" => "huge"),
      FALSE
    );

    // set default values
    $this->setDefaults($current_values);

    // submit
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    parent::buildQuickForm();
  }

  public function postProcess() {
    $config = CRM_Configchecker_Config::singleton();
    $values = $this->exportValues();
    $settings = $config->getSettings();
    $settings_in_form = $this->getSettingsInForm();
    foreach ($settings_in_form as $name) {
      $settings[$name] = CRM_Utils_Array::value($name, $values, NULL);
    }
    $config->setSettings($settings);
    parent::postProcess();
  }

  /**
   * get the elements of the form
   * used as a filter for the values array from post Process
   * @return array
   */
  protected function getSettingsInForm() {
    return array(
      'check_config_notification_email',
      'check_config_max_execution_time',
      'check_config_memory_limit',
      'check_config_input_time',
      'check_config_max_file_uploads',
      'check_config_post_max_size',
    );
  }

}
