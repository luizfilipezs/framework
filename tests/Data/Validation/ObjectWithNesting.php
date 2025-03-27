<?php

namespace Luizfilipezs\Tests\Data\Validation;

use Luizfilipezs\Framework\Validation\Rules\{Nested, Required};

final class ObjectWithNesting
{
    #[Required]
    public $required;

    #[Nested(ObjectWithRules::class)]
    public $nested;
}
