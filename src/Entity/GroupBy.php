<?php

namespace App\Entity;

/**
 * @ORM\Enum(type=Types::STRING)
 */
enum GroupBy: string
{

    case NAME = 'name';
    case IS_AUTHORISED = 'is_authorised';
    case IP_ADDRESS = 'ip_address';
}