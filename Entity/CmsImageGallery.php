<?php

namespace Mp\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Mp\CmsBundle\Entity\MpTranslatable;

/**
 * @ORM\Entity(repositoryClass="Mp\CmsBundle\Entity\CmsImageGalleryRepository")
 */
class CmsImageGallery extends CmsElement
{
    /**
     * @ORM\OneToMany(targetEntity="CmsImage", mappedBy="parent", cascade={"persist"})
     */
    protected $children;

    /**
     * @var string $image
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set content
     *
     * @param string $content
     * @return CmsImageGallery
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add children
     *
     * @param \Mp\CmsBundle\Entity\CmsImage $children
     * @return CmsSlider
     */
    public function addChildren(\Mp\CmsBundle\Entity\CmsElement $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Mp\CmsBundle\Entity\CmsImage $children
     */
    public function removeChildren(\Mp\CmsBundle\Entity\CmsElement $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
