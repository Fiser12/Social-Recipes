<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\User;

class UserFacebookId
{
    /**
     * The id in a primitive type.
     *
     * @var string|int
     */
    private $id;


    /**
     * Constructor.
     *
     * @param string $id User facebook id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the id.
     *
     * @return string|int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Method that checks if the id given is equal to the current.
     *
     * @param UserFacebookId $aToken The token
     *
     * @return bool
     */
    public function equals(UserFacebookId $id)
    {
        return $this->id === $id->id();
    }

}
