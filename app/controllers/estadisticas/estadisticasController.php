<?php
defined('BASEPATH') or exit('No se permite acceso directo');

class estadisticasController extends Controller
{
  /**
   * string 
   */
  public $nombre;

  /**
   * object 
   */
  public $model;

  /**
   * Inicializa valores 
   */
  public function __construct()
  {
    $this->model = new estadisticasModel();
    
  }

  /**
  * Método estándar
  */
  public function index($params)
  {
    $this->show($params);
  }

  public function show($params)
  {


      $medicos=$this->model->medicos();
      $medicos['type']="pie";
      $medicos['domain']['column']=0;
      $medicos['name']='Consultas por Medico';
      $medicos['hoverinfo']='label+percent+name';
      $medicos['hole']=.4;

      $areas=$this->model->areas();
      $areas['type']="pie";
      $areas['domain']['column']=1;
      $areas['name']='Consultas por Area';
      $areas['hoverinfo']='label+percent+name';
      $areas['hole']=.4;
      

      $param['medicos']=json_encode ($medicos);
      $param['areas']=json_encode ($areas);
      $this->render(__CLASS__,null, $param); 

    

  }






}