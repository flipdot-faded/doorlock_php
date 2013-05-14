<?php
    interface IRandomStringGenerator
    {
        public function GetRandomString();
    }

    class RandomStringGenerator implements IRandomStringGenerator
    {
        public function GetRandomString()
        {
            $fp = fopen('/dev/urandom', 'r');
            $randomString = fread($fp, 32);
            fclose($fp);
            return base64_encode($randomString);
        }
    }

    class Debug_RandomStringGenerator implements IRandomStringGenerator
    {
        public function GetRandomString()
        {
            return uniqid(mt_rand(), true);
        }
    }
?>