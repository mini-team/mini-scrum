<?php

namespace MiniTeam\ScrumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * StoryPointType
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class StoryPointType extends AbstractType
{
    /**
     * @var array
     */
    protected $points;

    /**
     * @param array $points
     */
    public function __construct(array $points)
    {
        $this->points = $points;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array_combine($this->points, $this->points)
        ));
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
        return 'story_point';
    }
}
