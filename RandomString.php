<?php
class RandomString {
    public function __construct($limit) {
        $l = range(97, 122);
        $u = range(65, 90);
        $n = range(0, 9);
        $a = array_merge($l, $u, $n);
        $s = "";
        
        for($i = 0; $i < $limit; $i++) {
            $x = $a[array_rand($a)];
            
            if($x > 9) {
                $x = chr($x);
            }
            $s .= $x;
        }
        $this->s = $s;
    }
    
    public function __toString() {
        return $this->s;
    }
}
?>
