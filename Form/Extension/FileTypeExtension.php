<?php

namespace Mediapark\CmsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FileTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'file';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('image_path', 'translatable'));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('image_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (array_key_exists('translatable', $options)) {
                $imageUrl = $options['image_path'];
            } else {
                if (null !== $parentData) {
                    $pa = PropertyAccess::getPropertyAccessor();
                    $propertyPath = new PropertyPath($options['image_path']);
                    
                    $imageUrl = $pa->getValue($parentData, $propertyPath);
                } else {
                     $imageUrl = null;
                }
            }

            // set an "image_url" variable that will be available when rendering this field
            
            $view->vars['image_url'] = $imageUrl;
        } else {
            $view->vars['image_url'] = null;
        }
    }
}
