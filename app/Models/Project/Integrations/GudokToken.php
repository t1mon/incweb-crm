<?php

namespace App\Models\Project\Integrations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudokToken extends Model
{
    use HasFactory;

    protected $table = 'integrations_gudok_tokens';

    protected $fillable = [
        'project_id',
        'token',
        'used',
    ];

    protected $casts = [
        'used' => 'boolean',
    ];

    /** Срок годности токена в минутах */
    public CONST VALIDITY_PERIOD = 5;
}
