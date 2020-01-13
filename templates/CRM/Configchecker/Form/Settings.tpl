{*-------------------------------------------------------+
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
+-------------------------------------------------------*}

<br/><h3>{ts domain='de.systopia.configchecker'}Configchecker  - Notification Settings{/ts}</h3><br/>

<div class="crm-section configchecker configchecker">
  <div class="crm-section">
    <div class="label">{$form.send_notification_mail.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Send Notification Emails{/ts}", {literal}{"id":"id-configchecker-send-notifications","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.send_notification_mail.html}</div>
    <div class="clear"></div>
  </div>

  <div class="crm-section">
    <div class="label">{$form.check_config_notification_email.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification Email{/ts}", {literal}{"id":"id-configchecker-notification-email","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_config_notification_email.html}</div>
    <div class="clear"></div>
  </div>

  <div class="crm-section">
    <div class="label">{$form.check_config_notification_from_email.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification From Email{/ts}", {literal}{"id":"id-configchecker-notification-from-email","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_config_notification_from_email.html}</div>
    <div class="clear"></div>
  </div>

  <br/>
  <h3>{ts domain='de.systopia.configchecker'}Expected PHP Configuration{/ts}</h3><br/>

  <div class="crm-section">
    <div class="label">{$form.check_php_config_max_execution_time.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification Email{/ts}", {literal}{"id":"id-configchecker-max_execution_time","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_php_config_max_execution_time.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.check_php_config_memory_limit.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification Email{/ts}", {literal}{"id":"id-configchecker-memory_limit","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_php_config_memory_limit.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.check_php_config_max_input_time.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification Email{/ts}", {literal}{"id":"id-configchecker-input_time","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_php_config_max_input_time.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.check_php_config_upload_max_filesize.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}Notification Email{/ts}", {literal}{"id":"id-configchecker-max_file_uploads","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_php_config_upload_max_filesize.html}</div>
    <div class="clear"></div>
  </div>
  <div class="crm-section">
    <div class="label">{$form.check_php_config_post_max_size.label} <a onclick='CRM.help("{ts domain='de.systopia.configchecker'}PHP Check{/ts}", {literal}{"id":"id-configchecker-post_max_size","file":"CRM\/Configchecker\/Form\/Settings"}{/literal}); return false;' href="#" title="{ts domain='de.systopia.configchecker'}Help{/ts}" class="helpicon">&nbsp;</a></div>
    <div class="content">{$form.check_php_config_post_max_size.html}</div>
    <div class="clear"></div>
  </div>
</div>

<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
