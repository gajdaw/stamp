<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Stamp\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use PhpSpec\Matcher\MatchersProviderInterface;
use Matcher\ApplicationOutputMatcher;


/**
 * Defines application features from the specific context.
 */
class ApplicationContext implements Context, MatchersProviderInterface
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var integer
     */
    private $lastExitCode;

    /**
     * @var ApplicationTester
     */
    private $tester;

    /**
     * @beforeScenario
     */
    public function setupApplication()
    {
        $this->application = new Application('0.1-dev');
        $this->application->setAutoExit(false);
        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @When I run greet
     */
    public function iRunGreet()
    {
        $arguments = array (
            'command' => 'greet'
        );

        $this->lastExitCode = $this->tester->run($arguments, array('interactive' => false));
    }

    /**
     * @Then I should see :output
     */
    public function iShouldSee($output)
    {
        expect($this->tester)->toHaveOutput((string)$output);
    }

    /**
     * Custom matchers
     *
     * @return array
     */
    public function getMatchers()
    {
        return array(
            new ApplicationOutputMatcher(),
        );
    }
    
}
