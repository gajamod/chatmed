<?php 
defined('BASEPATH') or exit('No se permite acceso directo');
/**
* 
*/

class conversacionModel{
    public function __construct(){
        //parent::__construct();
    }

    public function asignarA($chat,$medico){
        $query="UPDATE `hilos` SET `medico`=? WHERE `id`=?";
        if ($this->existeConversacion($chat)) {
            $result=afectados_query($query,"ii",$medico,$chat);
            if ($result==1) {
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }
    public function cerrarConversacion($id){
        $query="UPDATE `hilos` SET `estatus`=0, `fechaCierre`=NOW() WHERE `id`=?";
        if ($this->existeConversacion($id)) {
            $result=afectados_query($query,"i",$id);
            if ($result==1) {
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }
        
    }

    public function registrarRespuesta($respuesta,$medico,$token,$conversacion){
        $respuesta=htmlentities($respuesta);
        // Si sesion valida
        //     Si existe conversacion y conversacion.paciente==paciente
        //         Si no Existe token en conversacion
        //             Guardar respuesta
        //             return true
        //         Else
        //             return -2
        //     Else
        //         return -3
        // Else
        //     return -4
        if (Session::valid_session()) {
            if ($this->existeConversacion($conversacion)) {
                if (!($this->existeTokenRespuesta($token,$conversacion))) {
                    $query="INSERT INTO `respuestas`( `hilo`, `respuesta`,`medico`,`token`) VALUES (?,?,?,?);";
                    $id=id_query($query,"isis",$conversacion,$respuesta,$medico,$token);
                    //mose("respuesta",$respuesta);
                    //$id=2;
                    if (is_numeric($id) and $id>0) {
                        return $id;
                    } else {
                        return -3;
                    }
                    
                }else {
                    return -2;
                }
            } else {
               return -2;
            }
        } else {
            return -4;
        }
        
    }

    public function getConversacion($registro){
        //obtiene todos los datos de la conversacion, incluyendo los respuestas
        if ($this->existeConversacion($registro)) {
            $conversacion['info']=$this->getInfo($registro);
            $conversacion['respuestas']=$this->getRespuestas($registro);
            return $conversacion;
        } else {
            return false;

        }
    }

    private function getRespuestas($conversacion){
        /****obtiene todas las respuestas
        **formato de entrega array:
        foreach:
        [id_respuesta]={'respuesta','tipo','nombre'(paciente o dr segun caso),'fecha'}
        **/
        $query="SELECT r.`id`, `respuesta`, r.`paciente`, r.`medico`, r.`fecha_registro`,p.nombre AS 'n_pac',m.nombre AS 'n_dr'
                FROM `respuestas` r
                LEFT JOIN pacientes p ON r.paciente=p.id
                LEFT JOIN medicos m ON r.medico=m.id
                WHERE `hilo`=?";
        $results=resultados_query($query,"i",$conversacion);
        $cant=mysqli_num_rows($results);
        if ($cant>=1) {
            $resp = array();
            //$resp['cantidad']=$cant;
            while ($r=mysqli_fetch_array($results)) {
                if (is_numeric($r['medico'] ) and $r['medico']>0) {
                    $nom=$r['n_dr'];
                    $tip=1;
                } else {
                    $nom=$r['n_pac'];
                    $tip=0;
                }
                $resp[$r['id']]= array(
                    'respuesta' => $r['respuesta']
                    ,'fecha' => $r['fecha_registro']
                    ,'tipo' => $tip
                    ,'nombre'=> $nom
                );
            }
            return $resp;
        } else {
            return 0;
        }

    }

    public static function busquedaHilo($text='',$area=null,$estatus="1",$asignados=false){
        //Obtiene informacion de los hilos del paciente
        $text='%'.htmlentities($text).'%';
        if (Session::valid_session()) {
            $medico=$_SESSION['id'];

            $vals = array();
            $tipos = 's';
            $addtoQuery='';
            if (is_numeric($area) and $area>=1) {
                $vals[]=$area;
                $tipos.='i';
                $addtoQuery.=" and (h.area=?)";
            } 
            if (is_numeric($estatus) and $estatus>=0) {
                $vals[]=$estatus;
                $tipos.='i';
                $addtoQuery.=" and estatus=? ";
            } 
            if (is_numeric($asignados) and $asignados>=1 ) {
                $vals[]=$asignados;
                $tipos.='i';
                $addtoQuery.=" and h.medico=? ";
            }elseif ($asignados==0) {
                $addtoQuery.=" and h.medico IS NULL ";
            }


            $query="SELECT h.id,h.motivo,h.area,a.nombre as 'nombre_area',h.fechacreacion,h.estatus,h.paciente AS 'num_pac',h.medico AS 'num_dr',p.nombre AS 'n_pac',m.nombre AS 'n_dr'
                FROM hilos h
                inner join soport16_chatdoc.areas a on h.area=a.id
                LEFT JOIN pacientes p ON h.paciente=p.id
                LEFT JOIN medicos m ON h.medico=m.id
                WHERE h.motivo like ? ".$addtoQuery." 
                ORDER BY id DESC";
            $results=resultados_query($query,$tipos,$text,(isset($vals[0])?$vals[0]:null),(isset($vals[1])?$vals[1]:null),(isset($vals[2])?$vals[2]:null));
            //mose("query",$query);
            $cant=mysqli_num_rows($results);
            if ($cant>=1) {
                $hilos = array();
                $hilos['cantidad']=$cant;
                while ($r=mysqli_fetch_array($results)) {
                    $hilos['registros'][$r['id']]= array(
                    'motivo' => $r['motivo']
                    ,'fecha' => $r['fechacreacion']
                    ,'nombre_area' => $r['nombre_area']
                    ,'num_area' => $r['area']
                    ,'estatus' => $r['estatus']
                    ,'nombre_pac' => $r['n_pac']
                    ,'num_pac' => $r['num_pac']
                    ,'nombre_dr' => $r['n_dr']
                    ,'num_dr' => $r['num_dr']
                    
                );}
                return $hilos;
            } else {
                return 0;
            }
        } else {
            return -4;
        }

        /*
        foreach:
        [idHilo]={area, estatus,motivo}
        */
    }

    public static function getAreas(){
        //obtiene Areas disponibles para consulta
        $query="SELECT id, nombre FROM areas";
        $results=resultados_query($query,"");
        $cant=mysqli_num_rows($results);
        if ($cant>=1) {
            $areas = array();
            while ($r=mysqli_fetch_array($results)) {
                $areas[$r['id']]=$r['nombre'];
            }
            return $areas;
        }else{
            return false;
        }
    }

    public function existeConversacion($chat,$paciente=null){
        //TODO: completar funcion ejemplo de verificacion de existencia
        if (is_numeric($chat) and $chat>0 and is_int(intval($chat))) {
            if (is_numeric($paciente) and $paciente>0) {
                $query="SELECT `id` FROM `hilos` WHERE `id`=? and `paciente`=?";
                $results = resultados_query($query, 'ii', $chat,$paciente);
            } else {
                $query = "SELECT `id` FROM `hilos` WHERE `id`=?";
                $results = resultados_query($query, 'i', $chat);
                
            }
            $cant=mysqli_num_rows($results);
            if ( $cant== 1 ) {
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }

    private function areaValida($area){
        //verifica que el area sea valida
        if (is_numeric($area) and $area>0) {
            $query = "SELECT `id`, `nombre` FROM `areas` WHERE `id`=?";
            $results = resultados_query($query, 'i', $area);
            $cant=mysqli_num_rows($results);
            if ($cant>=1) {
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }       
    }
    private function existeTokenConversacion($token){
        //verifica si el token de la conversacion existe
            $query = "SELECT `id` FROM `hilos` WHERE `token`=?";
            $results = resultados_query($query, 's', $token);
            $cant=mysqli_num_rows($results);
            if ($cant>=1) {
                return true;
            }else{
                return false;
            }
     
    }

    private function existeTokenRespuesta($token,$conversacion){
        //verifica si el token de la conversacion existe
            $query = "SELECT `id` FROM `hilos` WHERE `token`=?";
            $results = resultados_query($query, 's', $token);
            $cant=mysqli_num_rows($results);
            if ($cant>=1) {
                return true;
            }else{
                return false;
            }
     
    }

    public function getInfo($conversacion){
        //Obtiene informacion de la conversacion
        $query = "SELECT h.`id`, h.`motivo`, h.`area`, h.`descripcion`, h.`fechacreacion`, h.`estatus`, h.`paciente`, h.`medico`, p.nombre AS 'nombre_pac',m.nombre AS 'nombre_dr',a.nombre AS 'nombre_area'
            FROM `hilos` h
            LEFT JOIN medicos m ON h.`medico`=m.id
            LEFT JOIN pacientes p ON h.`paciente`= p.id
            LEFT JOIN areas a ON h.area=a.id
            WHERE h.`id`=?";
        $results = resultados_query($query, 'i', $conversacion);
        $cant=mysqli_num_rows($results);
        if ($cant>=1) {
            $hilos = array();
            while ($r=mysqli_fetch_array($results)) {
                $hilos= array(

                'motivo' => $r['motivo']
                ,'fecha' => $r['fechacreacion']
                ,'nombre_area' => $r['nombre_area']
                ,'num_area' => $r['area']
                ,'estatus' => $r['estatus']
                ,'id' => $r['id']
                ,'descripcion' => $r['descripcion']
                ,'num_paciente' => $r['paciente']
                ,'nombre_pac' => $r['nombre_pac']
                ,'num_dr' => $r['medico']
                ,'nombre_dr' => $r['nombre_dr']
            );}
            return $hilos;
        }else{
            return false;
        }

    }
}
?>