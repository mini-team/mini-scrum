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
     * @When /^I (?P<action>:?\w+) the user story "(?P<id>[^"]*)"$/
     */
    public function changeStateOfUserStory($action, $id)
    {
        return array(
            new Step\When(sprintf('I am on "/mini-scrum/us/%s"', $id)),
            new Step\When(sprintf('I follow "%s"', $action)),
        );
    }

    /**
     * @Given /^I am working on the story "(?P<id>[^"]*)"$/
     */
    public function iAmWorkingOnTheStory($id)
    {
        $this->updateStory($id, \MiniTeam\ScrumBundle\Entity\UserStory::DOING);
    }

    /**
     * @Given /^the story "(?P<id>[^"]*)" is (?P<status>[^"]*)$/
     */
    public function setStoryStatus($id, $status)
    {
        if ('planned' == $status) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::SPRINT_BACKLOG;
        } elseif ('delivered' == $status) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::TO_VALIDATE;
        } else {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::PRODUCT_BACKLOG;
        }

        $this->updateStory($id, $status);
    }

    /**
     * @Given /^it should be in progress$/
     */
    public function itShouldBeInProgress()
    {
        return array(
            //new Step\Then("I should see \"is working on it\" in the \"#assignee\" element"),
            new Step\Then('I should see "doing" in the "#status" element'),
        );
    }

    /**
     * @Then /^it should be done$/
     */
    public function itShouldBeDone()
    {
        return new Step\Then('I should see "done" in the "#status" element');
    }

    /**
     * @Then /^it should be blocked$/
     */
    public function itShouldBeBlocked()
    {
        return new Step\Then('I should see "blocked" in the "#status" element');
    }

    /**
     * @Then /^it should be in the product backlog$/
     */
    public function isShouldBeInProductBacklog()
    {
        return new Step\Then('I should see "product-backlog" in the "#status" element');
    }

    /**
     * @Then /^(?:|it )should be assigned to (?P<assignee>[^"]*)$/
     */
    public function assertAssignement($assignee)
    {
        return new Step\Then(sprintf('I should see "%s" in the "#assignee" element', $assignee));
    }

    /**
     * @param $id
     * @param $status
     */
    protected function updateStory($id, $status)
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $story = $em->getRepository('MiniTeamScrumBundle:UserStory')->find($id);
        $story->setStatus($status);

        $em->persist($story);
        $em->flush();
    }
}