<?php namespace App\Models;

trait BaseModel {


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->url = $model->getTable().'_'.str_slug($model->name);
        });
    }


}