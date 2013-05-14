<?php
	
	interface IHackerDoor
	{
		public function GetState();
		public function SwitchState();
	}
	
	class HackerDoor implements IHackerDoor
	{
        private function HackerDoor()
        {

        }

        public static function Instance()
        {
            return new HackerDoor();
        }

		public function GetState()
		{
			$state =  shell_exec('/usr/local/bin/gpio -g read 4');
			return $state;
		}
		
		public function SwitchState()
		{
			shell_exec('sudo /home/pi/spacecontrol/do_lock.sh');
		}
	}
	
	class Debug_HackerDoor implements IHackerDoor
	{
		private $CurrentStateFileName;

        public function Debug_HackerDoor($StatePath)
        {
            $this->CurrentStateFileName = $StatePath;
        }

        public static function Instance()
        {
            return new Debug_HackerDoor("data/debug_state.txt");
        }
	
		public function GetState()
		{
            if(!file_exists($this->CurrentStateFileName) ||
                filesize($this->CurrentStateFileName) < 1)
            {
                return false;
            }

			$handle = fopen($this->CurrentStateFileName, "r");
			$contents = fread($handle, 1);
			fclose($handle);

            return $contents;
		}
		
		public function SwitchState()
		{
            $currentState = $this->GetState();

            if($currentState == 1)
            {
                $this->SetState(0);
            }
            else
            {
                $this->SetState(1);
            }
		}

        private function SetState($State)
        {
            $handle = fopen($this->CurrentStateFileName, "w");
            fwrite($handle, $State);
            fclose($handle);
        }
	}

?>