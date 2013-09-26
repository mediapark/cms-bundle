<?php

namespace Mp\CmsBundle\Entity;

class MpTranslatable {
    protected $translations;

    public function setTranslation($t) {
        foreach ($this->translations as &$translation) {
            if ($translation->getLocale() == $t->getLocale() && $translation->getField() == $t->getField()) {
                $translation->setContent($t->getContent());
                return;
            }
        }
        $this->addTranslation($t);
    }

    public function translate($locale, $column) {
        foreach ($this->translations as &$translation) {
            if ($translation->getLocale() == $locale && $translation->getField() == $column) {
                return $translation->getContent();
            }
        }
        return null;
    }
}
