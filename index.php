<?php
define("MAX_ATTEMPS", 6);

$possibleWords = ["Bebida", "Prisma", "Ala", "Dolor", "Piloto", "Baldosa", "Terremoto", "Asteriode", "Gallo"];
$playerDraw = [
        "   
            +---+   
            |   |
                |
                |
                |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
                |
                |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
            |   |
                |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
           /|   |
                |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
           /|\  |
                |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
           /|\  |
           /    |
                |
            =========
        ",
        "
            +---+
            |   |
            O   |
           /|\  |
           / \  |
                |
            =========
        "
];

$choosenWord = strtolower($possibleWords[rand(0, count($possibleWords) -1)]);
$wordLength = strlen($choosenWord);
$discoveredLetters = str_pad("", $wordLength, "_");
$attempts = 0;

function startGame(): void
{
    echo "¡Bienvenido al ahorcado! \n\n";
    global $attempts;
    do {
        showGameMenu();
        $playerLetter = readLetter();
        echo "\n\n";
        if(hasChar($playerLetter)) {
            revealLetter($playerLetter);
        } else {
            $attempts++;
        }
    } while(continueGame());
    showFinalMessage();
}

function showFinalMessage(): void {
    global $attempts, $playerDraw;
    if($attempts == MAX_ATTEMPS) {
        echo "-- DERROTA -- \n". $playerDraw[$attempts] . "\n Has perdido, vuelve a intentarlo.";
    } else {
        echo "-- FELICIDADES -- \n  Has ganado.";
    }
}

function showGameMenu() : void {
    global $wordLength, $discoveredLetters, $attempts, $playerDraw;
    echo "Palabra de $wordLength letras \n";
    echo $playerDraw[$attempts] . "\n";
    echo (MAX_ATTEMPS - $attempts) . " intentos restantes. \n\n";
    echo $discoveredLetters . "\n\n";

}

function continueGame(): bool {
    global $attempts, $discoveredLetters, $choosenWord;
    return $attempts < MAX_ATTEMPS && $choosenWord != $discoveredLetters;
}

function hasChar(String $playerInput) : bool {
    global $choosenWord;
    return str_contains($choosenWord, $playerInput);
}

function revealLetter(String $playerInput): void {
    global $choosenWord, $discoveredLetters;
    $offset = 0;
    while(($letterPosition = strpos($choosenWord, $playerInput, $offset)) !== false) {
        $discoveredLetters[$letterPosition] = $playerInput;
        $offset = $letterPosition + 1;
    }
}

function readLetter() : String {
    return strtolower(readline("Escribe una letra: "));
}

startGame();