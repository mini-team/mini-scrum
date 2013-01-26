<?php

namespace MiniTeam\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\CommonContexts\SymfonyDoctrineContext;
use Behat\MinkExtension\Context\MinkContext;
use MiniTeam\Features\Context\MiniScrumDoctrineFixturesContext;
use MiniTeam\ScrumBundle\Features\Context\FeatureContext as ScrumBundleContext;
use MiniTeam\UserBundle\Features\Context\FeatureContext as UserBundleContext;

/**
 * MiniScrumContext description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class MiniScrumContext extends BehatContext
{

    public function __construct()
    {
        $this->useContext('mink', new MinkContext());
        $this->useContext('symfony_doctrine', new SymfonyDoctrineContext());
        $this->useContext('doctrine_fixtures', new MiniScrumDoctrineFixturesContext());
        $this->useContext('scrum_bundle', new ScrumBundleContext(array()));
        $this->useContext('user_bundle', new UserBundleContext(array()));
    }
}
