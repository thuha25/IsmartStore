<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['image_url','position', 'status', 'user_id', 'created_by','created_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function hasPermission($permission) {
        foreach ($this->roles as $role) {
            if ($role->permissions->where('slug',$permission)->count()>0) {
                return true;
            }
        }
        return false;
    }
}
