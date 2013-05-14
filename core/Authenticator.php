<?php

    require_once("RandomStringGenerator.php");
    require_once("Factories.php");
    require_once("User.php");

    class Authenticator
    {
        private $UsersFileName = "data/users.txt";
        private $USERNAME_PASSWORD_DELIMITER = "¶";

        public function ValidateCredentials($InputUsername, $InputPassword)
        {
            $User = $this->FindUser($InputUsername);

            if($User == null)
            {
                return false;
            }

            $HashedInputPassword = $this->Hash($InputPassword, $User->PasswordSalt);
            return $HashedInputPassword == $User->PasswordHash;
        }

        public function FindUser($InputUsername)
        {
			$InputUsername = $this->ClearInput($InputUsername);
            $InputUsername = strtolower($InputUsername);

            $FileSize = filesize($this->UsersFileName);
            if(!file_exists($this->UsersFileName) ||
                $FileSize < 1)
            {
                return null;
            }

            $handle = fopen($this->UsersFileName, "r");
            $contents = fread($handle, $FileSize);
            fclose($handle);

            $UsersStrings = explode("\n", $contents);

            foreach($UsersStrings as $i => $UserString)
            {
                $UserNamePassword = explode($this->USERNAME_PASSWORD_DELIMITER, $UserString);

                if(sizeof($UserNamePassword) != 3)
                {
                    return null;
                }

                $Username = $UserNamePassword[0];
                $PasswordHash = $UserNamePassword[1];
                $PasswordSalt = $UserNamePassword[2];

                if($Username == $InputUsername)
                {
                    $User = new User();
                    $User->Username = $Username;
                    $User->PasswordHash = $PasswordHash;
                    $User->PasswordSalt = $PasswordSalt;
                    return $User;
                }
            }

            return null;
        }

        public function AddUser($Username, $Password)
        {
			$Username = $this->ClearInput($Username);
		
            $Salt = $this->GenerateRandomSalt();

            $UserEntry = strtolower($Username);
            $UserEntry .= $this->USERNAME_PASSWORD_DELIMITER;
            $UserEntry .= $this->Hash($Password, $Salt);
            $UserEntry .= $this->USERNAME_PASSWORD_DELIMITER;
            $UserEntry .= $Salt;
            $UserEntry .= "\n";

            $handle = fopen($this->UsersFileName, "a");
            fwrite($handle, $UserEntry);
            fclose($handle);
        }

        private function GenerateRandomSalt()
        {
            $RandomStringGenerator = RandomStringGeneratorFactory::CreateRandomStringGenerator();
            return $RandomStringGenerator->GetRandomString();
        }
		
		private function ClearInput($Input)
		{
			$Input = str_replace("\n", "", $Input);
			$Input = str_replace($this->USERNAME_PASSWORD_DELIMITER, "", $Input);
			return $Input;
		}

        private function Hash($Input, $Salt)
        {
            $Data = $Input . $Salt;
            $Hashed = hash("sha256", $Data);
            return $Hashed;
        }
    }

?>