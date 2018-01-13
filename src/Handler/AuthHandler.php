<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\{
    DependencyInjection\ContainerInterface, HttpFoundation\RedirectResponse, HttpFoundation\Request, Routing\RouterInterface, Translation\TranslatorInterface
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
    private $translator;

    /**
     * AuthHandler constructor.
     *
     * @param ContainerInterface $container
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        TranslatorInterface $translator
    )
    {
        $this->container = $container;
        $this->em = $entityManager;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        return RedirectResponse::create($this->router->generate('admin'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $session = $this->container->get('session');
        $session->start();

        $session->getFlashBag()->add('error', $this->translator->trans('auth_handler.error_message'));
        $session->save();

        return RedirectResponse::create($this->router->generate('login'));
    }

    public function onLogoutSuccess(Request $request)
    {
        return RedirectResponse::create($this->router->generate('login'));
    }
}