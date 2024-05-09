<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class universite extends Model
{
    use HasFactory;
    protected $fillable = ['Nom', 'Adresse','Informations_contact','Description','Programmes_etudes','Infrastructures','image'];
    protected $table = 'universite';

    // Relation avec les notes attribuées par les utilisateurs
    public function ratings()
    {
        return $this->hasMany(Rating::class,'product_id');
    }

    // Méthode pour calculer la note moyenne
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    // Méthode pour récupérer les éléments classés par note moyenne décroissante
    public static function ranked()
    {
        return static::withCount('ratings')
            ->orderByRaw('(SELECT AVG(rating) FROM ratings WHERE product_id = universite.id) DESC')
            ->get();
    }
}
