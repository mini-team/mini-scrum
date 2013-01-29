<?php

namespace MiniTeam\ScrumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MiniTeam\ScrumBundle\Entity\Project;

/**
 * LoadProjectData description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName('mini-scrum');
        $project->setProductOwner($this->getReference('product-owner'));
        $project->setScrumMaster($this->getReference('scrum-master'));
        $project->addDeveloper($this->getReference('first-developer'));

        $this->addReference('main-project', $project);

        $manager->persist($project);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 200;
    }
}
