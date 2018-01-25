<?php
require_once 'functions.php';
if (!isAuthorized()) {
    redirect('index');
}

$test_list = glob('uploads/*json');
foreach ($test_list as $key => $file) {
    if ($key == $_GET['test']) {
        unlink($file);
        redirect('list');
    }
}
