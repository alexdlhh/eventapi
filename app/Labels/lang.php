<?php

namespace App\Labels;

class Lang
{

    public function __construct()
    {}

    public static function _t($key,$lang)
    {
        $file = base_path('app/Labels/' . $lang . '.php');
        if (file_exists($file)) {
            include $file;
            if (isset($labels[md5($key)])) {
                return $labels[md5($key)];
            }else{
                //recorremos app/Labels y insertamos la key en el fichero
                $files = glob(base_path('app/Labels/*.php'));
                foreach($files as $file){
                    if (file_exists($file) && $file != base_path('app/Labels/lang.php')) {
                        //incluimos una nueva linea en el archivo en cada idioma
                        $fp = fopen($file, 'a');
                        fwrite($fp, '$labels[\''.md5($key).'\'] = \''.$key."';\r"."\n");
                        fclose($fp);
                    }
                }
            }
        }
        return $key;
    }
}
