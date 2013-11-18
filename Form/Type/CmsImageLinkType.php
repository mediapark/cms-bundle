<?php

namespace Mp\CmsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CmsImageLinkType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('is_active', 'checkbox', array('label' => 'cms.Is.active'));
        $builder->add('position', 'number', array('label' => 'cms.Position'));

        $builder->add('title', 'text', array('label' => 'cms.Title'));
        $builder->add('url', 'text', array('label' => 'cms.Url'));
        $builder->add('content_file', 'file', array('label' => 'cms.Image', 'image_path' => 'contentWebPath'));
        
        if (isset($options['seo']) && ($options['seo'] === true)) {
            $builder->add('seo_alt_text', 'text', array('label' => 'cms.Seo.Alt.text'));
            $builder->add('seo_title', 'text', array('label' => 'cms.Seo.Title'));
        }
        
        if ($builder->getData() && $builder->getData()->getContent()) {
            $builder->add('delete_content', 'checkbox', array('mapped' => false, 'required' => false, 'label' => 'cms.Delete.file'));
        }

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Mp\CmsBundle\Entity\CmsImageLink',
            'simple' => false,
            'seo' => false
        ));
    }

    public function getName() {
        return 'mp_cms_image_link';
    }

}
