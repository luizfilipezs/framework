<?php

namespace Luizfilipezs\Framework\Validation\Rules;

use Attribute;
use Luizfilipezs\Framework\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IsEmail extends ValidationRule
{
    /**
     * {@inheritdoc}
     */
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'This field must be a valid email.');
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
