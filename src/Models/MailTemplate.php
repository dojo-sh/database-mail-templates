<?php

namespace DojoSh\DatabaseMailTemplates\Models;

use DojoSh\DatabaseMailTemplates\Exceptions\MissingMailTemplate;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class MailTemplate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeForMailable(Builder $query, Mailable $mailable): Builder
    {
        return $query->where('mailable', get_class($mailable));
    }

    public static function findForMailable(Mailable $mailable): self
    {
        $mailTemplate = static::forMailable($mailable)->first();

        if (! $mailTemplate) {
            throw MissingMailTemplate::forMailable($mailable);
        }

        return $mailTemplate;
    }
}
