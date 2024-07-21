<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    /**
     * {@inheritDoc}
     */
    protected $fillable = ['name'];


    /**
     * relationship with message model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function emails()
    {
        return $this->belongsToMany(Email::class, 'category_message');
    }


    /**
     * relationship with keyword model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'category_keyword');
    }
}
