<?php
use CRM_Configchecker_ExtensionUtil as E;

/**
 * Configchecker.Verifyconfiguration API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_configchecker_Verifyconfiguration_spec(&$spec) {
//  $spec['magicword']['api.required'] = 1;
}

/**
 * Configchecker.Verifyconfiguration API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_configchecker_Verifyconfiguration($params) {
    return civicrm_api3_create_success([], $params, 'Configchecker', 'verifyconfiguration');
}
