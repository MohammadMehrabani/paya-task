<?php

namespace App\SharedKernel\Providers;

use App\Models\Admin\Admin;
use App\Models\TransferRequest\PayaTransferRequest;
use App\SharedKernel\Constants\MorphMapConstants;
use App\SharedKernel\Contracts\Domains\AccountDomainContract;
use App\SharedKernel\Contracts\Domains\AdminDomainContract;
use App\SharedKernel\Contracts\Domains\TransferRequestDomainContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\Relation;

class BaseServiceProvider extends AbstractServiceProvider
{
    protected array $domains = [
        TransferRequestDomainContract::class => \App\Domains\TransferRequest\Main::class,
        AccountDomainContract::class => \App\Domains\Account\Main::class,
        AdminDomainContract::class => \App\Domains\Admin\Main::class,
    ];

    protected array $rules = [
        'valid_sheba_format' => \App\SharedKernel\Rules\ValidShebaFormat::class,
        'admin_exists'       => \App\SharedKernel\Rules\Admin\AdminExists::class,
        'account_exists'       => \App\SharedKernel\Rules\Account\AccountExists::class,
    ];

    protected array $translations = [
        __DIR__.'/../Lang' => 'paya',
    ];

    protected array $translationJsons = [
        __DIR__.'/../Lang',
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        foreach ($this->domains as $domainContract => $domainMainEntry) {
            $this->app->singleton($domainContract, function ($app) use ($domainMainEntry) {
                return $app->make($domainMainEntry);
            });
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
        Relation::enforceMorphMap([
            MorphMapConstants::PAYA_TRANSFER_REQUESTS => PayaTransferRequest::class,
            MorphMapConstants::ADMINS                  => Admin::class,
        ]);

        parent::boot();
    }
}
