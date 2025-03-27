<?php

namespace Luizfilipezs\Framework\Serialization;

use Luizfilipezs\Framework\Validation\ClassValidator;
use Luizfilipezs\Framework\Validation\Rules\Nested;
use ReflectionClass;
use ReflectionProperty;

class ClassTransformer
{
    public function __construct(private readonly ClassValidator $classValidator) {}

    /**
     * @template T
     *
     * @param class-string<T> $class
     * @param array<string,mixed> $data
     *
     * @return T
     */
    public function deserialize(string $class, array $data): mixed
    {
        $this->runValidation($class, $data, strict: true);

        $instance = new $class();
        $reflection = new ReflectionClass($class);

        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();

            if (!array_key_exists($propertyName, $data)) {
                continue;
            }

            $attributeNested = $this->getPropertyAttribute($property, Nested::class);

            if ($attributeNested) {
                $property->setValue(
                    $instance,
                    $this->deserialize($attributeNested->nestedClass, $data[$propertyName]),
                );
            } else {
                $property->setValue($instance, $data[$propertyName]);
            }
        }

        return $instance;
    }

    private function runValidation(string $class, array $data, bool $strict = true): void
    {
        $validation = $this->classValidator->validateFromArray($class, $data, $strict);

        if (!$validation->isValid) {
            throw new DeserializationException(
                'Data cannot be deserialized because it does not match the expected structure. Errors: ' .
                    Json::encode($validation->errors),
            );
        }
    }

    private function getPropertyAttribute(
        ReflectionProperty $property,
        string $attributeClass,
    ): ?object {
        $attributes = $property->getAttributes($attributeClass);

        if (empty($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
