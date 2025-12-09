<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Jeu de l'Arc-en-ciel</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        #container-arc-en-ciel {
            display: flex;
            justify-content: center;
            gap: 0;
            margin: 30px auto;
            min-height: 200px;
            padding: 10px;
            border: 2px dashed #ccc;
            background-color: white;
            width: fit-content;
        }

        .morceau-arc-en-ciel {

            width: 100px;
            height: 300px;
            object-fit: cover;
            cursor: grab;
            border: 1px solid transparent;
        }

        .morceau-arc-en-ciel:active {
            cursor: grabbing;
            opacity: 0.6;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #555;
        }

        #message {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            height: 30px;
        }

        .gagne {
            color: green;
        }

        .perdu {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Reconstituez l'Arc-en-ciel</h1>
    <p>Glissez et déposez les images pour les remettre dans l'ordre (1 à 6).</p>

    <button id="btn-melanger">Mélanger</button>
    <button id="btn-verifier">Vérifier le résultat</button>

    <div id="container-arc-en-ciel">

        <img src="img/arc1.png" class="morceau-arc-en-ciel" data-id="1" draggable="true" alt="Partie 1">

        <img src="img/arc2.png" class="morceau-arc-en-ciel" data-id="2" draggable="true" alt="Partie 2">

        <img src="img/arc3.png" class="morceau-arc-en-ciel" data-id="3" draggable="true" alt="Partie 3">

        <img src="img/arc4.png" class="morceau-arc-en-ciel" data-id="4" draggable="true" alt="Partie 4">

        <img src="img/arc5.png" class="morceau-arc-en-ciel" data-id="5" draggable="true" alt="Partie 5">

        <img src="img/arc6.png" class="morceau-arc-en-ciel" data-id="6" draggable="true" alt="Partie 6">

    </div>

    <div id="message"></div>

    <script>
        const container = document.getElementById('container-arc-en-ciel');
        const btnMelanger = document.getElementById('btn-melanger');
        const btnVerifier = document.getElementById('btn-verifier');
        const messageBox = document.getElementById('message');

        let elementDrague = null;

        function melanger() {
            const enfants = Array.from(container.children);
            enfants.sort(() => Math.random() - 0.5);

            container.innerHTML = "";
            enfants.forEach(enfant => {
                container.appendChild(enfant);
            });

            messageBox.textContent = "";
            messageBox.className = "";
        }

        const pieces = document.querySelectorAll('.morceau-arc-en-ciel');

        pieces.forEach(piece => {
            piece.addEventListener('dragstart', function() {
                elementDrague = piece;
                setTimeout(() => piece.style.display = 'none', 0);
            });

            piece.addEventListener('dragend', function() {
                setTimeout(() => piece.style.display = 'block', 0);
                elementDrague = null;
            });
        });

        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            const apresElement = getDragAfterElement(container, e.clientX);
            if (apresElement == null) {
                container.appendChild(elementDrague);
            } else {
                container.insertBefore(elementDrague, apresElement);
            }
        });

        function getDragAfterElement(container, x) {
            const draggableElements = [...container.querySelectorAll('.morceau-arc-en-ciel:not([style*="display: none"])')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = x - box.left - box.width / 2;
                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

        function verifier() {
            const piecesActuelles = document.querySelectorAll('.morceau-arc-en-ciel');
            let estCorrect = true;

            piecesActuelles.forEach((piece, index) => {
                const idAttendu = index + 1;
                const idReel = parseInt(piece.getAttribute('data-id'));

                if (idReel !== idAttendu) {
                    estCorrect = false;
                }
            });

            if (estCorrect) {
                messageBox.textContent = "Vous avez gagné !";
                messageBox.className = "gagne";
            } else {
                messageBox.textContent = "Vous avez perdu.";
                messageBox.className = "perdu";
            }
        }

        btnMelanger.addEventListener('click', melanger);
        btnVerifier.addEventListener('click', verifier);
    </script>
</body>

</html>