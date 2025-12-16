<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Pokedex Filter</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: inline-block;
            width: 100px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .card strong {
            color: #333;
        }
    </style>
</head>

<body>

    <h1>Recherche de Pokémon</h1>

    <div class="form-group">
        <label for="id">ID :</label>
        <input type="text" id="id" placeholder="ex: 25">
    </div>

    <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" placeholder="ex: Pikachu">
    </div>

    <div class="form-group">
        <label for="type">Type :</label>
        <select id="type">
            <option value="">-- Tous les types --</option>
            <option value="Plante">Plante</option>
            <option value="Feu">Feu</option>
            <option value="Eau">Eau</option>
            <option value="Électrik">Électrik</option>
            <option value="Insecte">Insecte</option>
            <option value="Fée">Fée</option>
            <option value="Psy">Psy</option>
            <option value="Normal">Normal</option>
        </select>
    </div>

    <input type="button" id="btn-filtrer" value="Filtrer">

    <hr>

    <div id="resultats"></div>

    <script>
        const btn = document.getElementById("btn-filtrer");
        const divResultats = document.getElementById("resultats");

        function rechercherPokemon() {
            const idRecherche = document.getElementById("id").value.trim();
            const nomRecherche = document.getElementById("nom").value.trim().toLowerCase();
            const typeRecherche = document.getElementById("type").value;

            fetch('pokemon.json')
                .then(response => {
                    if (!response.ok) throw new Error("Fichier introuvable");
                    return response.json();
                })
                .then(data => {
                    const pokemonsFiltres = data.filter(pokemon => {

                        if (idRecherche !== "" && pokemon.id.toString() !== idRecherche) {
                            return false;
                        }

                        if (nomRecherche !== "" && !pokemon.name.toLowerCase().includes(nomRecherche)) {
                            return false;
                        }

                        if (typeRecherche !== "" && pokemon.type !== typeRecherche) {
                            return false;
                        }

                        return true;
                    });

                    afficherResultats(pokemonsFiltres);
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    divResultats.innerHTML = "<p style='color:red'>Erreur de chargement (utilisez un serveur local !)</p>";
                });
        }

        function afficherResultats(liste) {
            divResultats.innerHTML = "";

            if (liste.length === 0) {
                divResultats.innerHTML = "<p>Aucun Pokémon ne correspond à votre recherche.</p>";
                return;
            }

            liste.forEach(pokemon => {
                const div = document.createElement("div");
                div.className = "card";
                div.innerHTML = `<strong>#${pokemon.id}</strong> - ${pokemon.name} <em>(${pokemon.type})</em>`;
                divResultats.appendChild(div);
            });
        }

        btn.addEventListener("click", rechercherPokemon);
    </script>

</body>

</html>