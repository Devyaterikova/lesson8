<?php
require_once 'functions.php';
if (!isCookie() && !isAuthorized()) {
    header(http_response_code(403));
    die;
}
$file_list = glob('uploads/*.json');
$number = 0;
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Список тестов</title>
</head>
<body>
<?php
foreach ($file_list as $key => $file) {
    $number++;
    $file_test = file_get_contents($file);
    $decode_file = json_decode($file_test, true);
    echo "Выберите тест" . PHP_EOL;
    echo "<a href=\"test.php?test=$key\">Тест № $number</a><br>";
}
?>
<?php if(isAuthorized()) { ?>
    <p><a href="admin.php">Загрузка теста</a></p>
<?php } ?>
<p><a href="logout.php">Выход</a></p>
</body>
</html>