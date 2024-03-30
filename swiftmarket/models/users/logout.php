<?php
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION["allowed_chats"]);
    header("Location: ../../index.php");
?>