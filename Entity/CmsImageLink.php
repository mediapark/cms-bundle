<?php

namespace Mp\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CmsImageLink extends CmsImage
{
    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;
    

    
    /**
     * Set url
     *
     * @param string $url
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

}
