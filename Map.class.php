<?php

class Map {
    private $_arr = [];
    const MAX_X = 150;
    const MAX_Y = 100;

    public function put($x, $y, $chr, $color) {
        $i = $y * self::MAX_X + $x;
        $this->_arr[$i] = [$chr, $color];
    }
        
    public function print_map()
    {

?>

<div class="table">

<?php
        $y = 0;
        while ($y < self::MAX_Y)
        {
            print("<div><span style='background-color: #888;'>");
            $x = 0;      
            while ($x < self::MAX_X)
            {
                $i = ($y * self::MAX_X) + $x;
                
                if (array_key_exists($i, $this->_arr))
                {
                    printf("<span style='background-color: %s;'>&nbsp;%s</span>", $this->_arr[$i][1], $this->_arr[$i][0]);
                }
                else
                {
                    print ('&nbsp;&nbsp;');
                }
                $x++;
            }
            print("</span></div>\n");
            $y++;
        }
?>

</div>

<?php

    }
}

?>