<?php

namespace MiniTeam\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\CommonContexts\DoctrineFixturesContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

/**
 * MiniScrumContext description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class MiniScrumContext extends BehatContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    public function __construct()
    {
        $this->useContext('doctrine_fixtures', new DoctrineFixturesContext());
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $loader = new ContainerAwareLoader($this->kernel->getContainer());

        $this->getSubcontext('doctrine_fixtures')
            ->loadFixtureClasses($loader, array(
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
