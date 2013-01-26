<?php

namespace MiniTeam\Features\Context;

use Behat\CommonContexts\DoctrineFixturesContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

/**
 * MiniScrumDoctrineFixturesContext description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class MiniScrumDoctrineFixturesContext extends DoctrineFixturesContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $loader = new ContainerAwareLoader($this->kernel->getContainer());

        $this->loadFixtureClasses($loader, array(
                'MiniTeam\UserBundle\DataFixtures\ORM\LoadUserData',
                'MiniTeam\ScrumBundle\DataFixtures\ORM\LoadProjectData',
                'MiniTeam\ScrumBundle\DataFixtures\ORM\LoadUserStoryData',
            ));

        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->purge();
        $executor->execute($loader->getFixtures(), true);
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel HttpKernel instance
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
}
