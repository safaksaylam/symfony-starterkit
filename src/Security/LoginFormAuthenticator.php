<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{
    RedirectResponse, Request, Session\SessionInterface
};
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\{
    UserProviderInterface, UserInterface
};
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $em;
    private $passwordEncoder;
    private $router;


    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, RouterInterface $router)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() === '/login' && $request->isMethod('POST');

        if ( ! $isLoginSubmit) {
            return;
        }

        $session = $request->getSession();

        $session->set(
            Security::LAST_USERNAME,
            $request->request->get('email'));

        return array(
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        );
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this
            ->em
            ->getRepository('App:User')
            ->findOneBy(array('email' => $credentials['email']));
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this
            ->passwordEncoder
            ->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = null;

        if ($request->getSession() instanceof SessionInterface) {
            $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        }

        if ( ! $targetPath) {
            $targetPath = $this
                ->router
                ->generate('admin');
        }

        return new RedirectResponse($targetPath);
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl()
    {
        return $this
            ->router
            ->generate('login');
    }

    /**
     * @inheritdoc
     */
    public function supports(Request $request)
    {
        ($request->request->get('email') && $request->request->get('password')) ? true : false;
    }
}
