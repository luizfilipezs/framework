<?php

namespace Luizfilipezs\Framework\Validation\Rules;

use Attribute;
use Luizfilipezs\Framework\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Length extends ValidationRule
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        public readonly int $min,
        public readonly int $max,
        ?string $message = null,
    ) {
        parent::__construct($message ?? "This field must be between {$min} and {$max} characters.");
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value): bool
    {
        if (is_string($value)) {
            return mb_strlen($value) >= $this->min && mb_strlen($value) <= $this->max;
        }

        return false;
    }
}
