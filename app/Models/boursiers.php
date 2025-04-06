<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class boursiers extends Model
{
    protected $table = 'boursiers';  // Nom de la table
    protected $primaryKey = 'IDUS';   // Définir la clé primaire sur 'IDUS'
    public $incrementing = false;     // Indiquer que 'IDUS' n'est pas auto-incrémenté
    protected $keyType = 'string';    // Définir le type de clé comme une chaîne de caractères
    public $timestamps = false;       // Désactiver les timestamps si non utilisés

    // Attributs de la table à remplir
    protected $fillable = [
        'IDUS', 'NOM', 'PRENOMS', 'DATE_NAISSANCE', 'SEXE', 'CODE_DEMANDE', 'ANNEE', 
        'ANNEE_SCOLAIRE', 'OBJET_DEMANDE', 'PAYS', 'VILLE', 'ETABLISSEMENT_ACCUEIL', 
        'MONT_BOURSE', 'MONTANT_ASSURANCE', 'FILIERE_A_FAIRE_RENSEIGNE', 'MONT_CUMUL', 
        'FILIERE_CHOISIE', 'ETABLISSEMENT_ORIGINE', 'MOYENNNE_UEP', 'MOYENNNE_UEG', 'MGA', 
        'MGA_CORRESPONDANT_ETRANGER', 'PTS_BAC', 'TOTAL_POINT_BAC', 'MOY_POND', 
        'DIPLOME_A_FAIRE', 'CYCLE_FORMATION_A_FAIRE', 'PERTINENCE_FILIERE', 'ORGINE_DIPLOME', 
        'SERIE/FILIERE_EFFECTUE', 'DIPLOME_EFFECTUE', 'CYCLE_FORMATION_EFFECTUE', 'DECISION', 
        'BUDGET', 'Moy_Bac'
    ];
}
