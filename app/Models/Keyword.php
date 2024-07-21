<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;


    /**
     * {@inheritDoc}
     */
    protected $fillable = ['keyword'];

    
    /**
     * relationship with category model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_keyword');
    }
}
