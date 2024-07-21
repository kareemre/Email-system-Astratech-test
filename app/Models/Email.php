<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $fillable = ['user_id', 'from', 'to', 'subject', 'body', 'is_sent'];


    /**
     * relationship with category model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_email');
    }

    /**
     * relationship with attachment model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
