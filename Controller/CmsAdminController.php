<?php

namespace Mediapark\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class CmsAdminController extends MpController
{    
    /**
     * @Route("/", name="admin_cms")
     */
    public function cmsHomeAction()
    {
        return $this->redirect($this->generateUrl("cms_url_skin_list"));
    }   
}
