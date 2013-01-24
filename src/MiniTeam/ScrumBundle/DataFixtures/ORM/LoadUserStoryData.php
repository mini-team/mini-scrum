<?php

namespace MiniTeam\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
		
		$user_story = new UserStory();
		$user_story->setTitle('ETQ user ceci est une user story fixture');
		$user_story->setDetails('plein de détails croustillants');
		$user_story->setPoints(3);
		$user_story->setStatus(UserStory::PRODUCT_BACKLOG);
		$user_story->setNumber(12);
		$user_story->setProject($this->getReference('main-project'));
		
		$manager->persist($user_story);
		
		$user_story_2 = new UserStory();
		$user_story_2->setTitle('ETQ user je peux avoir accès à mini-scrum');
		$user_story_2->setDetails('depuis n\'importe où (entre autres)');
		$user_story_2->setPoints(2);
		$user_story_2->setStatus(UserStory::SPRINT_BACKLOG);
		$user_story_2->setNumber(2);
		$user_story_2->setProject($this->getReference('main-project'));

		$manager->persist($user_story_2);

        $manager->flush();
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
