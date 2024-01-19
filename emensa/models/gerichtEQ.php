<?php

use Illuminate\Database\Eloquent\Model;

class gerichtEQ extends Model
{
    protected $table = 'gericht';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'beschreibung',
        'erfasst_am',
        'vegetarisch',
        'vegan',
        'preisintern',
        'preisextern',
        'bildname',
    ];

    protected $casts = [
        'vegetarisch' => 'boolean',
        'vegan' => 'boolean',
    ];

    protected $dates = ['erfasst_am'];

    // Weitere Einstellungen oder Beziehungen können hier hinzugefügt werden
}
