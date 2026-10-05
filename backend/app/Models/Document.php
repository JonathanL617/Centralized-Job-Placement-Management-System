<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'document_id';
    protected $fillable = ['user_id', 'application_id', 'document_type', 'file_path', 'parsed_data'];
    protected $casts = ['parsed_data' => 'array'];

    // SQL schema uses 'uploaded_at' instead of 'created_at', and has no 'updated_at'
    const CREATED_AT = 'uploaded_at';
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }
}
