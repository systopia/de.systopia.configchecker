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
 * Class CRM_Configchecker_Mailer
 */
class CRM_Configchecker_Mailer {

  private $template_name = 'config_checker_template';
  private $template_subject = 'Config Checker Alert for ';
  private $email_name_from         = 'CiviCRM Alerts';
  private $sender_contact_id = '2';
  private $email_from;
  private $notification_email;

  private $baseUrl = NULL;

  /**
   * CRM_Configchecker_Mailer constructor.
   *
   * @param null $template_name
   */
  public function __construct($template_name = NULL, $template_subject = NULL) {
    if (!empty($template_name)) {
      $this->template_name = $template_name;
    }
    if (!empty($template_subject)) {
      $this->template_subject = $template_subject;
    }
    $config = CRM_Configchecker_Config::singleton();
    $base_url = $this->getBaseUrl();

    $this->template_subject = $this->template_subject . $base_url;

    $email_address = $config->getSetting('check_config_notification_email');
    $email_from_address = $config->getSetting('check_config_notification_from_email');
    if (empty($email_address) || empty($email_from_address)) {
      throw new Exception("No notification or sender Address configured.");
    }
    $this->notification_email = $email_address;
    $this->email_from = $email_from_address;
  }

  /**
   * sends a notification email to the configured email address
   * @param $notification_content
   *
   * @return bool
   * @throws \CiviCRM_API3_Exception
   */
  public function send_mail($notification_content) {
    if (!$this->need_notificaton()) {
      return FALSE;
    }
    $values = [];
    $values['to_name'] = 'Alert Receiver';
    $values['to_email'] = $this->notification_email;
    $values['id'] = $this->get_template();
    $values['from'] = $this->email_from;
    $values['contact_id'] = $this->sender_contact_id;
    $values['template_params'] = $this->get_smarty_variables($notification_content);

    $result = civicrm_api3('MessageTemplate', 'send', $values);
    if ($result['is_error'] == '1') {
      throw new Exception("API Error sending Emails to {$this->template_name}");
    }
    $this->set_last_mailing_time();
    return TRUE;
  }

  /**
   * Checks if a notification is needed. Default setting is send one Mail every 24h
   * TODO: make the 24h configurable
   * @return bool
   */
  private function need_notificaton() {
    $config = CRM_Configchecker_Config::singleton();
    $last_notification_time = $config->getSetting('last_email_sent');
    if (!isset($last_notification_time)) {
      return TRUE;
    }
    if ((time() - $last_notification_time) < 86400) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * sets the timestamp for the last mailing time
   */
  private function set_last_mailing_time() {
    $config = CRM_Configchecker_Config::singleton();
    $settings = $config->getSettings();
    $settings['last_email_sent'] = time();
    $config->setSettings($settings);
  }

  /**
   * Gathers Smarty variables
   * @param $notification_content
   *
   * @return array
   */
  private function get_smarty_variables($notification_content) {
    $smarty_vars = [];
    $smarty_vars['change_data'] = $notification_content;
    $smarty_vars['hostname'] = $this->baseUrl;
    return $smarty_vars;
  }

  private function get_template() {
    $result = civicrm_api3('MessageTemplate', 'get', array(
      'sequential' => 1,
      'msg_title' => $this->template_name,
    ));
    if ($result['count'] > '1' || $result['is_error'] == '1') {
      throw new Exception("Error determining Email Template for {$this->template_name}.");
    }
    if ($result['count'] == '0') {
      return $this->create_template();
    }
    return $result['id'];
  }

  /**
   * @param $template_name
   * @param $subject
   *
   * @return mixed
   * @throws \CiviCRM_API3_Exception
   */
  private function create_template() {
    $template_content = file_get_contents(__DIR__ . "/../../templates/CRM/Configchecker/mailer_template.tpl");
    $result = civicrm_api3('MessageTemplate', 'create', [
      'sequential'  => 1,
      'msg_title'   => $this->template_name,
      'msg_html'    => $template_content,
      'msg_subject' => $this->template_subject,
    ]);
    if ($result['is_error'] == '1') {
      throw new Exception("Couldn't create message template.");
    }
    return $result['id'];
  }

  /**
   * @return string|NULL
   */
  private function getBaseUrl() {
    if ($this->baseUrl === NULL) {
      $this->baseUrl = parse_url(CIVICRM_UF_BASEURL, PHP_URL_HOST);
      return $this->baseUrl;
    }
    return $this->baseUrl;
  }

  /**
   * @param $message
   */
  protected function log($message) {
    CRM_Core_Error::debug_log_message("[de.systopia.configchecker] " . $message);
  }
}
