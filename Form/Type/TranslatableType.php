<?php

namespace Mp\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

abstract class TranslatableType extends AbstractType {

    private $translatables = array();
    private $translatableFiles = array();
    private $langs = array();

    public function __construct($langs) {
        $this->langs = $langs;
    }

    protected function addTranslatableField($builder, $name, $label, $type) {
        foreach ($this->langs as $lang) {
            $id = "trans_".$name."_".$lang;
            $builder->add($id, $type, array('mapped'=>false, 'label'=>$label.' '.$lang));
            $this->translatables[] = (object)array('name' => $id, 'title'=>$name, 'locale'=>$lang);
        }
    }

    protected function addTranslatableFileField($builder, $name, $label) {
        $filePaths = $builder->getData()->getTranslatableFileWebPaths($name);
        foreach ($this->langs as $lang) {
            $id = $name."_".$lang;
            if ($builder->getData()->getId() && $builder->getData()->translate($lang, $name)) {
                $builder->add($id."_file_trans", 'file', array('mapped'=>false, 'label'=>$label.' '.$lang, 'translatable' => true, 'image_path' => $filePaths[$lang]));
                $builder->add('trans_delete_'.$id, 'checkbox', array('mapped' => false, 'required' => false, 'label' => 'admin.Delete.file'));
                $this->translatableFiles[] = (object)array('name' => $id."_file_trans", 'title'=>$name, 'locale' => $lang);
                $this->translatableFiles[] = (object)array('name' => "trans_delete_" . $id, 'title'=>$name, 'locale' => $lang);
            } else {
                $builder->add($id."_file_trans", 'file', array('mapped'=>false, 'label'=>$label.' '.$lang, 'translatable' => true));
                $this->translatableFiles[] = (object)array('name' => $id."_file_trans", 'title'=>$name, 'locale' => $lang);
            }            
        }
    }

    public function getTranslatableFields() {
        return $this->translatables;
    }
    
    public function getTranslatableFiles() {
        return $this->translatableFiles;
    }
}
