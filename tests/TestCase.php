<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @psalm-template RealInstanceType of object
     *
     * @psalm-param class-string<RealInstanceType> $originalClassName
     *
     * @return MockObject&RealInstanceType
     */
    protected function inject(string $originalClassName)
    {
        $mock = $this->createMock($originalClassName);
        $this->app->instance($originalClassName, $mock);

        return $mock;
    }
}
