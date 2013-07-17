<?php

namespace Mp\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

abstract class MpController extends Controller {


    /**
     * Get or creates current MpSession
     *
     * @return MpSession current MpSession instance
     */
    public function getSession() {
        $id = 'sess';
        $s = $this->getRequest()->getSession();
        if (!$s->get($id)) {
            $r = new ReflectionClass($this->container->getParameter('cms.session.class'));
            $session = $r->newInstanceArgs();
            $s->set($id, $session);
        }
        return $s->get($id);
    }

    /**
     * Check if entity is defined and throws a 404 exception if not
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function assertEntity($entity, $message = null) {
        if (!$entity) {
            throw $this->createNotFoundException($message);
        }
    }

    /**
     * Gets user from current security context
     *
     * @return User|string current user or "anon." if not authenticated
     */
    public function getCurrentUser() {
        return $this->container->get('security.context')->getToken()->getUser();
    }

    /**
     * Gets forms first encountered error
     *
     * @return string
     */
    protected function getFirstFormError(Form $form) {
        $error = false;
        $errorArray = $form->getErrors();
        if (count($errorArray) > 0) {
            $error = $errorArray[0]->getMessage();
        } else {
            foreach ($form->all() as $child) {
                $errorArray = $child->getErrors();
                if (count($errorArray) > 0) {
                    $error = $errorArray[0]->getMessage();
                    break;
                }
            }
        }
        return $error;
    }
    
    /**
     * Creates translatable form
     *
     * @return \Symfony\Component\Form\Form
     */
    public function createForm($type, $data = null, array $options = array()) {
        $form = parent::createForm($type, $data, $options);
        if (method_exists($data, 'getTranslations')) {
            $translations = $data->getTranslations();
            foreach ($translations as &$trans) {
                try {
                    $form->get('trans_'.$trans->getField().'_'.$trans->getLocale())->setData($trans->getContent());
                } catch (\OutOfBoundsException $e){
                }
            }
        }
        return $form;
    }
    
    /**
     * Recursively uploads attached form fields with file types and sets field values
     *
     * @param \Symfony\Component\Form\FormInterface form to process
     * @param MpEntity data bound to form
     * 
     * @return \Symfony\Component\Form\Form
     */
    protected function upload(\Symfony\Component\Form\FormInterface $form, $entity) {

        $fields_to_delete = array();
        $fields_to_upload = array();
        
        foreach ($form->all() as $child) {
            /* form field that starts with delete_[field] , will trigger $entity->removeUpload($field)*/
            if ((strpos($child->getName(), "delete_") === 0) && ($child->getData() == 1)) {
                $name = str_replace('delete_', '', $child->getName());
                $fields_to_delete[] = $name;
            }
            
            /* form field that ends with [field]_file, will trigger $entity->upload($field)*/            
            if ((strpos($child->getName(), "_file") === strlen($child->getName()) - 5) && $child->getData()) {
                $name = str_replace("_file", "", $child->getName());
                $fields_to_upload[] = $name;
            }
            
            if ($child->getData() instanceof \Mp\CmsBundle\Entity\CmsElement) {
                $this->upload($child, $child->getData());
            }
        }

        foreach ($fields_to_delete as $field) {
            $entity->removeUpload($field);                
            $method_name = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            if (method_exists($entity, $method_name)) {
                $entity->$method_name(null);
            }
        }
        
        foreach ($fields_to_upload as $field) {
            if (!in_array($field, $fields_to_delete)) {
                $field_file = $field . '_file';
                $method_name = 'get' . str_replace('_', '', ucwords($field_file));
                
                if (method_exists($entity, $method_name)) {
                    if (!$this->container->getParameter('cms.uploads.keep_on_change')) {
                        $entity->removeUpload($field);
                    }
                    $entity->upload($field);
                }
            }
        }
        
    }

}
