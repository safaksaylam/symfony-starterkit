<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConnectController
 *
 * @package \App\Controller
 */
class ConnectController extends BaseController
{
    /**
     * @Route("/login", name="login")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $session = $this->get('session');
        $error = $session->getFlashBag()->get('error', []);
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'pages/login.html.twig',
            compact('error', 'lastUsername')
        );
    }
}