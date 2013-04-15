<?php

namespace MiniTeam\ScrumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Issue;

/**
 * LoadIssueData description
 *
 * @author Edouard de Labareyre <edouard@melix.net>
 */
class LoadIssueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $issue1 = $this->createIssue('Problème alignement sous Chrome', $this->getReference('story-4'));
        $issue2 = $this->createIssue('Ne fonctionne pas en mode portrait', $this->getReference('story-4'));
        $issue1->setOpened(false);

        $manager->persist($issue1);
        $manager->persist($issue2);

        $manager->flush();
    }

    /**
     * Create an opened issue attached to a user story
     *
     * @param                                        $content
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     *
     * @return \MiniTeam\ScrumBundle\Entity\Issue
     */
    protected function createIssue($content, UserStory $story)
    {
        $issue = new Issue();
        $issue->setContent($content)
              ->setStory($story);

        return $issue;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 500;
    }
}
