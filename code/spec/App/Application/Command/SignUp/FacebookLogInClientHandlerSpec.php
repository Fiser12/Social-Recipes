<?php

namespace spec\App\Application\Command\SignUp;

use App\Application\Command\SignUp\FacebookLogInClientCommand;
use App\Application\Command\SignUp\FacebookLogInClientHandler;
use App\Domain\Model\User\User;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookLogInClientHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository, EntityManager $entityManager)
    {
        $this->beConstructedWith($userRepository, $entityManager);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(FacebookLogInClientHandler::class);
    }

    function it_is_invoke_null(FacebookLogInClientCommand $command, UserRepository $userRepository, EntityManager $entityManager)
    {
        $command->firstName()->shouldBeCalled()->willReturn('firstName');
        $command->lastName()->shouldBeCalled()->willReturn('lastName');
        $command->email()->shouldBeCalled()->willReturn('email@gmail.com');
        $command->facebookAccessToken()->shouldBeCalled()->willReturn('facebookAccessToken');
        $command->facebookId()->shouldBeCalled()->willReturn('123456');
        $command->usersFollowers()->shouldBeCalled()->willReturn([]);

        $userRepository->userOfEmail(Argument::type(UserEmail::class))->shouldBeCalled()->willReturn(null);

        $entityManager->persist(
            Argument::type(User::class)
        )->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this->__invoke($command);
    }
}
