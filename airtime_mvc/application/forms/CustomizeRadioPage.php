<?php

class Application_Form_CustomizeRadioPage extends Zend_Form_SubForm
{

    public function init()
    {
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'form/radio-page-customize.phtml'))
        ));

        $elementNamePrefix = "radio_page_customize_";

        $displayLoginButtonElement = new Zend_Form_Element_Checkbox($elementNamePrefix."login_button");
        $displayLoginButtonElement
            ->setLabel(_("Display login button"))
            ->setValue(true);
        $this->addElement($displayLoginButtonElement);

        $widgetColour = Application_Model_Preference::getRadioPageWidgetColour();
        if (empty($widgetColour)) {
            $widgetColour = DEFAULT_RADIO_PAGE_WIDGET_COLOUR;
        }
        $widgetColourElement = new Zend_Form_Element_Text($elementNamePrefix."widget_colour");
        $stringLengthValidator = Application_Form_Helper_ValidationTypes::overrideStringLengthValidator(6, 6);
        $widgetColourElement
            ->setLabel(_("Widget Colour:"))
            ->setValue($widgetColour)
            ->setDecorators(array(
                'ViewHelper',
                'Errors',
                'Label'
            ))
            ->addDecorator('Label', array('class' => 'form-inline-text-box'))
            ->setValidators(array('Hex', $stringLengthValidator));
        $this->addElement($widgetColourElement);

        $submit = new Zend_Form_Element_Submit($elementNamePrefix."submit");
        $submit->setLabel(_("Save"));
        $this->addElement($submit);
    }
}