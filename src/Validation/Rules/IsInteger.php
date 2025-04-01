<?php

namespace Luizfilipezs\Framework\Validation\Rules;

use Attribute;
use Luizfilipezs\Framework\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IsInteger extends ValidationRule
{
    /**
     * {@inheritdoc}
     */
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'This field must be an integer.');
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value): bool
    {
        return is_integer($value);
    }
}
