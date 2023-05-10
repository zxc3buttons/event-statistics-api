<?php

namespace App\Entity;

/**
 * @ORM\Enum(type=Types::STRING)
 */
enum GroupBy: string
{

    case NAME = 'name';
    case IS_AUTHORIZED = 'isAuthorized';
    case IP_ADDRESS = 'ipAddress';
}