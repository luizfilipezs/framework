<?php

namespace Luizfilipezs\Framework\Validation;

abstract class ValidationRule
{
    /**
     * Constructor.
     *
     * @param string|null $message Error message.
     */
    public function __construct(public readonly ?string $message = null) {}

    abstract public function validate(mixed $value): bool;
}
