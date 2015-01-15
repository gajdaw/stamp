<?php

namespace Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\MatcherInterface;
use Symfony\Component\Console\Tester\ApplicationTester;

class ApplicationOutputRegexMatcher implements MatcherInterface
{

    /**
     * Checks if matcher supports provided subject and matcher name.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     *
     * @return Boolean
     */
    public function supports($name, $subject, array $arguments)
    {
        return ($name == 'haveOutputMatching' && $subject instanceof ApplicationTester);
    }

    /**
     * Evaluates positive match.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     */
    public function positiveMatch($name, $subject, array $arguments)
    {
        $expected = $arguments[0];
        if (!preg_match($expected, $subject->getDisplay())) {
            throw new FailureException(sprintf(
                "Application output did not match '%s'. Actual output:\n'%s'" ,
                $expected,
                $subject->getDisplay()
            ));
        }
    }

    /**
     * Evaluates negative match.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     */
    public function negativeMatch($name, $subject, array $arguments)
    {
        throw new FailureException('Negative application output matcher not implemented');
    }

    /**
     * Returns matcher priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        return 51;
    }
}