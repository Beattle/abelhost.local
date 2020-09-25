<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
    public static function getTableName()
    {
        return (new static)->getTable();
    }

    public function getUserIdsAttribute()
    {
        return $this->users()->allRelatedIds();
    }
}
