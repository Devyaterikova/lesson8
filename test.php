<?php
require_once 'functions.php';

if (!isAuthorized() && !isCookie()) {
    redirect('index');
}


$file_list = glob('uploads/*.json');

$num = 1;

foreach ($file_list as $key => $file) {
    if (($key == $_GET['test'])) {
        $file_test = file_get_contents($file_list[$key]);
        $decode_file = json_decode($file_test, true);
    }
}

if (empty($decode_file)) {
    header(http_response_code(404));
    exit;
}

$count_answer = 0;
$count_questions = 0;


if (!empty($_POST))
{
    foreach ($_POST as $key => $val)
    {
        if ($val == true) {
            $count_answer++;
            $count_questions++;
        } else {
            $count_questions++;
        }
    }
    if (($count_answer / $count_questions) * 100 >= 90)
    {
        $rating = "Отлично";
    }
    elseif ((($count_answer / $count_questions) * 100 <= 90) && (($count_answer / $count_questions) * 100 >= 75))
    {
        $rating = "Хорошо";
    }
    else
    {
        $rating = "Удовлетворительно";
    }


    if (getGuestName())
    {
        $name = getGuestName();
    }
    elseif (isAuthorized())
    {
        $name = name();
    }
    $image = imagecreatetruecolor(866, 618);
    $colorBack = imagecolorallocate($image, 0, 0, 0);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    $fontFile = __DIR__ . '/font.ttf';
    $image_res = imagecreatefrompng('image.png');
    imagefill($image, 0, 0, $colorBack);
    imagecopy($image, $image_res, 0, 0, 0, 0, 866, 618);
    if (!file_exists($fontFile)) {
        echo "Файл со шрифтом не найден!";
        exit;
    }
    imagettftext($image, 40, 0, 370, 300, $textColor, $fontFile, $name);
    imagettftext($image, 20, 0, 320, 340, $textColor, $fontFile, $rating);
    imagettftext($image, 16, 0, 370, 380, $textColor, $fontFile, date("d.m.y"));
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Тест <?= $num ?></title>
</head>
<body>

<form method="post" style="margin-top: 20px">
    <?php
    for ($i = 0; $i < count($decode_file); $i++) {
        $question = $decode_file[$i]['question'];
        $answers = $decode_file[$i]['answers'];
        ?>
        <fieldset style="margin: 20px 0">
            <legend><?= $question ?></legend>
            <?php foreach ($answers as $key => $val) : ?>
                <label><input type="checkbox" name="<?= $question; ?>" value="<?= $val['result']; ?>"> <?= $val['answer']; ?></label><br>
            <?php endforeach; ?>
        </fieldset>
    <?php } ?>
    <input type="submit" value="Отправить">
</form>
<p><a href="list.php">Выбор теста</a></p>
<?php if (isAuthorized()) { ?>
    <p><a href="admin.php">Загрузка теста</a></p>
    <?php
    foreach ($file_list as $key => $file)
    {
        echo "<a href=\"delete.php?test=$key\">Удалить тест: №" . $num++ . "</a><br>";
    }
    ?>
<?php } ?>
<p><a href="logout.php">Выход</a></p>

</body>
</html>