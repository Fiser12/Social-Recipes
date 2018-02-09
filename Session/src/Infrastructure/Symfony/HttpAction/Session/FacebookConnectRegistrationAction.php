<?php

/*
 * This file is part of the Social Recipes project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Session\Infrastructure\Symfony\HttpAction\Session;

use Session\Application\Command\Session\FacebookLogInClientCommand;
use Session\Infrastructure\Symfony\Security\SocialAuthenticator;
use BenGorUser\SimpleBusBridge\CommandBus\SimpleBusUserCommandBus;
use BenGorUser\User\Domain\Model\Exception\UserAlreadyExistException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class FacebookConnectRegistrationAction
{
    private $commandBus;
    private $socialAuthenticator;
    private $formFactory;
    private $translator;
    private $flashBag;
    private $clientProvider;
    private $authenticatorHandler;
    private $urlGenerator;

    public function __construct(
        SimpleBusUserCommandBus $commandBus,
        SocialAuthenticator $socialAuthenticator,
        FormFactoryInterface $formFactory,
        TranslatorInterface $translator,
        FlashBagInterface $flashBag,
        UserProviderInterface $clientProvider,
        GuardAuthenticatorHandler $authenticatorHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->commandBus = $commandBus;
        $this->socialAuthenticator = $socialAuthenticator;
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->flashBag = $flashBag;
        $this->clientProvider = $clientProvider;
        $this->authenticatorHandler = $authenticatorHandler;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(Request $request) : Response
    {
        $facebookUser = $this->socialAuthenticator->getUserInfoFromSession($request);
        if (!$facebookUser) {
            throw new NotFoundHttpException('How did you get here without user information!?');
        }

        try {
            $this->commandBus->handle(
                new FacebookLogInClientCommand(
                    $facebookUser['id'],
                    $facebookUser['id'],
                    $facebookUser['email'],
                    $facebookUser['first_name'],
                    $facebookUser['last_name'],
                    []
                )
            );

            $request->getSession()->remove('guard.finish_registration.user_information');
            $this->flashBag->add('notice', $this->translator->trans('sign_up.success_flash', [], 'BenGorUser'));

            return $this->authenticatorHandler->authenticateUserAndHandleSuccess(
                $this->clientProvider->loadUserByUsername($facebookUser['email']),
                $request,
                $this->socialAuthenticator,
                'user'
            );
        } catch (UserAlreadyExistException $exception) {
            $this->flashBag->add('error', $this->translator->trans(
                'sign_up.error_flash_user_already_exist', [], 'BenGorUser'
            ));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_homepage'));
    }
}