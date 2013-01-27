<?php

namespace MiniTeam\ScrumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\ScrumBundle\Entity\UserStory;

/**
 * LoadUserStoryData description
 *
 * @author Edouard de Labareyre <edouard@melix.net>
 */
class LoadUserStoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $firstStory = $this->createStory(
            'ETQ user ceci est une user story fixture',
            $this->getReference('main-project'),
            'plein de détails croustillants',
            3,
            UserStory::PRODUCT_BACKLOG,
            12
        );

        $secondStory = $this->createStory(
            'ETQ user je peux avoir accès à mini-scrum',
            $this->getReference('main-project'),
            'depuis n\'importe où (entre autres)',
            2,
            UserStory::SPRINT_BACKLOG,
            2
        );

        $manager->persist($firstStory);
        $manager->persist($secondStory);

        $manager->flush();
    }

    /**
     * Create a user story
     *
     * @param                                      $title
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     * @param null                                 $details
     * @param null                                 $points
     * @param null                                 $status
     * @param null                                 $number
     *
     * @return \MiniTeam\ScrumBundle\Entity\UserStory
     */
    protected function createStory($title, Project $project, $details = null, $points = null, $status = null, $number = null)
    {
        $story = new UserStory();
        $story->setTitle($title)
            ->setProject($project)
            ->setDetails($details)
            ->setPoints($points)
            ->setStatus($status)
            ->setNumber($number)
        ;

        return $story;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 300;
    }
}
