<?php
class UserSettingsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('get-now-playing-screen-settings', 'json')
                    ->addActionContext('set-now-playing-screen-settings', 'json')
                    ->addActionContext('get-library-datatable', 'json')
                    ->addActionContext('set-library-datatable', 'json')
                    ->addActionContext('get-timeline-datatable', 'json')
                    ->addActionContext('set-timeline-datatable', 'json')
                    ->addActionContext('remindme', 'json')
                    ->addActionContext('remindme-never', 'json')
                    ->addActionContext('do-not-show-registration-popup', 'json')
                    ->addActionContext('set-library-screen-settings', 'json')
                    ->initContext();
    }

    public function setNowPlayingScreenSettingsAction()
    {
        $request = $this->getRequest();
        $settings = $request->getParam("settings");

        Application_Model_Preferences::setNowPlayingScreenSettings($settings);
    }

    public function getNowPlayingScreenSettingsAction()
    {
        $data = Application_Model_Preferences::getNowPlayingScreenSettings();
        if (!is_null($data)) {
            $this->view->settings = $data;
        }
    }

    public function setLibraryDatatableAction()
    {
        $request = $this->getRequest();
        $settings = $request->getParam("settings");

        Application_Model_Preferences::setCurrentLibraryTableSetting($settings);
    }

    public function getLibraryDatatableAction()
    {
        $data = Application_Model_Preferences::getCurrentLibraryTableSetting();
        if (!is_null($data)) {
            $this->view->settings = $data;
        }
    }

    public function setTimelineDatatableAction()
    {
        $request = $this->getRequest();
        $settings = $request->getParam("settings");

        Application_Model_Preferences::setTimelineDatatableSetting($settings);
    }

    public function getTimelineDatatableAction()
    {
        $data = Application_Model_Preferences::getTimelineDatatableSetting();
        if (!is_null($data)) {
            $this->view->settings = $data;
        }
    }

    public function remindmeAction()
    {
        // unset session
        session_start();  //open session for writing again
        Zend_Session::namespaceUnset('referrer');
        Application_Model_Preferences::SetRemindMeDate();
    }
    
    public function remindmeNeverAction()
    {
        session_start();  //open session for writing again
        Zend_Session::namespaceUnset('referrer');
        //pass in true to indicate 'Remind me never' was clicked
        Application_Model_Preferences::SetRemindMeDate(true);
    }

    public function doNotShowRegistrationPopupAction()
    {
        // unset session
        session_start();  //open session for writing again
        Zend_Session::namespaceUnset('referrer');
    }

    public function setLibraryScreenSettingsAction()
    {
        $request = $this->getRequest();
        $settings = $request->getParam("settings");
        Application_Model_Preferences::setLibraryScreenSettings($settings);
    }
}
