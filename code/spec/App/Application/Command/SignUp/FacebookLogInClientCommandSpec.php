<?php

namespace spec\App\Application\Command\SignUp;

use App\Application\Command\SignUp\FacebookLogInClientCommand;
use PhpSpec\ObjectBehavior;

class FacebookLogInClientCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('facebookId', 'facebookAccessToken', 'email@gmail.com', 'ruben', 'garcia', [32, 21]);
        $this->shouldHaveType(FacebookLogInClientCommand::class);
        $this->firstName()->shouldBe('ruben');
        $this->lastName()->shouldBe('garcia');
        $this->facebookId()->shouldBe('facebookId');
        $this->facebookAccessToken()->shouldBe('facebookAccessToken');
        $this->email()->shouldBe('email@gmail.com');
        $this->usersFollowers()->shouldBe([32, 21]);
    }
}
