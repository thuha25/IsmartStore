<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'name_page', 'slug', 'state', 'user_id', 'created_by','created_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
