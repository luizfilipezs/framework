<?php

namespace Luizfilipezs\Framework\Validation\Rules;

use Attribute;
use Luizfilipezs\Framework\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MinLength extends ValidationRule
{
    /**
     * {@inheritdoc}
     */
    public function __construct(public readonly int $value, ?string $message = null)
    {
        parent::__construct($message ?? "This field must be at least {$value} characters.");
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value): bool
    {
        if (is_string($value)) {
            return mb_strlen($value) >= $this->value;
        }

        return false;
    }
}
