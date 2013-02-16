<?php

namespace MiniTeam\ScrumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class UserStoryType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('details', 'textarea', array('required' => false))
            ->add('points', 'story_point')
            ->add('status', 'story_status')
            ->add('projectId', 'hidden')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MiniTeam\ScrumBundle\Entity\UserStory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'story';
    }
}
