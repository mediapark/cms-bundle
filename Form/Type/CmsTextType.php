<?php

namespace Mp\CmsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CmsTextType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        if (isset($options['simple']) && ($options['simple'] === false)) {
            $builder->add('is_active', 'checkbox', array('label' => 'cms.Is.active'));
            $builder->add('position', 'number', array('label' => 'cms.Position'));
            $builder->add('title', 'text', array('label' => 'cms.Title'));
        }
        
        $builder->add('content', 'text', array('label' => 'cms.Text'));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'simple' => true
        ));
    }

    public function getName() {
        return 'mp_cms_text';
    }

}
