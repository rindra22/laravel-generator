<?php

namespace Tests;

use Jejookit\Generator\JejookitGeneratorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            JejookitGeneratorServiceProvider::class,
        ];
    }
}
