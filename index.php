<?php

    $TITLE = "FlipDot Türsteuerung";

	require_once("http_ids.php");
    require_once("core/Factories.php");
    require_once("core/HackerDoor.php");

    $Door = HackDoorFactory::CreateHackerDoor();
    $DoorState =  $Door->GetState();

	$DoorOpenState = 0;
    $DoorStatusText = $DoorState == $DoorOpenState ? "Geöffnet" : "Geschlossen";
    $DoChangeDoorStateText = $DoorState == $DoorOpenState ? "schließen" : "öffnen";
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $TITLE ?></title>
</head>
<body>
  <h1><?php echo $TITLE ?></h1>

  <p>Tür Status: <b><?php echo $DoorStatusText ?></b></p>

  <form method="POST" action="switchDoorState.php">
	<label for="<?php echo $ID_USERNAME ?>">Benutzername</label>
	<input type="text"
	       name="<?php echo $ID_USERNAME ?>"
		   id="<?php echo $ID_USERNAME ?>" />

	<br />
	
	<label for="<?php echo $ID_PASSWORD ?>" >Passwort</label>
	<input type="text"
	       name="<?php echo $ID_PASSWORD ?>"
		   id="<?php echo $ID_PASSWORD ?>" />
		   
	<br />
	
	<input type="submit" value="Tür <?php echo $DoChangeDoorStateText ?>" />
  </form>
</body>
</html>