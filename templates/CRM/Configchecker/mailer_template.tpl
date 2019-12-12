<h2>CiviCRM Alert for Config changes on {$hostname}</h2>


<table style="width: 80%; table-layout: fixed;  border-collapse: collapse;">
  <thead>
  <tr>
    <th style="text-align: left;min-width: 500px; border: 1px solid black; padding: 0.5em;">Config Attribut</th>
    <th style="text-align: left;min-width: 300px; border: 1px solid black; padding: 0.5em;">Configured</th>
    <th style="text-align: left;min-width: 300px; border: 1px solid black; padding: 0.5em;">System</th>
  </tr>
  </thead>
  <tbody>
  {foreach from=$change_data item=cf_value key=cf_name}
    <tr>
      <th style="text-align: left;min-width: 500px; border: 1px solid black; padding: 0.5em;">{$cf_name}</th>
      <td style="text-align: left;min-width: 300px; border: 1px solid black; padding: 0.5em;">{$cf_value.configured}</td>
      <td style="text-align: left;min-width: 300px; border: 1px solid black; padding: 0.5em;">{$cf_value.system}</td>
    </tr>
  {/foreach}
  </tbody>

</table>
