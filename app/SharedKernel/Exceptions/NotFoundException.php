<?php

namespace App\SharedKernel\Exceptions;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Throwable;

class NotFoundException extends BaseException
{
    public function report(): void {}

    public function __construct($message = '', $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function resource(string $name): self
    {
        return new self(__('paya::messages.notfound', [
            'resource' => Lang::has('paya::resources.'.$name)
                ? __('paya::resources.'.$name)
                : $name,
        ]));
    }

    public static function fromModel(string $model): self
    {
        return self::resource(Str::snake(class_basename($model)));
    }
}
