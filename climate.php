<?php
    class Climate{
        private $cpu_fp = "/sys/class/thermal/thermal_zone0/temp";

        public function getCPUTemp(){
            $fh = fopen($this->cpu_fp, "r");
            $cpu_temp = (float)fgets($fh) / 1000;
            fclose($fh);
            return number_format($cpu_temp, 2);
        }
    }
?>