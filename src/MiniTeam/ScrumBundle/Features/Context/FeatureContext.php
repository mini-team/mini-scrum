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
     * @Given /^I am viewing story (\d+)$/
     */
    public function viewStory($id)
    {
        return new Step\Given(sprintf('I am on "/mini-scrum/us/%s"', $id));
    }

    /**
     * @Given /^I am working on the story "(?P<id>[^"]*)"$/
     * @Given /^the story "(?P<id>[^"]*)" is (?P<status>[^"]*)$/
     */
    public function setStoryStatus($id, $status = \MiniTeam\ScrumBundle\Entity\UserStory::DOING)
    {
        $status = $this->convertStateToStatus($status);

        $this->updateStory($id, $status);
    }

    /**
     * @When /^I (?P<action>:?\w+) the story "(?P<id>[^"]*)"$/
     */
    public function changeStateOfUserStory($action, $id)
    {
        return array(
            new Step\When(sprintf('I am on "/mini-scrum/us/%s"', $id)),
            new Step\When(sprintf('I follow "%s"', $action)),
        );
    }

    /**
     * @Then /^the story should be (?:|in )(?P<state>\w*)$/
     *
     * @todo Use transform here
     */
    public function assertStoryState($state)
    {
        $status = $this->convertStateToStatus($state);

        return new Step\Then(sprintf('I should see "%s" in the "#status" element', $status));
    }

    /**
     * @param $state
     *
     * @return string
     */
    public function convertStateToStatus($state)
    {
        if (in_array($state, \MiniTeam\ScrumBundle\Entity\UserStory::getStatuses())) {
            return $state;
        }

        if ('planned' == $state) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::SPRINT_BACKLOG;
        } elseif ('delivered' == $state) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::TO_VALIDATE;
        } elseif ('progress' == $state) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::DOING;
        } elseif ('blocked' == $state) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::BLOCKED;
        } elseif ('done' == $state) {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::DONE;
        } else {
            $status = \MiniTeam\ScrumBundle\Entity\UserStory::PRODUCT_BACKLOG;
        }

        return $status;
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


    /**
     * @When /^I write comment "([^"]*)"$/
     */
    public function writeComment($comment)
    {
        return new Step\When(sprintf('I fill in "form_content" with "%s"',$comment));
    }

    /**
     * @Given /^I submit my comment$/
     */
    public function submitComment()
    {
        return new Step\When(sprintf('I press "comment-submit-button"'));
    }
}
