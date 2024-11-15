<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        
        'imagelivre',
        'description',
        'auteurID',
        
        
        
        'prix',
        'qteStock',
        'categorieID'
        ];
        public function categorie()
        {
        return $this->belongsTo(Categorie::class,"categorieID");
        }
        public function auteur()
        {
        return $this->belongsTo(Auteur::class,"auteurID");
        }
       
         

}