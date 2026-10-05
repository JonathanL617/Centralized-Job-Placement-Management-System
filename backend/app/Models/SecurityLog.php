<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    protected $table = 'security_logs';
    protected $primaryKey = 'log_id';
    protected $fillable = ['user_id', 'action_type', 'target_entity', 'target_id', 'ip_address'];

    // SQL schema only has created_at, no updated_at
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
