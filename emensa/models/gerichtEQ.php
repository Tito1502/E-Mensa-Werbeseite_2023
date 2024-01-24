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
    public function getPreisInternAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getPreisExternAttribute($value)
    {
        return number_format($value, 2);
    }

    // Mutator für die Attribute preis_intern und preis_extern
    public function setPreisInternAttribute($value)
    {
        $this->attributes['preisintern'] = str_replace(',', '.', $value);
    }

    public function setPreisExternAttribute($value)
    {
        $this->attributes['preisextern'] = str_replace(',', '.', $value);
    }

    // Accessor für die Attribute vegetarisch und vegan
    public function getVegetarischAttribute($value)
    {
        return $this->transformBooleanAttribute($value);
    }

    public function getVeganAttribute($value)
    {
        return $this->transformBooleanAttribute($value);
    }

    // Mutator für die Attribute vegetarisch und vegan
    public function setVegetarischAttribute($value)
    {
        $this->attributes['vegetarisch'] = $this->transformBooleanValue($value);
    }

    public function setVeganAttribute($value)
    {
        $this->attributes['vegan'] = $this->transformBooleanValue($value);
    }

    // Hilfsmethode zur Umwandlung von "Yes", "Ja" zu true und "No", "Nein" zu false
    private function transformBooleanValue($value)
    {
        $lowercaseValue = strtolower(trim($value));

        return in_array($lowercaseValue, ['yes', 'ja']);
    }

    // Hilfsmethode zur Umwandlung von true zu "Yes" und false zu "No"
    private function transformBooleanAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }
}
