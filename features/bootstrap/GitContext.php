<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Matcher\FileExistsMatcher;
use Matcher\FileHasContentsMatcher;
use PhpSpec\Matcher\MatchersProviderInterface;
use Symfony\Component\Filesystem\Filesystem;
use GitElephant\Repository;

/**
 * Defines application features from the specific context.
 */
class GitContext implements Context, MatchersProviderInterface
{

    /**
     * @var Repository
     */
    private $repo;

    /**
     * @var string
     */
    private $workingDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * @beforeScenario
     */
    public function prepWorkingDirectory()
    {
        $this->workingDirectory = tempnam(sys_get_temp_dir(), 'phpspec-behat');
        $this->filesystem->remove($this->workingDirectory);
        $this->filesystem->mkdir($this->workingDirectory);
        chdir($this->workingDirectory);
        $this->repo = new Repository($this->workingDirectory);
    }

    /**
     * @afterScenario
     */
    public function removeWorkingDirectory()
    {
        $this->filesystem->remove($this->workingDirectory);
    }


    /**
     * @Given I initialize a repo
     */
    public function iInitializeARepo()
    {
        $this->repo->init();
    }

    /**
     * @Given I commit :message
     */
    public function iCommit($message)
    {
        $this->repo->stage();
        $this->repo->commit($message);
    }

    /**
     * @Given I tag :tag with message :message
     */
    public function iTagWithMessage($tag, $message)
    {
        $this->repo->createTag($tag, null, $message);
    }

    /**
     * @Then the file :arg1 should contain :arg2
     */
    public function theFileShouldContain($arg1, $arg2)
    {
        throw new PendingException();
    }


    /**
     * @return array
     */
    public function getMatchers()
    {
        return array(
            new FileExistsMatcher(),
            new FileHasContentsMatcher()
        );
    }
}
