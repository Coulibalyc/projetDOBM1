<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Boursiers</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Liste des Boursiers</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pays</th>
                <th>Filière</th>
                <th>Cycle</th>
                <th>Établissement</th>
                <th>Montant_Bourse</th>
                <th>Année</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boursiers as $boursier)
            <tr>
                <td>{{ $boursier->NOM }}</td>
                <td>{{ $boursier->PRENOMS }}</td>
                <td>{{ $boursier->PAYS }}</td>
                <td>{{ $boursier->FILIERE_A_FAIRE_RENSEIGNE }}</td>
                <td>{{ $boursier->CYCLE_FORMATION_A_FAIRE }}</td>
                <td>{{ $boursier->ETABLISSEMENT_ACCUEIL }}</td>
                <td>{{ $boursier->MONT_BOURSE }}</td>
                <td>{{ $boursier->ANNEE_SCOLAIRE }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
