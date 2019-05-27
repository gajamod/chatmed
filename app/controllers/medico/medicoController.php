<?php
defined('BASEPATH') or exit('No se permite acceso directo');

class medicoController extends Controller
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
    $this->model = new medicoModel();
    
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
    //si post con param validos, registra respuesta luego
    //recibe el numero de conversacion y la muestra
    // si no existe muestra error
    if (Session::valid_session()) {
      

      //mostrar medico
      if (isset($params[0]) and is_numeric($params[0]) and $params[0]>=1) {
        if($this->model->existeMedico($params[0])){
          $param['medico']=$this->model->getInfo($params[0]);
          $this->render(__CLASS__,"info", $param);
        } else {
          $params['msg'] = "No se encontro el medico";
          $this->render(__CLASS__,"back", $params);
        }
      } else {
          $texto=isset($_GET['t'])?htmlentities($_GET['t']):'';
          $area=isset($_GET['a'])?htmlentities($_GET['a']):null;
          $param['resultados']=$this->model->busquedaMedico($texto,$area);
          $param['area']=$area;
          $param['texto']=$texto;
          $param['dareas']=conversacionModel::getAreas();
          $this->render(__CLASS__,null, $param); 
      }
      
       
      

      

       
      

    } else {
      $params['msg'] = "No tienes permiso de estar aqui";
      $this->render(__CLASS__,"back", $params);
    }
    

  }






}