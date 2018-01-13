<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\{
    DependencyInjection\ContainerInterface,
    HttpFoundation\RedirectResponse,
    HttpFoundation\Request,
    Routing\RouterInterface
};
use Symfony\Component\Security\Core\{
    Authentication\Token\TokenInterface,
    Exception\AuthenticationException
};
use Symfony\Component\Security\Http\ {
    Authentication\AuthenticationFailureHandlerInterface,
    Authentication\AuthenticationSuccessHandlerInterface,
    Logout\LogoutSuccessHandlerInterface
};

/**
 * Class AuthHandler
 * 
 * @package App\Handler
 */
class AuthHandler implements AuthenticationFailureHandlerInterface,
    AuthenticationSuccessHandlerInterface,
    LogoutSuccessHandlerInterface
{
    private $container;
    private $em;
    private $router;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->container = $container;
        $this->em = $entityManager;
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        return RedirectResponse::create($this->router->generate('admin'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $session = $this->container->get('session');
        $session->start();

        $session->getFlashBag()->add('error', 'Kullanıcı adı veya parola hatalı');
        $session->save();

        return RedirectResponse::create($this->router->generate('login'));
    }

    public function onLogoutSuccess(Request $request)
    {
        return RedirectResponse::create($this->router->generate('login'));
    }
}