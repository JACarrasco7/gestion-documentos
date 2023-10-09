<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithActiveScope
{

    /**
     * Add a scope that only return rows with status=true
     */
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $query) {
            $query->where('status', true);
        });
    }

    // public function scopeActive(Builder $query) :void
    // {
    //      $query->where('status', true);
    // }

}
