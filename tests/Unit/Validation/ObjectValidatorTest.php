<?php

namespace Luizfilipezs\Tests\Unit\Validation;

use Luizfilipezs\Framework\Validation\ClassValidator;
use Luizfilipezs\Tests\Data\Validation\{ObjectWithNesting, ObjectWithRules};
use PHPUnit\Framework\TestCase;

final class ObjectValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $classValidator = new ClassValidator();
        $object = new ObjectWithRules();

        $object->required = null;
        $object->string = 123;
        $object->notEmpty = '';
        $object->notEmptyString = 0;
        $object->email = 'invalid-email';

        $result = $classValidator->validate($object);

        $this->assertEquals(
            expected: [
                'required' => ['This field is required.'],
                'string' => ['This field must be a string.'],
                'notEmpty' => ['This field cannot be empty.'],
                'notEmptyString' => ['This field must be a string.', 'This field cannot be empty.'],
                'email' => ['This field must be a valid email.'],
            ],
            actual: $result->errors,
            message: 'The validation errors should be correct.',
        );
        $this->assertFalse($result->isValid, 'The object should not be valid.');
    }

    public function testValidateFromArray(): void
    {
        $classValidator = new ClassValidator();
        $result = $classValidator->validateFromArray(ObjectWithRules::class, [
            'required' => null,
            'string' => 123,
            'notEmpty' => '',
            'notEmptyString' => 0,
            'email' => 'invalid-email',
        ]);

        $this->assertEquals(
            expected: [
                'required' => ['This field is required.'],
                'string' => ['This field must be a string.'],
                'notEmpty' => ['This field cannot be empty.'],
                'notEmptyString' => ['This field must be a string.', 'This field cannot be empty.'],
                'email' => ['This field must be a valid email.'],
            ],
            actual: $result->errors,
            message: 'The validation errors should be correct.',
        );
        $this->assertFalse($result->isValid, 'The object should not be valid.');
    }

    public function testValidateWithNesting(): void
    {
        $classValidator = new ClassValidator();
        $object = new ObjectWithNesting();

        $object->required = null;
        $object->nested = new ObjectWithRules();
        $object->nested->required = null;
        $object->nested->string = 123;
        $object->nested->notEmpty = '';
        $object->nested->notEmptyString = 0;
        $object->nested->email = 'invalid-email';

        $result = $classValidator->validate($object);

        $this->assertEquals(
            expected: [
                'required' => ['This field is required.'],
                'nested' => [
                    'required' => ['This field is required.'],
                    'string' => ['This field must be a string.'],
                    'notEmpty' => ['This field cannot be empty.'],
                    'notEmptyString' => [
                        'This field must be a string.',
                        'This field cannot be empty.',
                    ],
                    'email' => ['This field must be a valid email.'],
                ],
            ],
            actual: $result->errors,
            message: 'The validation errors should be correct.',
        );
        $this->assertFalse($result->isValid, 'The object should not be valid.');
    }
}
