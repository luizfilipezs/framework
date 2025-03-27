<?php

namespace Luizfilipezs\Tests\Data\Validation;

use Luizfilipezs\Framework\Validation\Rules\{IsEmail, IsNotEmpty, IsString, Required};

final class ObjectWithRules
{
    #[Required]
    public $required;

    #[IsString]
    public $string;

    #[IsNotEmpty]
    public $notEmpty;

    #[IsString]
    #[IsNotEmpty]
    public $notEmptyString;

    #[IsEmail]
    public $email;
}
