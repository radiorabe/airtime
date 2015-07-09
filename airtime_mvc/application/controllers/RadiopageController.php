<?php

class RadioPageController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {

    }

    public function customizeAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_CustomizeRadioPage();

        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($form->isValid($postData)) {
                Application_Model_Preference::setRadioPageDisplayLoginButton($postData["radio_page_customize_login_button"]);
                Application_Model_Preference::setRadioPageWidgetColour($postData["radio_page_customize_widget_colour"]);
            }
        }

        $this->view->form = $form;


    }


    public function radioPageCssAction()
    {
        $this->view->layout()->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'text/css');

        $customWidgetColour = "#".Application_Model_Preference::getRadioPageWidgetColour();
        $this->view->widgetColour = $customWidgetColour;

        list($r, $g, $b) = sscanf($customWidgetColour, "#%02x%02x%02x");
        $this->view->widgetColourRgb = array(
            "r" => $r,
            "g" => $g,
            "b" => $b);
    }
}
