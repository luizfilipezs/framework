<?php

namespace Luizfilipezs\Framework\Validation;

use Luizfilipezs\Framework\Validation\Rules\Nested;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

final class ClassValidator
{
    private array $reflectionClasses = [];

    public function validate(object $object): ValidationResult
    {
        $errors = [];
        $reflectionClass = $this->getReflectionClass($object);

        foreach ($reflectionClass->getProperties() as $property) {
            $this->validateProperty($property, $property->getValue($object), $errors);
        }

        return new ValidationResult($errors);
    }

    public function validateFromArray(
        string $className,
        array $array,
        bool $strict = true,
    ): ValidationResult {
        $errors = [];

        foreach ($array as $key => $value) {
            try {
                $reflectionProperty = new ReflectionProperty($className, $key);
            } catch (\ReflectionException) {
                if ($strict) {
                    $errors[$key] = ["Property {$key} does not exist."];
                } else {
                    continue;
                }
            }

            $this->validateProperty($reflectionProperty, $value, $errors);
        }

        return new ValidationResult($errors);
    }

    private function getReflectionClass(object $object): ReflectionClass
    {
        $class = get_class($object);

        if (!isset($this->reflectionClasses[$class])) {
            $this->reflectionClasses[$class] = new ReflectionClass($class);
        }

        return $this->reflectionClasses[$class];
    }

    /**
     * @return ReflectionAttribute[]
     */
    private function getPropertyRules(ReflectionProperty $property): array
    {
        $attributes = $property->getAttributes();

        return array_filter($attributes, function (ReflectionAttribute $attribute) {
            return is_subclass_of($attribute->getName(), ValidationRule::class);
        });
    }

    private function validateProperty(
        ReflectionProperty $property,
        mixed $value,
        array &$errors,
    ): void {
        $propertyName = $property->getName();
        $ruleAttributes = $this->getPropertyRules($property);

        foreach ($ruleAttributes as $ruleAttribute) {
            $rule = $ruleAttribute->newInstance();

            if (!$rule->validate($value)) {
                $errors[$propertyName][] = $rule->message;
                continue;
            }

            if ($rule instanceof Nested) {
                $validation = is_array($value)
                    ? $this->validateFromArray($rule->nestedClass, $value)
                    : $this->validate($value);

                if (!$validation->isValid) {
                    $errors[$propertyName] = $validation->errors;
                }
            }
        }
    }
}
