<?php

namespace MiniTeam\ScrumBundle\Features\Context;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Context\Step,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

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

    /**
     * @Given /^I am working on the story "([^"]*)"$/
     */
    public function iAmWorkingOnTheStory($id)
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $story = $em->getRepository('MiniTeamScrumBundle:UserStory')->find($id);
        $story->setStatus(\MiniTeam\ScrumBundle\Entity\UserStory::DOING);

        $em->persist($story);
        $em->flush();
    }

    /**
     * @When /^I (:?start|deliver) the user story$/
     */
    public function changeStateOfUserStory($status)
    {
        $link = "#$status";

        return new Step\When(sprintf('I follow "%s"', $status));
    }
}
