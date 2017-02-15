<?php
    class template{
        
        private static function include_php($path){
            include $path;
        }
        public static function get_the_header(){
            self::include_php('inc/post_header.php');
        }
        
        public static function get_the_side(){
            self::include_php('inc/side.php');
        }
        
        public static function get_the_footer(){
            self::include_php('inc/footer.php');
        }

    }
;?>