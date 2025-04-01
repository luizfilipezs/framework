<?php

namespace Luizfilipezs\Application\Modules\User;

use Luizfilipezs\Framework\Database\{Column, ColumnType};
use Luizfilipezs\Framework\Validation\Rules\{IsEmail, IsNotEmpty, IsString, MinLength, Required};

final class User
{
    #[Column(ColumnType::INT, primary: true, autoIncrement: true)]
    public ?int $id;

    #[Column(ColumnType::STRING)]
    #[Required]
    #[IsString]
    #[IsNotEmpty]
    public string $fullName;

    #[Column(ColumnType::STRING)]
    #[Required]
    #[IsEmail]
    public string $email;

    #[Column(ColumnType::STRING)]
    #[Required]
    #[IsString]
    #[MinLength(8)]
    public string $password;
}
