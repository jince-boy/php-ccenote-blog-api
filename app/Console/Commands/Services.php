<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * 定义了一个artisan 命令，用于生成services类
 */
class Services extends GeneratorCommand
{
    protected $name = 'make:service';

    protected $description = '生成Services类';

    protected $type='Services';

    protected function getStub(): string
    {
        return $this->laravel->basePath('/stubs/Services.stub');
    }
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Services';
    }
}
