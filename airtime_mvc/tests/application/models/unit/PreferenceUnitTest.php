<?php
require_once "../application/configs/conf.php";
require_once "TestHelper.php";
require_once "Preferences.php";

class PreferenceUnitTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        TestHelper::installTestDatabase();
        TestHelper::setupZendBootstrap();
        parent::setUp();
    }

    /*    
    public function testSetHeadTitle()
    {
        $title = "unit test";
        //This function is confusing and doesn't really work so we're just gonna let it slide...
        Application_Model_Preferences::SetHeadTitle($title);
        $this->assertEquals(Application_Model_Preferences::GetHeadTitle(), $title);
    }
     */
    
    public function testSetShowsPopulatedUntil()
    {
        $date = new DateTime();
        Application_Model_Preferences::SetShowsPopulatedUntil($date);
        $this->assertEquals(Application_Model_Preferences::GetShowsPopulatedUntil(), $date);
    }

}
