<?php

namespace Mediapark\CmsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        if (isset($options['simple']) && ($options['simple'] === false)) {

            $builder->add('is_active', 'checkbox', array('label' => 'cms.Is.active'));
            $builder->add('position', 'number', array('label' => 'cms.Position'));

            $builder->add('title', 'text', array('label' => 'cms.Title'));
        }

        $builder->add('content_file', 'file', array('label' => 'cms.Image', 'image_path' => 'contentWebPath'));
        if ($builder->getData() && $builder->getData()->getContent()) {
            $builder->add('delete_content', 'checkbox', array('mapped' => false, 'required' => false, 'label' => 'cms.Delete.file'));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'simple' => true
        ));
    }

    public function getName() {
        return 'mediapark_cms_image';
    }

}
