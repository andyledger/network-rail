<?php

/**
* General purpose hook that runs before all form actions, so we can still modify the submission object that is passed to actions.
*/

add_action( 'hf_process_form', function( $form, $submission ) {
  $title = get_the_title($form->id);

  $query = '';

  if (array_key_exists('QUERY', $submission->data)) {
    $query = $submission->data['QUERY'];
  }
  
  // prepare all headers
  $AFFECTED = '';
  $CATEGORY = '';
  $ITEM = '';
  $PRIORITY = '';
  $REPORTING = '';
  $SERIOUS = '';
  $SERV_DEPT = '';

  switch ($title) {
    case 'EAM Support Request': {

      $AFFECTED = 'EEWUSER_EXT';
      $CATEGORY = 'PROBLEM';
      $ITEM = 'ENTERPRISEASSETMANAGEMENT';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'EEWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = '2ND LINE EBUS';

      switch ($query) {
        case 'An error is displayed when I try to access Portal.': {
          $ITEM = 'PORTAL';
          break;
        }
        case 'My Portal password needs resetting.': {
          $CATEGORY = 'PASSWORD';
          $ITEM = 'PORTAL';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case 'I can access Portal but an error is occurring when I try to log into eBusiness suite/Oracle EAM.': {
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case 'I can access Portal but my password needs resetting for eBusiness suite/Oracle EAM.': {
          $CATEGORY = 'PASSWORD';
          $ITEM = 'SYSADMIN';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case 'I have logged on correctly my but Portal connection has disconnected unexpectedly.': {
          $ITEM = 'PORTAL';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case 'I am experiencing poor performance.': {
          $CATEGORY = 'PERFORMANCE';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case 'I am having a technical problem with Oracle and receiving system errors.': {
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'CRM Support Request': {

      switch ($query) {
        case 'I have forgotten my portal password.': {
          $AFFECTED = 'ECWUSER_EXT';
          $REPORTING = 'ECWUSER_EXT';
          $ITEM = 'PORTAL';
          $CATEGORY = 'PASSWORD';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
        }
        case 'I cannot access portal due to errors.': {
          $AFFECTED = 'ECWUSER_EXT';
          $REPORTING = 'ECWUSER_EXT';
          $ITEM = 'PORTAL';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = '2ND LINE EBUS';
        }
        case 'I have forgotten my eBusiness password.': {
          $AFFECTED = 'ECWUSER_EXT';
          $REPORTING = 'ECWUSER_EXT';
          $ITEM = 'SYSADMIN';
          $CATEGORY = 'PASSWORD';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
        }
        case 'I can access portal but get an error message logging into eBusiness.': {
          $AFFECTED = 'ECWUSER_EXT';
          $REPORTING = 'ECWUSER_EXT';
          $ITEM = 'PORTAL';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = '2ND LINE EBUS';
        }
        case 'I am having a technical problem with Oracle and receiving system errors.': {
          $AFFECTED = 'ECWUSER_EXT';
          $REPORTING = 'ECWUSER_EXT';
          $ITEM = 'CUSTOMERRELATIONS';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = '2ND LINE EBUS';
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'iSupplier Support Request': {

      $AFFECTED = 'ESWUSER_EXT';
      $CATEGORY = 'PASSWORD';
      $ITEM = 'ISUPPLIER';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'ESWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = 'EBUS SOLUTIONS';

      switch ($query) {
        case 'I do not have an account and need access on behalf of my Company.': {
          $CATEGORY = 'ACCESS';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I need to make an amendment to my account.': {
          $CATEGORY = 'AMEND ACCOUNT';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I have forgotten my Portal Username and/or password.': {
          $ITEM = 'PORTAL';
          break;
        }
        case 'I have forgotten my Oracle eBusiness Suite Password.': {
          $ITEM = 'SYSADMIN';
          break;
        }
        case 'I need assistance navigating through the iSupplier tool to view invoices.': {
          $CATEGORY = 'HOW DO I';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I cannot access Portal due to error messages.': {
          $CATEGORY = 'PROBLEM';
          $ITEM = 'PORTAL';
          $SERV_DEPT = '2ND LINE EBUS';
          break;
        }
        case 'I am having a technical problem with Oracle eBusiness Suite and receiving system errors.': {
          $CATEGORY = 'PROBLEM';
          $SERV_DEPT = '2ND LINE EBUS';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'Oracle Sourcing Support Request': {

      $AFFECTED = 'ESWUSER_EXT';
      $CATEGORY = 'PASSWORD';
      $ITEM = 'ORACLESOURCING';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'ESWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = 'EBUS SOLUTIONS';

      switch ($query) {
        case 'I do not have an account and need access on behalf of my Company.': {
          $CATEGORY = 'ACCESS';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I need to make an amendment to my account.': {
          $CATEGORY = 'AMEND ACCOUNT';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I have forgotten my Portal username and/or password.': {
          $ITEM = 'PORTAL';
          break;
        }
        case 'I have forgotten my Oracle eBusiness Suite Password.': {
          $ITEM = 'SYSADMIN';
          break;
        }
        case 'I need assistance navigating around Oracle Sourcing to view tenders.': {
          $CATEGORY = 'HOW DO I';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I need assistance with uploading a quote and responding to a RFI/RFQ.': {
          $CATEGORY = 'HOW DO I';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case 'I cannot access Portal due to error messages.': {
          $ITEM = 'PORTAL';
          $CATEGORY = 'PROBLEM';
          $SERV_DEPT = '2ND LINE EBUS';
          break;
        }
        case 'I am having a technical problem with Oracle eBusiness Suite and receiving system errors.': {
          $CATEGORY = 'PROBLEM';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'Careers Support Request': {

      $AFFECTED = 'ERWUSER_EXT';
      $CATEGORY = 'PASSWORD';
      $ITEM = 'IRECRUITMENT (IREC)';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'ERWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = 'EBUS SOLUTIONS';

      switch ($query) {
        case 'I am having problems signing in, I have forgotten my password.': {
          break;
        }
        case 'The recruitment site is unavailable.': {
          $CATEGORY = 'PROBLEM';
          $SERV_DEPT = '2ND LINE EBUS';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'iRecruitment Agency Support Request': {

      $AFFECTED = 'ERWUSER_EXT';
      $CATEGORY = 'PROBLEM';
      $ITEM = 'IRECRUITMENT (IREC)';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'ERWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = '2ND LINE EBUS';

      switch ($query) {
        case "I have forgotten my Portal Username and/or password.": {
          $ITEM = 'PORTAL';
          $CATEGORY = 'PASSWORD';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I have forgotten my Oracle eBusiness Suite username and/or password.": {
          $ITEM = 'SYSADMIN';
          $CATEGORY = 'PASSWORD';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I cannot access Portal due to error messages.": {
          $ITEM = 'PORTAL';
          break;
        }
        case "I cannot access Oracle eBusiness Suite due to error messages.": {
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I am having a technical problem with Oracle and receiving system errors.": {
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'iReceivables Support Request': {

      $AFFECTED = 'EC2CWUSER_EXT';
      $CATEGORY = 'PASSWORD';
      $ITEM = 'RECEIVABLES (AR)';
      $PRIORITY = 'DEFAULT';
      $REPORTING = 'EC2CWUSER_EXT';
      $SERIOUS = 'SEVERITY 4';
      $SERV_DEPT = 'EBUS SOLUTIONS';

      switch ($query) {
        case "I do not have a username or password and need access on behalf of my Company.": {
          $CATEGORY = 'ACCESS';
          $SERIOUS = 'REQUEST 3';
          $SERV_DEPT = 'FINANCIAL SERV';
          break;
        }
        case "I have forgotten my Portal Username and/or password.": {
          $ITEM = 'PORTAL';
          break;
        }
        case "I have forgotten my Oracle eBusiness Suite Password.": {
          $ITEM = 'SYSADMIN';
          break;
        }
        case "I cannot access Portal due to error messages.": {
          $ITEM = 'PORTAL';
          $CATEGORY = 'PROBLEM';
          $SERV_DEPT = '2ND LINE EBUS';
          break;
        }
        case "I am having a technical problem with Oracle eBusiness Suite and receiving system errors.": {
          $CATEGORY = 'PROBLEM';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    case 'Supply Chain Support Request': {

      switch ($query) {
        case "I require access on behalf of my company.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'SUPPLY CHAIN';
          $CATEGORY = 'ACCESS';
          $SERIOUS = 'REQUEST 3';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I cannot access Portal.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'PORTAL';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "My portal password needs resetting.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'PORTAL';
          $CATEGORY = 'PASSWORD';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I can access Portal but an error is occurring when I try to log into eBusiness Suite.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'SUPPLY CHAIN';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I can access Portal but my password needs resetting for eBusiness access.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'SYSADMIN';
          $CATEGORY = 'PASSWORD';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        case "I need assistance navigating through the system.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'SYSADMIN';
          $CATEGORY = 'PASSWORD';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'NSC SYSTEMS';
          break;
        }
        case "I am having a technical problem with eBusiness and receiving system errors.": {
          $AFFECTED = 'SUPPLYCHAIN_EXT';
          $REPORTING = 'SUPPLYCHAIN_EXT';
          $ITEM = 'SUPPLY CHAIN';
          $CATEGORY = 'PROBLEM';
          $SERIOUS = 'SEVERITY 4';
          $PRIORITY = 'DEFAULT';
          $SERV_DEPT = 'EBUS SOLUTIONS';
          break;
        }
        default: {
          break;
        }
      } // switch
      break;
    } // case

    default: {
      break;
    }
  }

  $headers = '';

  // add headers tags
  if ( !empty($AFFECTED) ) {  $headers .= "@*@AFFECTED@*@:" . $AFFECTED . "\n"; }
  if ( !empty($CATEGORY) ) {  $headers .= "@*@CATEGORY@*@:" . $CATEGORY . "\n"; }
  if ( !empty($ITEM) ) {      $headers .= "@*@ITEM@*@:" . $ITEM . "#IM\n"; }
  if ( !empty($PRIORITY) ) {  $headers .= "@*@PRIORITY@*@:" . $PRIORITY . "\n"; }
  if ( !empty($REPORTING) ) { $headers .= "@*@REPORTING@*@:" . $REPORTING . "\n"; }
  if ( !empty($SERIOUS) ) {   $headers .= "@*@SERIOUS@*@:" . $SERIOUS . "\n"; }
  if ( !empty($SERV_DEPT) ) { $headers .= "@*@SERV-DEPT@*@:" . $SERV_DEPT . "\n"; }

  $submission->data["headers"] = $headers;

}, 10, 2 );


/**
* Change the max filesize for file uploads in HTML Forms Premium to 7MB
*/
add_filter( 'hf_upload_max_filesize', function( $size ) {
  // size in bytes, 1000000 = 1MB
  return 6000000;
});
