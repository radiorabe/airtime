<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $this->_redirect('now-playing');
    }

    public function mainAction()
    {
        $this->_helper->layout->setLayout('layout');
    }

    public function maintenanceAction()
    {
        $this->getResponse()->setHttpResponseCode(503);
    }

}
