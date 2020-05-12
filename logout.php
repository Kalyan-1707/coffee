<?php

    session_start();
    session_unset();
    session_destroy();

    header('location:https://thunder1707.000webhostapp.com');
?>