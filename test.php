<?php

    require_once("core/Authenticator.php");

    $Auth = new Authenticator();
    $Auth->AddUser("Daniel", "danielhuhn");

    $Result = $Auth->ValidateCredentials("daniel", "danielhuhn");

    if($Result)
    {
        echo "ok";
    }
    else
    {
        echo "nope";
    }

?>