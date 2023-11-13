<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Labels\Lang;

class RestrictiveHelper
{
    private $user;
    protected $lang;
    /**
     * RestrictiveHelper constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->lang = new Lang();
    }
    
    /**
     * Revisión general de permisos
     * @param $season
     * @param $competition
     * @param $request
     * 
     * @return bool
     */
    public function checkPermissions($season, $competition, $request, $_lang='en', $id=false){
        $this->usage($request);
        return true;
    }

    /**
     * en public crearemos si no existe un archivo llamado usage.json en el cual guardaremos información de uso de la api por usuario e ip
     */
    public function usage($request){
        $user = Auth::user();
        $user = $user->id.'/'.$user->name.' '.$user->email;
        $ip = $_SERVER['REMOTE_ADDR'];
        $filename = 'metrics/usage.json';

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
}