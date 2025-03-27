<?php

namespace Luizfilipezs\Framework\Validation\Rules;

use Attribute;
use Luizfilipezs\Framework\Helpers\ArrayHelper;
use Luizfilipezs\Framework\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Nested extends ValidationRule
{
    /**
     * @param class-string $nestedClass
     */
    public function __construct(public readonly string $nestedClass, ?string $message = null)
    {
        parent::__construct($message ?? 'This field must be another object.');
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value): bool
    {
        if (is_object($value)) {
            return $value instanceof $this->nestedClass;
        }

        return is_array($value) && ArrayHelper::isAssociative($value);
    }
}
