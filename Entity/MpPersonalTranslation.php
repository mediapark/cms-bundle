<?php

namespace Mp\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mp\CmsBundle\Entity\MpPersonalTranslation
 *
 * @ORM\MappedSuperclass
 */
abstract class MpPersonalTranslation
{
    /**
     * Convinient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string $locale
     *
     * @ORM\Column(type="string", length=8, name="locale")
     */
    private $locale;

    /**
     * @var string $field
     *
     * @ORM\Column(type="string", length=255, name="field")
     */
    private $field;

    /**
     * Related entity with ManyToOne relation
     * must be mapped by user
     */
    protected $object;

    /**
     * @var text $content
     *
     * @ORM\Column(type="text", nullable=true, name="content")
     */
    private $content;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return AbstractTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Get locale
     *
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return AbstractTranslation
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Get field
     *
     * @return string $field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return AbstractTranslation
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }
}