<?php

    require_once("HackerDoor.php");
    require_once("RandomStringGenerator.php");

    class HackDoorFactory
    {
        public static function CreateHackerDoor()
        {
            // Debug
            //return Debug_HackerDoor::Instance();

            // Release
            return HackerDoor::Instance();
        }
    }

    class RandomStringGeneratorFactory
    {
        public static function CreateRandomStringGenerator()
        {
            // Debug
            //return new Debug_RandomStringGenerator();

            // Release
            return new RandomStringGenerator();
        }
    }

?>