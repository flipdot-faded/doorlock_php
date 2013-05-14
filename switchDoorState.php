<?php

    require_once("core/Authenticator.php");
	require_once("core/HackerDoor.php");
    require_once("core/Factories.php");
    require_once("http_ids.php");

    if(!isset($_POST[$ID_USERNAME]) ||
       !isset($_POST[$ID_PASSWORD]))
    {
        header("HTTP/ 400 bad request");
        die;
    }

    $InputUsername = $_POST[$ID_USERNAME];
    $InputPassword = $_POST[$ID_PASSWORD];

    $Authenticator = new Authenticator();
    $Result = $Authenticator->ValidateCredentials($InputUsername, $InputPassword);

    if($Result)
    {
        $Door = HackDoorFactory::CreateHackerDoor();
        $Door->SwitchState();

        header("Location: /");
        exit;
    }
    else
    {
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="2;URL='/'">
        <title>Böse, böse du!</title>
    </head>
    <body>
        <h1>Das war wohl nichts, du böser Hacker!</h1>
        <p>Du wirst jetzt wieder zurück zum Login gebracht ...</p>
    </body>
    </html>


<?php
    }
?>