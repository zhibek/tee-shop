<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext,
    Behat\Mink\Element\NodeElement;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context. Behat\Mink\Element\NodeElement
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext {

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    protected $existance_flag = 0;
    protected $btn_title;

    public function __construct(array $parameters) {
        // Initialize your context here
    }

    private function setBtnTitle($title) {
        $this->btn_title = $title;
    }

    private function getBtnTitle() {
        return $this->btn_title;
    }

    private function spin($lambda) {
        while (true) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }
            sleep(1);
        }
    }

    /**
     * @Given /^I mock add to cart$/
     */
    public function iMockAddToCart2() {
        $this->iAmOnHomepage();
        $this->clickLink('Test Products');
        $this->clickLink('Test T-Shirt');
        $this->pressButton('Add to Cart');
    }

    /**
     * 
     * get the button with attribute value 
     * @When /^I press button with attribute "([^"]*)" and value is "([^"]*)" and container is "([^"]*)"$/
     */
    public function iPressButtonWithAttributeAndNameIs($attribute, $value, $container, $count = 0) {
        $buttons = $this->getSession()->getPage()->findAll('css', 'button');
        // make sure no infinite loops happen
        if ($count > 20) {
            echo 'infinte counts' . PHP_EOL;
            return false;
        }
        // make sure the button does not exist incase of recursiveness 
        $this->existance_flag = 0;

        if ($this->existance_flag == 0) {
            foreach ($buttons as $button) {
                $attrval = $button->getAttribute($attribute);
                $displayValue = $this->getSession()->getPage()->findById($container)->isVisible();
                if ($displayValue && !empty($attrval) && $attrval == $value) {
                    $button->click();
                    // to skip next if clause if the button already clicked
                    $this->existance_flag = 1;
                    return true;
                }
            }
            if ($this->existance_flag == 0) {
                $this->getSession()->wait('500');
                $count++;
                $this->iPressButtonWithAttributeAndNameIs($attribute, $value, $container, $count);
            }
        }
    }
    
    /**
     * 
     * get the button with attribute value 
     * @When /^I spin for a while to see a button with title "([^"]*)"$/
     */
    public function iSpinForAWhileToSeeAButtonWithTitle($title) {
        $this->setBtnTitle($title);
        $this->spin(function(FeatureContext $context) {
            return ($context->getSession()->getPage()->hasButton($context->getBtnTitle()));
        });
    }
}