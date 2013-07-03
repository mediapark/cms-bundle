<?php

namespace Mediapark\CmsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageTextType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('is_active', 'checkbox', array('label' => 'cms.Is.active'));
        $builder->add('position', 'number', array('label' => 'cms.Position'));

        $builder->add('title', 'text', array('label' => 'cms.Title'));
        $builder->add('image_file', 'file', array('label' => 'cms.Image', 'image_path' => 'imageWebPath'));

        if ($builder->getData() && $builder->getData()->getImage()) {
            $builder->add('delete_image', 'checkbox', array('mapped' => false, 'required' => false, 'label' => 'cms.Delete.file'));
        }

        $builder->add('text', 'ckeditor', array('label' => 'cms.Text'));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Mediapark\CmsBundle\Entity\CmsImageText',
            'simple' => true
        ));
    }

    public function getName() {
        return 'mediapark_cms_image_text';
    }

}
