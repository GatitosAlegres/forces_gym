<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoCampana extends Model
{
    use HasFactory;

    protected $fillable = [
        'campana_publicitaria_id',
        'presupuesto',
        'observaciones',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($presupuestoCampana) {
            // Obtener la campaña publicitaria asociada al presupuesto
            $campanaPublicitaria = $presupuestoCampana->campana_publicitaria;

            // Cambiar el estado de la campaña publicitaria a "activo"
            if ($campanaPublicitaria) {
                $campanaPublicitaria->estado = '1';
                $campanaPublicitaria->save();
            }
        });

        static::deleted(function ($presupuestoCampana) {
            // Obtener la campaña publicitaria asociada al presupuesto
            $campanaPublicitaria = $presupuestoCampana->campana_publicitaria;

            // Cambiar el estado de la campaña publicitaria a "inactivo"
            if ($campanaPublicitaria) {
                $campanaPublicitaria->estado = '0';
                $campanaPublicitaria->save();
            }
        });
    }

    // Define the relationship with the campana_publicitaria model
    public function campana_publicitaria()
    {
        return $this->belongsTo(CampanaPublicitaria::class);
    }

}
