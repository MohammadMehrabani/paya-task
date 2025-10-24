<?php

return [
    App\Providers\AppServiceProvider::class,
    \App\Domains\TransferRequest\TransferRequestServiceProvider::class,
    \App\Domains\Account\AccountServiceProvider::class,
    \App\Domains\Admin\AdminServiceProvider::class,
];
