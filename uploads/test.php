<?php
$file_list = glob('tests/*.json');

$num = $_GET['test'];
$num = (int)$num;
$num++;

foreach ($file_list as $key => $file)
{
    if ($key == $_GET['test'])
    {
        $file_test = file_get_contents($file_list[$key]);
        $decode_file = json_decode($file_test, true);
    }
}

$count_answer = 0;
$count_questions = 0;

?>
<html>
<head>
    <title>Тест по математике <?=$num;?></title>
</head>
<body>
<?php if (!empty($_POST))
{
    foreach ($_POST as $key => $val)
    {
        $quest = str_replace("_", " ", $key);
        $exp_answer = explode("/", $quest);

        if ($val == true) {
            $count_answer++;
            $count_questions++;
            echo "<p>Ответ: " . $exp_answer[1] . "<br>" . "Вопрос: $exp_answer[0] </p>";
            echo "<p>Верно</p><br>";
        }
        else
        {
            $count_questions++;
            echo "<p>Ответ: " . $exp_answer[1] . "<br>" . "Вопрос: $exp_answer[0] </p>";
            echo "<p>Не вернo</p><br>";
        }
    }
 ?>
    <p><a href="admin.php">Загрузка теста</a></p>
    <p><a href="list.php">Выбор теста</a></p>
<?php } else {?>
    <form method="post" style="margin-top: 20px">
        <?php
        for($i=0; $i<count($decode_file); $i++) {
            $question = $decode_file[$i]['question'];
            $answer = $decode_file[$i]['answer'];
            ?>
            <fieldset style="margin: 20px 0">
                <legend><?=$question?></legend>
                <?php foreach ($answer as $key => $val) : ?>
                    <label><input type="radio" name="<?=$question . "/" . $val['variant'];?>" value="<?=$val['result'];?>"> <?=$val['variant'];?></label><br>
                <?php endforeach; ?>
            </fieldset>

        <?php } ?>

        <input type="submit" value="Отправить">
    </form>

    <br>

    <p><a href="admin.php">Загрузка теста</a></p>
    <p><a href="list.php">Выбор теста</a></p>

<?php } ?>

</body>
</html>