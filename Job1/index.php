<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Afficher et Cacher</title>
</head>

<body>

    <button id="btn-afficher">Afficher la citation</button>
    <button id="btn-cacher">Cacher la citation</button>

    <hr>

    <p id="zone-texte"></p>

    <script>
        const boutonAfficher = document.getElementById("btn-afficher");
        const boutonCacher = document.getElementById("btn-cacher");
        const paragraphe = document.getElementById("zone-texte");

        boutonAfficher.addEventListener("click", function() {
            paragraphe.textContent = "Les logiciels et les cathédrales, c'est un peu la même chose - d'abord on les construit, ensuite on prie.";

            paragraphe.style.display = "block";
        });

        boutonCacher.addEventListener("click", function() {
            paragraphe.style.display = "none";
        });
    </script>

</body>

</html>