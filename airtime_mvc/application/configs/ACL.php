<?php

require_once 'Acl_plugin.php';

$ccAcl = new Zend_Acl();

$ccAcl->addRole(new Zend_Acl_Role('G'))
      ->addRole(new Zend_Acl_Role('H'), 'G')
      ->addRole(new Zend_Acl_Role('P'), 'H')
      ->addRole(new Zend_Acl_Role('A'), 'P')
      ->addRole(new Zend_Acl_Role('S'), 'A');

$ccAcl->addResource(new Zend_Acl_Resource('library'))
      ->addResource(new Zend_Acl_Resource('index'))
      ->addResource(new Zend_Acl_Resource('user'))
      ->addResource(new Zend_Acl_Resource('error'))
      ->addResource(new Zend_Acl_Resource('login'))
      ->addResource(new Zend_Acl_Resource('whmcs-login'))
      ->addResource(new Zend_Acl_Resource('playlist'))
      ->addResource(new Zend_Acl_Resource('plupload'))
      ->addResource(new Zend_Acl_Resource('calendar'))
      ->addResource(new Zend_Acl_Resource('api'))
      ->addResource(new Zend_Acl_Resource('system-status'))
      ->addResource(new Zend_Acl_Resource('dashboard'))
      ->addResource(new Zend_Acl_Resource('preferences'))
      ->addResource(new Zend_Acl_Resource('now-playing'))
      ->addResource(new Zend_Acl_Resource('playout-history'))
      ->addResource(new Zend_Acl_Resource('playout-history-template'))
      ->addResource(new Zend_Acl_Resource('listener-stats'))
      ->addResource(new Zend_Acl_Resource('user-settings'))
      ->addResource(new Zend_Acl_Resource('audio-preview'))
      ->addResource(new Zend_Acl_Resource('webstream'))
      ->addResource(new Zend_Acl_Resource('locale'))
      ->addResource(new Zend_Acl_Resource('upgrade'))
      ->addResource(new Zend_Acl_Resource('downgrade'))
      ->addResource(new Zend_Acl_Resource('rest:media'))
      ->addResource(new Zend_Acl_Resource('rest:show-image'))
      ->addResource(new Zend_Acl_Resource('billing'))
      ->addResource(new Zend_Acl_Resource('thank-you'))
      ->addResource(new Zend_Acl_Resource('provisioning'))
      ->addResource(new Zend_Acl_Resource('player'))
      ->addResource(new Zend_Acl_Resource('message'))
      ->addResource(new Zend_Acl_Resource('embeddablewidgets'));

/** Creating permissions */
$ccAcl->allow('G', 'index')
      ->allow('G', 'login')
      ->allow('G', 'whmcs-login')
      ->allow('G', 'error')
      ->allow('G', 'user', 'edit-user')
      ->allow('G', 'now-playing')
      ->allow('G', 'api')
      ->allow('G', 'calendar')
      ->allow('G', 'dashboard')
      ->allow('G', 'audio-preview')
      ->allow('G', 'webstream')
      ->allow('G', 'locale')
      ->allow('G', 'upgrade')
      ->allow('G', 'provisioning')
      ->allow('G', 'downgrade')
      ->allow('G', 'message')
      ->allow('G', 'rest:show-image', 'get')
      ->allow('H', 'rest:show-image')
      ->allow('G', 'rest:media', 'get')
      ->allow('H', 'rest:media')
      ->allow('H', 'preferences', 'is-import-in-progress')
      ->allow('H', 'user-settings')
      ->allow('H', 'plupload')
      ->allow('H', 'library')
      ->allow('H', 'playlist')
      ->allow('H', 'playout-history')
      ->allow('A', 'playout-history-template')
      ->allow('A', 'listener-stats')
      ->allow('A', 'user')
      ->allow('A', 'system-status')
      ->allow('A', 'preferences')
      ->allow('A', 'player')
      ->allow('A', 'embeddablewidgets')
      ->allow('S', 'thank-you')
      ->allow('S', 'billing');
      

$aclPlugin = new Zend_Controller_Plugin_Acl($ccAcl);

Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($ccAcl);

$front = Zend_Controller_Front::getInstance();
$front->registerPlugin($aclPlugin);
