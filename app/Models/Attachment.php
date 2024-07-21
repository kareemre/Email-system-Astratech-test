<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['email_id', 'file_name', 'file_path'];

    /**
     * relationship with email model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}