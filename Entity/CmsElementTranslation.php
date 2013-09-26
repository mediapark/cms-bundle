<?php

namespace Mp\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Mp\CmsBundle\Entity\MpPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="cms_element_translation",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class CmsElementTranslation extends MpPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="Mp\CmsBundle\Entity\CmsElement", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

    /**
     * Set object
     *
     * @param \Mp\CmsBundle\Entity\CmsElement $object
     * @return CmsElement
     */
    public function setObject(\Mp\CmsBundle\Entity\CmsElement $object = null)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return \Mp\CmsBundle\Entity\CmsElement
     */
    public function getObject()
    {
        return $this->object;
    }
}
