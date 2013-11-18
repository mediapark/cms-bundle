<?php

namespace Mp\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Mp\CmsBundle\Entity\MpTranslatable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @ORM\Entity(repositoryClass="Mp\CmsBundle\Entity\CmsImageRepository")
 */
class CmsImage extends CmsElement
{
    /**
     * @var string $image
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;
    
    /**
     * @var string $seo_title
     *
     * @ORM\Column(name="seo_title", type="text", nullable=true)
     */
    protected $seo_title;
        
    /**
     * @var string $seo_alt_text
     *
     * @ORM\Column(name="seo_alt_text", type="text", nullable=true)
     */
    protected $seo_alt_text;
    
    /**
     * @Assert\File(maxSize="10000000")
     */    
    protected $content_file;

    
    protected function getFileProperties(){
        return array(
            'content' => &$this->content,
            'content_file' => &$this->content_file,
        );
    }

    public function getContentWebPath() {
        $property = $this->getFileProperties();
            return null === $property['content'] ?
                null : $this->getUploadDir('content') . '/' . $property['content'];
        return null;
    }
    public function getAbsolutePath($property_name) {
        $property = $this->getFileProperties();
        if(array_key_exists($property_name, $property)){
            return null === $property[$property_name] ?
                null : $this->getUploadRootDir($property_name) . '/' . $property[$property_name];
        }
        return null;
    }

    public function getWebPath($property_name) {
        $property = $this->getFileProperties();
        if(array_key_exists($property_name, $property)){
            return null === $property[$property_name] ?
                null : $this->getUploadDir($property_name) . '/' . $property[$property_name];
        }
        return null;
    }

    public function getUploadRootDir($property_name) {
        return __DIR__ . '/../../../../../../web/' . $this->getUploadDir($property_name);
    }

    public function getUploadDir($property_name) {
        return 'uploads/cms/image/' . $property_name;
    }

    public function upload($property_name)
    {
        $property = $this->getFileProperties();

        if(!array_key_exists($property_name, $property)){
            return;
        }

        $file = $property[$property_name.'_file'];

        if (null === $file) {
            return;
        }

        $filename = sha1(uniqid(mt_rand(), true));
        $property[$property_name] = $filename.'.'.$file->guessExtension();

        $file->move($this->getUploadRootDir($property_name), $property[$property_name]);

        unset($file);
    }

    public function removeUpload($property_name)
    {
        $file = $this->getAbsolutePath($property_name);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function removeUploads()
    {
        foreach ($this->getFileProperties() as $property_name => $property_value) {
            $file = $this->getAbsolutePath($property_name);
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    
    public function __toString() {
        return $this->getContent();
    }
    
    /**
     * Set content
     *
     * @param string $content
     * @return CmsImage
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
     * Set seo_title
     *
     * @param string $seo_title
     * @return CmsImage
     */
    public function setSeoTitle($seo_title)
    {
        $this->seo_title = $seo_title;
    
        return $this;
    }

    /**
     * Get seo_title
     *
     * @return string 
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }
    
    /**
     * Set seo_alt_text
     *
     * @param string $seo_alt_text
     * @return CmsImage
     */
    public function setSeoAltText($seo_alt_text)
    {
        $this->seo_alt_text = $seo_alt_text;
    
        return $this;
    }

    /**
     * Get seo_alt_text
     *
     * @return string 
     */
    public function getSeoAltText()
    {
        return $this->seo_alt_text;
    }

    /**
     * @param UploadedFile $file
     */
    public function setContentFile(UploadedFile $file = null)
    {
        $this->content_file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getContentFile()
    {
        return $this->content_file;
    }

}
