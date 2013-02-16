<?php

namespace MiniTeam\ScrumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * StoryStatusType
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class StoryStatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getStatuses()
        ));
    }

    /**
     * Return available statuses.
     *
     * @return array
     */
    public function getStatuses()
    {
        $class = new \ReflectionClass('MiniTeam\ScrumBundle\Entity\UserStory');
        $constants = $class->getConstants();

        return array_combine($constants, $constants);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'story_status';
    }
}
