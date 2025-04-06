<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Boursier;
use App\Models\boursiers;

class ImportBoursiers extends Command
{
    // Le nom de la commande et l'argument 'csvFile' sont correctement définis
    protected $signature = 'import:boursiers {csvFile}'; // Assurez-vous que l'argument est défini ici

    // La description de la commande
    protected $description = 'Importer les boursiers depuis un fichier CSV';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Récupérer l'argument 'csvFile' passé à la commande
        $csvFile = $this->argument('csvFile');
        
        // Créer le chemin absolu du fichier CSV
        $csvFilePath = base_path($csvFile);

        // Vérifier si le fichier existe
        if (!file_exists($csvFilePath)) {
            $this->error("Le fichier CSV n'existe pas : $csvFilePath");
            return;
        }

        // Appeler la fonction d'importation avec le chemin du fichier CSV
        $this->importerCSV($csvFilePath);
    }

    public function importerCSV()
    {
        // Charger le fichier CSV depuis storage/app/bourse
        $csv = array_map('str_getcsv', file(storage_path('app/bourse/bousiers.csv')));
    
        // Extraire l'en-tête (noms des colonnes)
        $header = $csv[0];
        
        // Boucle pour traiter chaque ligne du CSV
        foreach ($csv as $row) {
            // Ignore la première ligne (en-tête)
            if ($row === $header) {
                continue;
            }
    
            // Créer un tableau associatif pour chaque ligne
            $data = array_combine($header, $row);
    
            // Créer un boursier avec les données extraites du CSV
            boursiers::create([
                'id_us' => $data['IDUS'],
                'nom' => $data['NOM'],
                'prenoms' => $data['PRENOMS'],
                'date_naissance' => $data['DATE_NAISSANCE'],
                'sexe' => $data['SEXE'],
                'code_demande' => $data['CODE_DEMANDE'],
                'annee' => $data['ANNEE'],
                'annee_scolaire' => $data['ANNEE_SCOLAIRE'],
                'objet_demande' => $data['OBJET_DEMANDE'],
                'pays' => $data['PAYS'],
                'ville' => $data['VILLE'],
                'etablissement_accueil' => $data['ETABLISSEMENT_ACCUEIL'],
                'mont_bourse' => $data['MONT_BOURSE'],
                'montant_assurance' => $data['MONTANT_ASSURANCE'],
                'filiere_a_faire_renseigne' => $data['FILIERE_A_FAIRE_RENSEIGNE'],
                'mont_cumul' => $data['MONT_CUMUL'],
                'filiere_choisie' => $data['FILIERE CHOISIE'],
                'etablissement_origine' => $data['ETABLISSEMENT_ORIGINE'],
                'moyenne_uep' => $data['MOYENNNE_UEP'],
                'moyenne_ueg' => $data['MOYENNNE_UEG'],
                'mga' => $data['MGA'],
                'mga_correspondant_etranger' => $data['MGA_CORRESPONDANT_ETRANGER'],
                'pts_bac' => $data['PTS_BAC'],
                'total_point_bac' => $data['TOTAL_POINT_BAC'],
                'moy_pond' => $data['MOY POND'],
                'diplome_a_faire' => $data['DIPLOME_A_FAIRE'],
                'cycle_formation_a_faire' => $data['CYCLE_FORMATION_A_FAIRE'],
                'pertinence_filiere' => $data['PERTINENCE_FILIERE'],
                'origine_diplome' => $data['ORGINE_DIPLOME'],
                'serie_filiere_effectue' => $data['SERIE/FILIERE_EFFECTUE'],
                'diplome_effectue' => $data['DIPLOME_EFFECTUE'],
                'cycle_formation_effectue' => $data['CYCLE_FORMATION_EFFECTUE'],
                'decision' => $data['DECISION'],
                'budget' => $data['BUDGET'],
                'moy_bac' => $data['Moy_Bac'],
            ]);
        }
    
        $this->info('Importation des boursiers terminée !');
    }
    

}
