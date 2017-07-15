<?php namespace App\Models;

trait BaseModel
{


    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (array_key_exists('url', $model->getAttributes())) {
                $slug = str_slug($model->name, '_');
                $model->url = $model->getTable().'-'.$slug;
            }
        });
    }
}
