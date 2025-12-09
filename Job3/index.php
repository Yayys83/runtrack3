<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu du Taquin - La Plateforme_</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding-top: 30px;
        }

        h1 {
            margin-bottom: 10px;
        }

        #game-container {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #333;
        }

        #grid {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-template-rows: repeat(3, 100px);
            gap: 5px;
            background-color: #333;
            padding: 5px;
            border-radius: 5px;
            margin: 20px auto;
        }

        .tile {
            width: 100px;
            height: 100px;
            cursor: pointer;
            background-size: cover;
            background-position: center;
            border-radius: 3px;
            transition: transform 0.1s ease-in-out;
        }

        .tile:hover {
            transform: scale(0.98);
        }

        .tile.empty {
            background-image: none !important;
            background-color: #ddd;
            cursor: default;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #message-area {
            min-height: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #message {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .win-text {
            color: #27ae60;
        }

        #restart-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }

        #restart-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <h1>Taquin La Plateforme_</h1>

    <div id="game-container">
        <div id="grid">
        </div>

        <div id="message-area">
            <div id="message"></div>
            <button id="restart-btn">Recommencer une partie</button>
        </div>
    </div>


    <script>
        const gridSize = 3;
        const totalTiles = gridSize * gridSize;
        let gameState = [];
        let emptySlotIndex = 8;
        let isGameWon = false;

        const solvedState = Array.from({
            length: totalTiles - 1
        }, (_, i) => i + 1);
        solvedState.push(0);

        const gridElement = document.getElementById('grid');
        const messageElement = document.getElementById('message');
        const restartBtn = document.getElementById('restart-btn');

        function initGame() {
            isGameWon = false;
            messageElement.textContent = '';
            messageElement.className = '';
            restartBtn.style.display = 'none';

            gameState = [...solvedState];
            shuffleBoard();
            renderGrid();
        }

        function renderGrid() {
            gridElement.innerHTML = '';

            gameState.forEach((tileValue, index) => {
                const tileDiv = document.createElement('div');
                tileDiv.classList.add('tile');

                if (tileValue === 0) {

                    tileDiv.classList.add('empty');
                    emptySlotIndex = index;
                } else {

                    tileDiv.style.backgroundImage = `url('img/${tileValue}.png')`;
                    tileDiv.addEventListener('click', () => handleTileClick(index));
                }

                gridElement.appendChild(tileDiv);
            });
        }

        function handleTileClick(clickedIndex) {
            if (isGameWon) return;

            if (isAdjacent(clickedIndex, emptySlotIndex)) {
                swapTiles(clickedIndex, emptySlotIndex);

                renderGrid();

                checkWinCondition();
            }
        }

        function isAdjacent(index1, index2) {
            const row1 = Math.floor(index1 / gridSize);
            const col1 = index1 % gridSize;
            const row2 = Math.floor(index2 / gridSize);
            const col2 = index2 % gridSize;

            const sameRow = (row1 === row2);
            const adjacentCol = (Math.abs(col1 - col2) === 1);

            const sameCol = (col1 === col2);
            const adjacentRow = (Math.abs(row1 - row2) === 1);

            return (sameRow && adjacentCol) || (sameCol && adjacentRow);
        }

        function swapTiles(idx1, idx2) {
            [gameState[idx1], gameState[idx2]] = [gameState[idx2], gameState[idx1]];
        }

        function shuffleBoard() {
            for (let i = 0; i < 150; i++) {

                const neighbors = [];

                const potentialNeighbors = [emptySlotIndex - 1, emptySlotIndex + 1, emptySlotIndex - gridSize, emptySlotIndex + gridSize];

                potentialNeighbors.forEach(idx => {

                    if (idx >= 0 && idx < totalTiles && isAdjacent(idx, emptySlotIndex)) {
                        neighbors.push(idx);
                    }
                });

                const randomNeighbor = neighbors[Math.floor(Math.random() * neighbors.length)];
                swapTiles(randomNeighbor, emptySlotIndex);
                emptySlotIndex = randomNeighbor;
            }
        }


        function checkWinCondition() {

            if (gameState.join(',') === solvedState.join(',')) {
                isGameWon = true;
                messageElement.textContent = "Vous avez gagné";
                messageElement.classList.add('win-text');
                restartBtn.style.display = 'block';
            }
        }


        restartBtn.addEventListener('click', initGame);
        initGame();
    </script>
</body>

</html>