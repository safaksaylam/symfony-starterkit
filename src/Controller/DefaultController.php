<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="index_action")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render(
            '@Maker/demoPage.html.twig',
            ['path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__)]
        );
    }
}
