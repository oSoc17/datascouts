<?php namespace App\Models;

use Ramsey\Uuid\Uuid;

trait UuidForKey
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();


        // When creating event popup, exec that closure
        // getKeyName’ will get the name of the primary key, 
        // Just in case, it is you changed into something else then ‘id’
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid1();
        });
    }
}


