<?php

class Canvas {
    private $_size_x;
    private $_size_y;
    private $_array = [];
    
    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($size_x, $size_y)
    {
        $this->_size_x = $size_x;
        $this->_size_y = $size_y;
    }

    public function put($pos_x, $pos_y, $char, $color)
    {
        if ($pos_x >= 0 and $pos_x < $this->_size_x and $pos_y >= 0 and $pos_y < $this->_size_y)
        {
            $index = $pos_y * $this->_size_x + $pos_x;
            $this->_array[$index] = array('char' => $char, 'color' => $color);
        }
    }

    public function show()
    {
        print ( "<div class='table'>" . PHP_EOL );
        
        $pos_y = 0;
        while ( $pos_y < $this->_size_y )
        {
            $pos_x = 0;
            print ( "<div>" . PHP_EOL );
            print ( "<span style='background-color: #888;'>" . PHP_EOL );
            while ( $pos_x < $this->_size_x )
            {
                $index = $pos_y * $this->_size_x + $pos_x;
                if (array_key_exists($index, $this->_array))
                {
                    $value = $this->_array[$index];
                    printf ( "<span style='background-color: %s;'>&nbsp;%s</span>", $value["color"], $value["char"]);
                }
                else
                {
                    print ( "&nbsp;&nbsp;" );
                }

                $pos_x++;
            }
            print ( "</span>" . PHP_EOL );
            print ( "</div>" . PHP_EOL );
            $pos_y++;
        }
        print ( "</div>" . PHP_EOL );
    }    
}

?>