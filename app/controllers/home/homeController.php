<?php
defined('BASEPATH') or exit('No se permite acceso directo');

/**
 * Home controller
 */
class homeController extends Controller
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
    $this->model = new conversacionModel();
    
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
    $texto=isset($_GET['t'])?htmlentities($_GET['t']):'';
    $area=isset($_GET['a'])?htmlentities($_GET['a']):null;
    $asignados=(isset($_GET['m']) and is_numeric($_GET['m']) and $_GET['m']>=0)? (($_GET['m']>=1)?$_GET['m']:null):false;
    $estatus=(isset($_GET['e']) and is_numeric($_GET['e']))? $_GET['e']:'';
    $param['resultados']=$this->model->busquedaHilo($texto,$area,$estatus,$asignados);
    $param['area']=$area;
    $param['asignados']=$asignados;
    $param['estatus']=$estatus;
    $param['texto']=$texto;
    $param['dareas']=conversacionModel::getAreas();
    $param['dmedicos']=medicoModel::getMedicos();
    $this->render(__CLASS__,null, $param); 
  }



}