<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Contact\Domain\Entities\Contact as DomainContact;
use Modules\Contact\Domain\ValueObjects\CPF;
use Database\Factories\ContactModelFactory;
use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $casts  = ['latitude'=>'float','longitude'=>'float'];
    protected $fillable = [
        'user_id','name','cpf','phone','address','latitude','longitude',
    ];

    protected static function newFactory(): ContactModelFactory
    {
        return ContactModelFactory::new();
    }

    public function toDomain(): DomainContact
    {
        return new DomainContact(
            $this->id,
            $this->user_id,
            $this->name,
            new CPF($this->cpf),
            $this->phone,
            $this->address,
            $this->latitude,
            $this->longitude,
        );
    }
}
