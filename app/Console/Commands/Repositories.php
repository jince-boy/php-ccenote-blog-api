<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * 这是定义了一个artisan 命令，用于生成Repositories类
 */
class Repositories extends GeneratorCommand
{
    protected $name = 'make:repositories';

    protected $description = '生成Repositories类';

    protected $type='Repositories';

    protected function getStub(): string
    {
        return $this->laravel->basePath('/stubs/Repositories.stub');
    }
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Repositories';
    }
}
