<?php

use Illuminate\Database\Eloquent\Model;

class benutzerEQ extends Model
{
    protected $table = 'benutzer';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'passwort',
        'admin',
        'anzahlfehler',
        'anzahlanmeldungen',
        'letzteanmeldung',
        'letzterfehler',
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    // Weitere Einstellungen oder Beziehungen können hier hinzugefügt werden
}
