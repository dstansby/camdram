<?php

namespace Acts\CamdramBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Yaml\Yaml;

class MapLocationType extends AbstractType
{
    private $map;

    public function __construct(\Ivory\GoogleMapBundle\Model\Map $map, array $center)
    {
        $map->setCenter($center[0], $center[1], true);
        $map->setMapOption('zoom', 14);
        $map->setStylesheetOptions(array('width' => '100%', 'height' => '100%'));

        $this->map = $map;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('latitude')
            ->add('longitude');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['location_map'] = $this->map;
        $view->vars['child_class'] = 'six columns';
        $this->map->setHtmlContainerId($view->vars['id'].'_map');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acts\CamdramBundle\Entity\MapLocation',
            'compound' => true,
            'class' => 'error'
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'map_location';
    }
}