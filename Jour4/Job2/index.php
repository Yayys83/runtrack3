<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Test JSON</title>
</head>

<body>

    <h1>Test de la fonction jsonValueKey</h1>
    <p>Ouvrez la console du navigateur (F12) pour voir le résultat.</p>

    <script>
        function jsonValueKey(jsonString, key) {
            try {
                const objet = JSON.parse(jsonString);
                return objet[key];
            } catch (erreur) {
                console.error("Erreur de format JSON :", erreur);
                return null;
            }
        }

        const maChaineJson = `
        {
            "name": "La Plateforme_",
            "address": "8 rue d'hozier",
            "city": "Marseille",
            "nb_staff": "11",
            "creation": "2019"
        }
        `;

        const resultat = jsonValueKey(maChaineJson, "city");

        console.log("Résultat pour la clé 'city' :", resultat);

        document.body.innerHTML += "<br><strong>Ville trouvée : " + resultat + "</strong>";
    </script>

</body>

</html>