<?php
class ChangeString{

    public function build($var) {
	  $array=$var;
      $l=1;
      $ret = array();
      $len = mb_strlen($array, "UTF-8");

      for ($i = 0; $i < $len; $i += $l) {
          $ret[] = mb_substr($array, $i, $l, "UTF-8");
      }

      foreach ($ret as $key => $value):
        if($value=='Ñ'){
            $abecedario=79;
            $abecedario=chr($abecedario);
            $abecedario='<font color="red"><strong>'.$abecedario.'</strong></font>';
        } else if($value=='ñ'){
            $abecedario=111;
            $abecedario=chr($abecedario);
            $abecedario='<font color="red"><strong>'.$abecedario.'</strong></font>';
        } else {
          $ascii=ord($value);
          if(($ascii>=97 && $ascii<=122) || ($ascii>=65 && $ascii<=90)){
    				$abecedario=$ascii+1;
    				if($ascii==122){
    					$abecedario=97;
    				} else if($ascii==90){
    					$abecedario=65;
    				}
    				  $abecedario='<font color="red"><strong>'.chr($abecedario).'</strong></font>';
    			}else{
    				$abecedario=chr($ascii);
    			}
        }
        $cadena=$abecedario;
  			echo $cadena;
      endforeach;
    }
}

 echo ChangeString::build('123 abcd*3');

?>
