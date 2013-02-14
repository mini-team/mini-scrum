<?php

namespace MiniTeam\ScrumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Comment;
use MiniTeam\UserBundle\Entity\User;

/**
 * LoadCommentData description
 *
 * @author Edouard de Labareyre <edouard@melix.net>
 */
class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dev = $this->getReference('first-developer');
        $po = $this->getReference('product-owner');

        $comment1 = $this->createComment('Possible d\'avoir plus d\'infos là dessus ?', $dev, $this->getReference('story-3'));
        $comment2 = $this->createComment('suivant le role du commentateur, le commentaire s\'aligne à droite (PO) ou à gauche (DEV)', $po, $this->getReference('story-3'));

        $manager->persist($comment1);
        $manager->persist($comment2);

        $manager->flush();
    }

    /**
     * Create a comment attached to a user story
     *
     * @param                                        $content
     * @param \MiniTeam\UserBundle\Entity\User       $author
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     *
     * @return \MiniTeam\ScrumBundle\Entity\Comment
     */
    protected function createComment($content, User $author, UserStory $story)
    {
        $comment = new Comment();
        $comment->setAuthor($author)
                ->setContent($content)
                ->setStory($story);

        return $comment;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 400;
    }
}
