<?php

namespace Luizfilipezs\Tests\Unit\Deserialization;

use Luizfilipezs\Framework\Serialization\{ClassTransformer, DeserializationException};
use Luizfilipezs\Framework\Validation\{ClassValidator, ValidationResult};
use Luizfilipezs\Tests\Data\Validation\{ObjectWithNesting, ObjectWithRules};
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ClassTransformerTest extends TestCase
{
    public function testDeserializeInvalidData(): void
    {
        /** @var MockObject&ClassValidator */
        $classValidator = $this->createMock(ClassValidator::class);
        $deserializer = new ClassTransformer($classValidator);

        $classValidator
            ->expects($this->once())
            ->method('validateFromArray')
            ->willReturn(new ValidationResult(['required' => ['This field is required.']]));

        $this->expectException(DeserializationException::class);

        $deserializer->deserialize(ObjectWithRules::class, [
            'required' => null,
        ]);
    }

    public function testDeserializeValidData(): void
    {
        /** @var MockObject&ClassValidator */
        $classValidator = $this->createMock(ClassValidator::class);
        $deserializer = new ClassTransformer($classValidator);

        $classValidator
            ->expects($this->once())
            ->method('validateFromArray')
            ->willReturn(new ValidationResult([]));

        $instance = $deserializer->deserialize(ObjectWithRules::class, [
            'required' => 'foo',
            'string' => 'bar',
            'notEmpty' => 'baz',
            'notEmptyString' => 'qux',
            'email' => 'zBtZT@example.com',
        ]);

        $this->assertInstanceOf(ObjectWithRules::class, $instance);
        $this->assertEquals('foo', $instance->required);
        $this->assertEquals('bar', $instance->string);
        $this->assertEquals('baz', $instance->notEmpty);
        $this->assertEquals('qux', $instance->notEmptyString);
        $this->assertEquals('zBtZT@example.com', $instance->email);
    }

    public function testDeserializeWithNesting(): void
    {
        /** @var MockObject&ClassValidator */
        $classValidator = $this->createMock(ClassValidator::class);
        $deserializer = new ClassTransformer($classValidator);

        $classValidator
            ->expects($this->exactly(2))
            ->method('validateFromArray')
            ->willReturn(new ValidationResult([]));

        $instance = $deserializer->deserialize(ObjectWithNesting::class, [
            'required' => 'foo',
            'nested' => [
                'required' => 'foo',
                'string' => 'bar',
                'notEmpty' => 'baz',
                'notEmptyString' => 'qux',
                'email' => 'zBtZT@example.com',
            ],
        ]);

        $this->assertInstanceOf(ObjectWithNesting::class, $instance);
        $this->assertEquals('foo', $instance->required);
        $this->assertInstanceOf(ObjectWithRules::class, $instance->nested);
        $this->assertEquals('foo', $instance->nested->required);
        $this->assertEquals('bar', $instance->nested->string);
        $this->assertEquals('baz', $instance->nested->notEmpty);
        $this->assertEquals('qux', $instance->nested->notEmptyString);
        $this->assertEquals('zBtZT@example.com', $instance->nested->email);
    }
}
