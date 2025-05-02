<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'cpf',
        'phone',
        'address',
        'latitude',
        'longitude',
    ];
}
