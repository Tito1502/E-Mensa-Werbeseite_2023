<?php

use Illuminate\Database\Eloquent\Model;
require_once('benutzerEQ.php');
require_once('gerichtEQ.php');



class BewertungEQ extends Model
{
    protected $table = 'bewertungen';
    protected $primaryKey = 'id';
    public $timestamps = false; // Falls Sie keine created_at und updated_at Spalten haben

    protected $fillable = [
        'bemerkung',
        'sternbewertung',
        'bewertungszeitpunkt',
        'hervorheben',
        'gericht_id',
        'benutzer_id'
    ];

    protected $casts = [
        'hervorheben' => 'boolean',
    ];

    // Falls Sie spezielle Logik für die Konvertierung oder Validierung von Attributen benötigen, können Sie Accessors/Mutators verwenden.

    public function gericht()
    {
        return $this->belongsTo(gerichtEQ::class, 'gericht_id');
    }

    public function benutzer()
    {
        return $this->belongsTo(benutzerEQ::class, 'benutzer_id');
    }
}
