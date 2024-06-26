<!DOCTYPE html>
<head>
    <title>Tic Tac Toe</title>
</head>
<body>
    <?php
    // Initialize the game board.
    $board = isset($_POST['board']) ? json_decode($_POST['board']):[
        ['b', 'b', 'b'],
        ['b', 'b', 'b'],
        ['b', 'b', 'b']
    ];

    // Initialize the current player and winnerFound flag.
    $currentPlayer = isset($_POST['player']) ? $_POST['player'] : 'x';
    $winnerFound = false;

    // Handle player moves.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$winnerFound) {
        $row = $_POST['row'];
        $col = $_POST['col'];

        // Check if the cell is empty.
        if ($board[$row][$col] == 'b'){
            $board[$row][$col] = $currentPlayer;

            // Check for a winner.
            $winner = checkWinner($board);
            if ($winner){
                echo "<h2>Winner!</h2>";
                $winnerFound = true; // Set the flag.
            } else{
                // Switch the player for the next turn.
                $currentPlayer = ($currentPlayer == 'x') ? 'o' : 'x';
            }
        } else{
            // Notify invalid move.
            echo "<p>Invalid move, please try again.</p>";
        }
    } elseif($_SERVER["REQUEST_METHOD"] == "POST" && $winnerFound){
        // Notify game is over.
        echo "<p>Game over. Please start a new game.</p>";
    }

    // Display the game board.
    echo '<table border="1">';
    foreach ($board as $row){
        echo '<tr>';
        foreach ($row as $cell){
            echo '<td>';
            if ($cell == 'b'){
                echo '<img src="ttt_b.png" alt="Blank" width="150" height="150">';
            } elseif ($cell == 'x' || $cell == 'o'){
                echo '<img src="' . ($cell == $winner ? 'ttt_win_' . $cell : 'ttt_' . $cell) . '.png" alt="' . strtoupper($cell) . '" width="150" height="150">';
                //echo "test";
            }
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';

    // Echo to display turns.
    echo "<p>It's $currentPlayer's turn.</p>";

    // Function to check for a winner.
    function checkWinner($board){
        // Check rows and columns.
        for ($i = 0; $i < 3; $i++){
            if ($board[$i][0] != 'b' && $board[$i][0] == $board[$i][1] && $board[$i][0] == $board[$i][2]){
                return $board[$i][0];
            }
            if ($board[0][$i] != 'b' && $board[0][$i] == $board[1][$i]&& $board[0][$i] == $board[2][$i]){
                return $board[0][$i];
            }
        }
        // Check diagonals.
        if ($board[0][0] != 'b' && $board[0][0] == $board[1][1] && $board[0][0] == $board[2][2]){
            return $board[0][0];
        }
        if ($board[0][2] != 'b' && $board[0][2] == $board[1][1] && $board[0][2] == $board[2][0]){
            return $board[0][2];
        }
        return false;
    }
   
    ?>

    <form method="post" action="">
        <input type="hidden" name="player" value="<?php echo $currentPlayer; ?>">
        <input type="number" name="row" min="0" max="2" placeholder="Row" required>
        <input type="number" name="col" min="0" max="2" placeholder="Column" required>
        <input type="hidden" name="board" value='<?php echo json_encode($board); ?>'>
        <button type="submit">
            <?php 
            echo strtoupper($currentPlayer); 
            ?>'s Turn
        </button>
    </form>
</body>
</html>
