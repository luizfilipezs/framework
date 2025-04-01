<?php

namespace Luizfilipezs\Application\Modules\User\Dto;

use Luizfilipezs\Framework\Validation\Rules\{IsInteger, IsString, Required};

final class UsersSearchDto
{
    #[IsString]
    public ?string $name;

    #[Required]
    #[IsInteger]
    public int $limit;

    #[Required]
    #[IsInteger]
    public int $page;
}
