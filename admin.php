<?php
require_once 'functions.php';
if (!isAuthorized()) {
    redirect('index');
}
$file_list = glob('uploads/*.json');
$file_send = false;
if (isset($_FILES['test']['name']) && !empty($_FILES['test']['name'])) {
    foreach ($file_list as $key => $file) {
        echo '<pre>';
        $file_user = basename($file);
        if ($_FILES['test']['name'] == $file_user) {
            header('Refresh: 2;');
            echo "Файл с таким именем существует" . "<br>" . "Через 2 сек. Вы будете возвращены на страницу загрузки";
            exit;
        }
    }
    $i = explode(".", $_FILES['test']['name']);
    if (end($i) == "json") {
        $file_tmp = $_FILES['test']['tmp_name'];
        $file_get_tmp = file_get_contents($file_tmp);
        $decode_tmp = json_decode($file_get_tmp, true);
        foreach ($decode_tmp as $test_tmp) {
            if (isset($test_tmp['question']) && isset($test_tmp['answers'])) {
                for ($i = 0; $i < count($test_tmp['answers']); $i++) {
                    if ((isset($test_tmp['answers'][$i]['answer']) && isset($test_tmp['answers'][$i]['result'])) == false) {
                        header('Refresh: 3;');
                        echo "Ошибка, загрузите новый файл." . "<br>" . "Через 3 сек. Вы будете возвращены на страницу загрузки";
                        unlink($file_tmp);
                        echo "<p><a href=\"admin.php\">Загрузка теста</a></p>";
                        echo "<p><a href=\"list.php\">Выбор теста</a></p>";
                        exit;
                    }
                }
            } else {
                header('Refresh: 3;');
                echo "Ошибка, загрузите новый файл." . "<br>" . "Через 3 сек. Вы будете возвращены на страницу загрузки";
                unlink($file_tmp);
                echo "<p><a href=\"admin.php\">Загрузка теста</a></p>";
                echo "<p><a href=\"list.php\">Выбор теста</a></p>";
                exit;
            }
        }
        $file_name = $_FILES['test']['name'];
        $tmp_file = $_FILES['test']['tmp_name'];
        $upload_dir = 'uploads/';
        if (($_FILES['test']['error'] == UPLOAD_ERR_OK) &&
            move_uploaded_file($tmp_file, $upload_dir . $file_name)) {
            $file_send = true;
            echo "Файл отправлен";
        } else {
            echo "Файл не отправлен";
        }
    } else {
        echo "Неверное расширение";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Форма для тестов</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <?php if ($file_send != true) { ?>
        <label for="test" style="margin-bottom: 15px; display: block; cursor: pointer;">Загрузите файл</label>
    <?php } else { ?>
        <label for="test" style="margin-bottom: 15px; display: block; cursor: pointer;">Еще</label>
    <?php } ?>
    <input type="file" name="test" id="test"><br><br>
    <input type="submit" name="test" value="Отправить">
</form>
<p><a href="list.php">Выбор теста</a></p>
<p><a href="admin.php">Загрузка теста</a></p>
<p><a href="logout.php">Выход</a></p>
</body>
</html>
