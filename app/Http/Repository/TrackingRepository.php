<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use App\Labels\Lang;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\JWTAuth;

class TrackingRepository{

    public function __construct()
    {}

    /**
     * Vamos a proporcionar una forma sencilla de trackear impresiones sobre diversos proyectos
     * @param string $proyect
     * @param string $ip
     * @param string $key
     */
    public function track_proyect($proyect,$key='no_key_to_track'){
        if(empty($ip)){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $location = file_get_contents("http://ip-api.com/json/{$ip}");
        $user_id = 0;
        $exist = DB::connection('mysql')->select("SELECT * FROM `ip_locations` WHERE `ip` = '{$ip}' AND `user` = {$user_id}");
        if(!empty($exist)){
            DB::connection('mysql')->update("UPDATE `ip_locations` SET `last_location` = '{$location}', `last_connection` = NOW() WHERE `ip` = '{$ip}' AND `user` = {$user_id}");
        } else {
            DB::connection('mysql')->insert("INSERT INTO `ip_locations` (`ip`, `last_location`, `first_connection`, `last_connection`, `user`) VALUES ('{$ip}', '{$location}', NOW(), NOW(), {$user_id});");
        }
        
        $this->save_usage($proyect,$key);

        return true;
    }
        
    /**
     * en public crearemos si no existe un archivo llamado usage.json en el cual guardaremos información de uso de la api por usuario e ip
     */
    public function save_usage($proyect,$request){
        $user = 0;
        $ip = $_SERVER['REMOTE_ADDR'];
        $filename = 'tracking/'.$proyect.'/usage.json';
        //si no existe la carpeta $proyect la creamos
        if(!file_exists('tracking/'.$proyect)){
            mkdir('tracking/'.$proyect);
        }
        // Si el archivo no existe, lo creamos con un JSON vacío
        if(!file_exists($filename)){
            $f=fopen($filename,'w');
            fwrite($f,json_encode(array()));
            fclose($f);
        }

        // Intentamos bloquear el archivo para escribir en él
        $f = fopen($filename, 'a');
        if (flock($f, LOCK_EX)) {
            // Obtenemos los datos del archivo y los decodificamos
            $json = file_get_contents($filename);
            $data = json_decode($json, true);

            // Actualizamos los datos según los parámetros de la URL
            $date = date('Y-m-d');
            if(!empty($data[$user][$ip][$date][$request]['count'])){
                $data[$user][$ip][$date][$request]['count']++;
            } else {
                $data[$user][$ip][$date][$request]['count'] = 1;
            }

            // Escribimos los datos actualizados en el archivo
            ftruncate($f, 0); // Vaciamos el archivo
            fwrite($f, json_encode($data)); // Escribimos los datos actualizados
            fflush($f); // Forzamos la escritura en disco
            flock($f, LOCK_UN); // Desbloqueamos el archivo
        }

        // Cerramos el archivo
        fclose($f);

    }
    
    /**
     * 
     */
    public function check_referer($referer, $client){
        $data = DB::connection('mysql')->select("SELECT * FROM `referers` WHERE `referer` = '{$referer}' AND `client` = '{$client}'");
        if(!empty($data)){
            return true;
        } else {
            return false;
        }
    }
    
}