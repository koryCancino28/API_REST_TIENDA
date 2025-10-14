<?php

namespace Src\Shared\Traits;

use Illuminate\Support\Facades\Auth;

trait AuditableWithIp
{
    public static function bootAuditableWithIp()
    {
        static::creating(function ($model) {
            if (Auth::check()) $model->created_by = Auth::id();
            $model->created_ip = request()->ip();
        });

        static::updating(function ($model) {
            if (Auth::check()) $model->updated_by = Auth::id();
            $model->updated_ip = request()->ip();
        });

        static::deleting(function ($model) {
            if (Auth::check()) $model->deleted_by = Auth::id();
            $model->deleted_ip = request()->ip();
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                $model->save();
            }
        });
    }
}
