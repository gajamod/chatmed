<?php 
defined('BASEPATH') or exit('No se permite acceso directo');
/**
* 
*/

class estadisticasModel{
    public function __construct(){
        //parent::__construct();
    }



    public function medicos(){
        $query="CALL estat_medicos();";
        try {
            $results=resultados_query($query,'');
            //var_dump($results);
            $cant=mysqli_num_rows($results);
        } catch (Exception $e) {
            echo $e;
        }
        
            if ($cant>=1) {
                $data = array();

                while ($r=mysqli_fetch_array($results)) {
                    $data['values'][]=$r['cant'];
                    $data['labels'][]=empty($r['n_dr'])?"Sin Asignar":$r['n_dr'];
                }
                return $data;
            }else {
                return false;
            }
    }

    public function areas(){
      $query="CALL estat_areas(); ";
        try {
            $results=resultados_query($query,'');
            $cant=mysqli_num_rows($results);
        } catch (Exception $e) {
            echo $e;
        }
            if ($cant>=1) {
                $data = array();

                while ($r=mysqli_fetch_array($results)) {
                    $data['values'][]=$r['cant'];
                    $data['labels'][]=$r['nombre'];
                }
                return $data;
             }else {
                return false;
            }
    }

}
?>