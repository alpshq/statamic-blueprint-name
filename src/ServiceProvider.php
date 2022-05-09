<?php

namespace Alps\BlueprintName;

use Alps\BlueprintName\Fieldtypes\BlueprintName;
use Statamic\Statamic;

class ServiceProvider extends \Statamic\Providers\AddonServiceProvider
{
    protected $stylesheets = [
        __DIR__ . '/../dist/js/blueprint-name.css',
    ];

    protected $scripts = [
        __DIR__ . '/../dist/js/blueprint-name.js',
    ];

    protected $fieldtypes = [
        BlueprintName::class,
    ];

    public function bootAddon()
    {
        Statamic::afterInstalled(function ($command) {
            $command->call('vendor:publish', [
                '--tag' => 'statamic-blueprint-name',
                '--force' => true,
            ]);
        });
    }
}
