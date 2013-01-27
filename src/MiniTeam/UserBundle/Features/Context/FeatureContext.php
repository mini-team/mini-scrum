<?php

namespace MiniTeam\UserBundle\Features\Context;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Context\Step,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Assert\Assertion;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;


/**
 * Features context.
 */
class FeatureContext extends BehatContext
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;
    private $assertion;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->assertion = new Assertion();
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Return a service contained in the container.
     *
     * @param $service
     *
     * @return mixed
     */
    public function get($service)
    {
        return $this->kernel->getContainer()->get($service);
    }

    /**
     * @Given /^I am authenticated as "([^"]*)" with "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($username, $password)
    {
        return array(
            new Step\When('I am on "/login"'),
            new Step\When('I fill in "Username" with "'.$username.'"'),
            new Step\When('I fill in "Password" with "'.$password.'"'),
            new Step\When('I press "Login"'),
        );
    }
}
