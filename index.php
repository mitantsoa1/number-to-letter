<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    use App\NumberToLetter;

    // include('src/NumberToLetter.php');

    $convert = new NumberToLetter();

    echo $convert->convertNumberToLetter(15, '', 'en');

    ?>
</body>

</html>