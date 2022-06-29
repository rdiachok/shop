<?php

namespace App\Utils;

use Symfony\Component\Console\Exception\InvalidArgumentException;

class Validator
{
    public function validateFirstName(?string $firstName): string
    {
        if (1 !== preg_match("/^[a-zA-Z\-\ ]+$/", $firstName)) {

            throw new InvalidArgumentException('The first name must contain only lowercase latin characters and underscores.');
        }

        return $firstName;
    }

    public function validateLastName(?string $lastName): string
    {
        if (1 !== preg_match("/^[a-zA-Z\-\ ]+$/", $lastName)) {
            throw new InvalidArgumentException('The last name '. $lastName .' must contain only lowercase latin characters and underscores.');
        }

        return $lastName;
    }

    public function validateEmail(?string $email): string
    {
        if (1 !== preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/", $email)) {
            throw new InvalidArgumentException('The email must be like: example@mail.com');
        }

        return $email;
    }

}