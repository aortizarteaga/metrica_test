<?php
class ClearPar{
    public function build($var) {
	  $array=$var;
      $apariciones=substr_count($array, '()');

      for ($i=0; $i < $apariciones; $i++) {
          echo "()";
      }
    }
}

 echo ClearPar::build("()()(");

?>
