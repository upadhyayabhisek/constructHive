<?php
session_start();

function destroy_session()
{
    $_SESSION = [];
    session_destroy();
}
destroy_session();
header("Location: homepage.php");
exit();
