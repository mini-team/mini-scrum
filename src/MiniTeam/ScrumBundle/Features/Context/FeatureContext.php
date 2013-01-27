<?php

namespace MiniTeam\ScrumBundle\Features\Context;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\CommonContexts\SymfonyDoctrineContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use MiniTeam\Features\Context\MiniScrumContext;
use MiniTeam\UserBundle\Features\Context\FeatureContext as UserBundleContext;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
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
}
