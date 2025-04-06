<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoursiersTable extends Migration
{
    public function up()
    {
        Schema::create('boursiers', function (Blueprint $table) {
            $table->string('IDUS')->primary();  // Définit 'IDUS' comme clé primaire
            $table->string('NOM');
            $table->string('PRENOMS');
            $table->date('DATE_NAISSANCE');
            $table->string('SEXE');
            $table->string('CODE_DEMANDE');
            $table->string('ANNEE');
            $table->string('ANNEE_SCOLAIRE');
            $table->string('OBJET_DEMANDE');
            $table->string('PAYS');
            $table->string('VILLE');
            $table->string('ETABLISSEMENT_ACCUEIL');
            $table->decimal('MONT_BOURSE', 15, 2);
            $table->decimal('MONTANT_ASSURANCE', 15, 2);
            $table->string('FILIERE_A_FAIRE_RENSEIGNE')->nullable();
            $table->decimal('MONT_CUMUL', 15, 2);
            $table->string('FILIERE_CHOISIE');
            $table->string('ETABLISSEMENT_ORIGINE');
            $table->decimal('MOYENNNE_UEP', 5, 2)->nullable();
            $table->decimal('MOYENNNE_UEG', 5, 2)->nullable();
            $table->decimal('MGA', 5, 2);
            $table->decimal('MGA_CORRESPONDANT_ETRANGER', 5, 2)->nullable();
            $table->decimal('PTS_BAC', 5, 2)->nullable();
            $table->decimal('TOTAL_POINT_BAC', 5, 2)->nullable();
            $table->decimal('MOY_POND', 5, 2);
            $table->string('DIPLOME_A_FAIRE');
            $table->string('CYCLE_FORMATION_A_FAIRE');
            $table->string('PERTINENCE_FILIERE');
            $table->string('ORGINE_DIPLOME');
            $table->string('SERIE/FILIERE_EFFECTUE');
            $table->string('DIPLOME_EFFECTUE');
            $table->string('CYCLE_FORMATION_EFFECTUE');
            $table->string('DECISION');
            $table->string('BUDGET')->nullable();
            $table->decimal('Moy_Bac', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boursiers');
    }
}
