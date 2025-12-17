<!DOCTYPE html>
<html>
<head>
    <title>Vigenère Cipher</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; margin: 20px; }
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<h2>Vigenère Cipher</h2>

<form method="post">
    <label>Teks:</label><br>
    <input type="text" name="teks" required><br><br>

    <label>Kunci:</label><br>
    <input type="text" name="kunci" required><br><br>

    <label>Pilih Proses:</label><br>
    <input type="radio" name="proses" value="enkripsi" checked> Enkripsi
    <input type="radio" name="proses" value="dekripsi"> Dekripsi<br><br>

    <input type="submit" name="submit" value="Proses">
</form>

<?php
function vigenereCipher($text, $key, $mode) {
    $text = strtoupper($text);
    $key = strtoupper($key);
    $result = "";
    $keyIndex = 0;
    $table = [];

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $plainNum = ord($char) - 65;
            $keyChar = $key[$keyIndex % strlen($key)];
            $keyNum = ord($keyChar) - 65;

            if ($mode == "enkripsi") {
                $cipherNum = ($plainNum + $keyNum) % 26;
            } else {
                $cipherNum = ($plainNum - $keyNum + 26) % 26;
            }

            $cipherChar = chr($cipherNum + 65);
            $result .= $cipherChar;

            $table[] = [
                "pos" => $i + 1,
                "plain" => $char,
                "plainNum" => $plainNum,
                "keyChar" => $keyChar,
                "keyNum" => $keyNum,
                "cipherNum" => $cipherNum,
                "cipherChar" => $cipherChar
            ];

            $keyIndex++;
        } else {
            $result .= $char;
        }
    }

    return ["result" => $result, "table" => $table];
}

if (isset($_POST['submit'])) {
    $text = $_POST['teks'];
    $key = $_POST['kunci'];
    $mode = $_POST['proses'];

    $hasil = vigenereCipher($text, $key, $mode);

    echo "<h3>Hasil " . ucfirst($mode) . "</h3>";
    if ($mode == "enkripsi") {
        echo "Plaintext: $text<br>";
        echo "Kunci: $key<br>";
        echo "Ciphertext: <b>" . $hasil['result'] . "</b><br><br>";
    } else {
        echo "Ciphertext: $text<br>";
        echo "Kunci: $key<br>";
        echo "Plaintext: <b>" . $hasil['result'] . "</b><br><br>";
    }

    echo "<h4>Tabel Proses " . ucfirst($mode) . "</h4>";
    echo "<table>";
    echo "<tr><th>Pos</th><th>Plain Char</th><th>Plain Num</th><th>Key Char</th><th>Key Num</th><th>Cipher Num</th><th>Cipher Char</th></tr>";
    foreach ($hasil['table'] as $row) {
        echo "<tr>";
        echo "<td>{$row['pos']}</td>";
        echo "<td>{$row['plain']}</td>";
        echo "<td>{$row['plainNum']}</td>";
        echo "<td>{$row['keyChar']}</td>";
        echo "<td>{$row['keyNum']}</td>";
        echo "<td>{$row['cipherNum']}</td>";
        echo "<td>{$row['cipherChar']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

</body>
</html>