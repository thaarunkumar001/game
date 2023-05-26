<?php

$arr1 = array();
$arr2 = array();
for ($i = 0; $i < 9; $i++) {
    array_push($arr1, 0);
    array_push($arr2, 0);
}
$filename1 = 'player1.txt';
$filename2 = 'player2.txt';
$pos1 =file_get_contents($filename1);
$pos2 = file_get_contents($filename2);
$dice1 = 0;
$dice2 = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dice1 = isset($_POST['player1']) ? $_POST['player1'] : 0;
    $dice2 = isset($_POST['player2']) ? $_POST['player2'] : 0;

    if (8 - $pos1 >= $dice1 && 8 - $pos2 >= $dice2) {
        if (($pos1 + $dice1) != 4 && ($pos2 + $dice2) != 4) {
            $arr1[$pos1] = 0;
            $arr2[$pos2] = 0;
            $pos1 += $dice1;
            if ($pos1 == $pos2) {
                $pos2 = 0;
                $pos2 += $dice2;
            } else {
                $pos2 += $dice2;
            }
            $arr2[$pos2] = 0;
            if ($pos2 == $pos1) {
                $pos1 = 0;
            }
        } else {
            $arr1[$pos1] = 0;
            $pos1 += $dice1;
            $arr2[$pos2] = 0;
            $pos2 += $dice2;
        }
    }

    $final = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    $arr1[$pos1] = 1;
    $arr2[$pos2] = 2;
    for ($i = 0; $i < 8; $i++) {
        if ($pos1 == 4 && $pos2 == 4) {
            $final[4] = 12;
        } else {
            $final[$i] = $arr1[$i] + $arr2[$i];
        }
    }
    file_put_contents($filename1, $pos1);
    file_put_contents($filename2, $pos2);
    
} else {
    $final = array_fill(0, 9, 0);
}

function display($a)
{
    echo '<table>';
    echo '<tr>';
    echo '<td>' . $a[7] . '</td>';
    echo '<td>' . $a[6] . '</td>';
    echo '<td>' . $a[5] . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>' . $a[0] . '</td>';
    echo '<td>' . $a[8] . '</td>';
    echo '<td>' . $a[4] . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>' . $a[1] . '</td>';
    echo '<td>' . $a[2] . '</td>';
    echo '<td>' . $a[3] . '</td>';
    echo '</tr>';
    echo '</table>';
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3x3 Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 300px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <label for="player1">Player 1:</label>
        <input type="number" name="player1" id="player1" required>
        <br>
        <label for="player2">Player 2:</label>
        <input type="number" name="player2" id="player2" required>
        <br>
        <input type="submit" value="Roll Dice">
    </form>

    <?php display($final); 
    // header('Location: ' . $_SERVER['REQUEST_URI']);
    // exit;
    ?>
</body>
</html>
