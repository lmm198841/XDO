<?php
    
    namespace XDO;
    
    use XDO\XDO;
    
    class Tool{
        public static function getJson($file){
            return json_decode(file_get_contents(XDO::$DataDir.$file.'.json'),1);
        }
        public static function putJson($file,$data){
            return file_put_contents(XDO::$DataDir.$file.'.json',json_encode($data));
        }
        public static function listDir($dir,$addAuto=1){
            if($addAuto) $dir = XDO::$DataDir.$dir;
            $return = array();
            if (false != ($handle = opendir ( $dir ))) {
                $i=0;
                while ( false !== ($file = readdir ( $handle )) ) {
                    //去掉"“.”、“..”以及带“.xxx”后缀的文件
                    if ($file != "." && $file != "..") {
                        $return[] = $file;
                    }
                }
                //关闭句柄
                closedir ( $handle );
            }
            return $return;
        }
        public static function delDir($path,$addAuto=1){
            if($addAuto) $path = XDO::$DataDir.$path;
            foreach(self::listDir($path,0) as $v){
                //echo $v;
                if(is_dir($path.$v)){
                    self::delDir($path.$v);
                }else{
                    unlink($path.$v);
                }
            }
            rmdir($path);
            return true;
        }
        public static function genSalt($length, $arr){
            $s = "";
            for($i=0; $i<$length; ++$i){
                $n = rand(0, (count($arr)-1));
                $s .= $arr[$n][rand(0, (count($arr[$n])-1))];
            }
            return $s;
        }
        public static function genFileName(){
            $name = "";
            $name .= date("Y/m/d/hi-");
            $name .= self::genSalt(15, array(range('0','9'), range('a','z'), range('A','Z')));
            $name .= ".dat";
            return $name;
        }
        
    }