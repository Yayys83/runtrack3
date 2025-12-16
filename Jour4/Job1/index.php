<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Exercice Fetch</title>
</head>

<body>

    <button id="button">Charger l'expression</button>

    <script>
        const btn = document.getElementById("button");

        btn.addEventListener("click", function() {

            fetch('expression.txt')
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erreur réseau ou fichier introuvable");
                    }
                    return response.text();
                })
                .then(texteRecupere => {
                    const nouveauParagraphe = document.createElement("p");

                    nouveauParagraphe.textContent = texteRecupere;

                    document.body.appendChild(nouveauParagraphe);
                })
                .catch(error => {
                    console.error("Il y a eu un problème avec l'opération fetch :", error);
                    alert("Attention : Fetch ne fonctionne pas en double-cliquant sur le fichier HTML. Utilisez un serveur local (ex: Live Server sur VS Code).");
                });
        });
    </script>

</body>

</html>