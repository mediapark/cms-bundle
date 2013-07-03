<?php

namespace MediaparkLt\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Mediapark\MainBundle\Entity\MpTranslatable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="MediaparkLt\CmsBundle\Entity\CmsImageRepository")
 */
class CmsImageText extends CmsElement
{
    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;
    
    /**
     * @Assert\File(maxSize="10000000")
     */    
    private $image_file;
    
    /**
     * @var string $image
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;
    
    
    private function getFileProperties(){
        return array(
            'image' => &$this->image,
            'image_file' => &$this->image_file,
        );
    }

    public function getImageWebPath() {
        $property = $this->getFileProperties();
            return null === $property['image'] ?
                null : $this->getUploadDir('image') . '/' . $property['image'];
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
        return __DIR__ . '/../../../../web/' . $this->getUploadDir($property_name);
    }

    public function getUploadDir($property_name) {
        return 'uploads/cms/image-text/' . $property_name;
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

    /**
     * Set text
     *
     * @param string $text
     * @return CmsImageText
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set image
     *
     * @param string $image
     * @return CmsImageText
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $file
     */
    public function setImageFile(UploadedFile $file = null)
    {
        $this->image_file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getImageFile()
    {
        return $this->image_file;
    }

}