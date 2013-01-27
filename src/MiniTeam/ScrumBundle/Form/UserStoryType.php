<?php

namespace MiniTeam\ScrumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('points', 'choice', array('choices' => $this->getPoints()))
            ->add('status', 'choice', array('choices' => $this->getStatuses()))
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

    /**
     * @return array
     */
    public function getStatuses()
    {
        $class = new \ReflectionClass('MiniTeam\ScrumBundle\Entity\UserStory');
        $constants = $class->getConstants();

        return array_combine($constants, $constants);
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return array('0', '1/2', '1', '2', '3', '5', '8', '13', '20', '40', '50', '100', '?', '∞');
    }
}
