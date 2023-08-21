<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'thumbnail_path', 'content','slug', 'state'];

    public function categories()
    {
        return $this->belongsToMany(CatPost::class, 'category_post', 'post_id', 'cat_id');
    }
}
