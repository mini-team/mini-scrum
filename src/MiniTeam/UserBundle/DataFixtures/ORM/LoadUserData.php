<?php

namespace MiniTeam\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MiniTeam\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * LoadUserData description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $productOwner = $this->createUser('mini@miniscrum.net', 'Mini', 'test');
        $scrumMaster  = $this->createUser('julien@miniscrum.net', 'Julien', 'test');
        $edouard      = $this->createUser('edouard@miniscrum.net', 'Edouard', 'test');
        $benjamin     = $this->createUser('benjamin@miniscrum.net', 'Benjamin', 'test');

        $manager->persist($productOwner);
        $manager->persist($scrumMaster);
        $manager->persist($edouard);
        $manager->persist($benjamin);
        $manager->flush();

        $this->addReference('product-owner', $productOwner);
        $this->addReference('scrum-master', $scrumMaster);
        $this->addReference('first-developer', $edouard);
        $this->addReference('second-developer', $benjamin);
    }

    /**
     * @param $email
     * @param $username
     * @param $password
     *
     * @return \MiniTeam\UserBundle\Entity\User
     */
    protected function createUser($email, $username, $password)
    {
        $user = new User();
        $user->setEnabled(true)
             ->setEmail($email)
             ->setUsername($username);

        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        return $user;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 100;
    }
}
