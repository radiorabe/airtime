<?php

class SystemStatusController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
        $partitions = Application_Model_Systemstatus::GetDiskInfo();

        $this->view->status = new StdClass;
        $this->view->status->partitions = $partitions;
    }
}
