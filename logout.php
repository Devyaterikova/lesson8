<?php
require_once 'functions.php';
if (isAuthorized() || isCookie()) {
    logout();
} else {
    redirect('index');
}

