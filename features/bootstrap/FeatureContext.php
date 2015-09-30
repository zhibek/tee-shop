<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext {

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
        // Initialize your context here
    }

    /**
     * @Given /^I mock add to cart$/
     */
    public function iMockAddToCart2() {
        $this->iAmOnHomepage();
        $this->visit('/test-t-shirt.html');
        $this->pressButton('Add to Cart');
    }

    /**
     * 
     * get the button with attribute value 
     * @When /^I press button with attribute "([^"]*)" and value is "([^"]*)"$/
     */
    public function iPressButtonWithAttributeAndNameIs($attribute, $value)
    {
        $buttons = $this->getSession()->getPage()->findAll('css', 'button');
        foreach ($buttons as $button) {
            $attrval = $button->getAttribute($attribute); 
            if (!empty($attrval) && $attrval == $value) {
                $button->click();
                break;
            }
        }
    }
    
    /**
     * @Given /^I wait for AJAX to finish$/
     */
    public function iWaitForAjaxToFinish()
    {
        $this->getSession()->wait(10000, '(typeof(jQuery)=="undefined" '
                                          . '|| (0 === jQuery.active '
                                          . '&& 0 === jQuery(\':animated\').length))');
        $this->getSession()->wait('10000');
    }

    
    /**
     * @When /^I wait for "([^"]*)" seconds$/
     */
    public function iWaitForSeconds($numOfSeconds)
    {
        if (!is_int($numOfSeconds)) {
            throw new \InvalidArgumentException();
        }
        $this->getSession()->wait($numOfSeconds);
    }



//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
}
