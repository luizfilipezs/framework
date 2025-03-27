<?php

namespace Luizfilipezs\Framework\Validation;

final class ValidationResult
{
    /**
     * Whether the validation was successful or not.
     */
    public bool $isValid {
        get => empty($this->errors);
    }
    
    /**
     * Construtor.
     *
     * @param array<string,string[]> $errors Errors per field.
     */
    public function __construct(public readonly array $errors = []) {}
}
