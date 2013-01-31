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
            11
        );

        $secondStory = $this->createStory(
            'ETQ user je peux avoir accès à mini-scrum',
            $this->getReference('main-project'),
            'depuis n\'importe où (entre autres)',
            2,
            UserStory::SPRINT_BACKLOG,
            12
        );

        $thirdStory = $this->createStory(
            'ETQ user je peux poster des commentaires sur une user story',
            $this->getReference('main-project'),
            'uniquement si la story est entre les statuts sprint backlog et done',
            2,
            UserStory::DOING,
            13
        );

        $fourthStory = $this->createStory(
            'ETQ user cette user story est à valider',
            $this->getReference('main-project'),
            'bien regarder la définition du done',
            5,
            UserStory::TO_VALIDATE,
            14
        );

        $manager->persist($firstStory);
        $manager->persist($secondStory);
        $manager->persist($thirdStory);
        $manager->persist($fourthStory);

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
