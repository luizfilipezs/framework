<?php

namespace Luizfilipezs\Application\Modules\User\Dto;

use Luizfilipezs\Framework\Validation\Rules\{IsEmail, IsNotEmpty, IsString, MinLength, Required};

final class UpdateUserDto
{
    #[Required]
    #[IsString]
    #[IsNotEmpty]
    public string $name;

    #[Required]
    #[IsEmail]
    public string $email;

    #[Required]
    #[IsString]
    #[MinLength(8)]
    public string $newPassword;

    #[Required]
    #[IsString]
    #[MinLength(8)]
    public string $oldPassword;
}
