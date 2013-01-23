<?php

namespace MiniTeam\UserBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Assert\Assertion;

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
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

        $this->useContext('mink', new MinkContext());
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
     * @Then /^I should be authenticated$/
     */
    public function iShouldBeAuthenticated()
    {
        /** @var $securityContext \Symfony\Component\Security\Core\SecurityContextInterface */
        $securityContext = $this->kernel->getContainer()->get('security.context');
        $this->assertion->true($securityContext->isGranted('ROLE_USER'));
    }

    /**
     * @Given /^I should be on "([^"]*)" project$/
     */
    public function iShouldBeOnProject($name)
    {
        $this->getSubcontext('mink')->assertElementContainsText('.navbar a.brand', $name);
    }
}
