<?php

namespace App\SharedKernel\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        // ContractClass::class => RepositoryClass::class,
    ];

    protected array $configs = [
        // 'path' => 'paya.key,
    ];

    protected array $rules = [
        // 'rule_name' => RuleClass::class,
    ];

    protected array $translations = [
        // 'path' => 'namespace',
    ];

    // overwrite this property if its necessary
    protected array $translationJsons = [
        // 'path',
    ];

    protected array $events = [
        // 'event' => [
        //     'listeners',
        // ],
    ];

    protected array $listeners = [
        // 'listener' => [
        //     'events',
        // ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->configs as $path => $key) {
            $this->mergeConfigFrom($path, $key);
        }

        foreach ($this->repositories as $contract => $repository) {
            $this->app->bind($contract, $repository);
        }

        foreach ($this->translations as $path => $namespace) {
            $this->loadTranslationsFrom($path, $namespace);
        }

        foreach ($this->translationJsons as $path) {
            $this->loadJsonTranslationsFrom($path);
        }
    }

    /**
     * Bootstrap any application services.
     *
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        foreach ($this->rules as $rule => $ruleClass) {
            Validator::extend(
                $rule,
                function ($attribute, $value) use ($ruleClass) {
                    return app()->make($ruleClass)->passes($attribute, $value);
                },
                app()->make($ruleClass)->message()
            );
        }

        $providerEvents = $this->events;
        foreach ($this->listeners as $listener => $events) {
            foreach (array_unique($events) as $event) {
                $providerEvents[$event][] = $listener;
            }
        }
        foreach ($providerEvents as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }

        $this->loadRoutes();
    }

    protected function loadRoutes(): void {}
}
