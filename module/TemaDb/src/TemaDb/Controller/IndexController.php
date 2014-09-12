<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaDb\Controller;

use TemaDb\Model\Categoria;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * Esta es la forma más básica de poder realizar un select * FROM tabla
     * en ZF2, usando la clase TableGateway. Al llamar al método select() 
     * devuelve un objeto de la clase ResultSet.
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewayAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select();
        return $view;
    }
    
    /**
     * Este objeto ResultSet es iterable. (como podrán ver en la vista)
     * Cada iteración por defecto es un objeto de la clase ArrayObject
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewayResultSetIteradoAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select();
        return $view;
    }
    
    /**
     * Si no queremos un ArrayObject, podemos transformarlo a un array
     * llamando al método toArray()
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewayResultSetArrayAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select()->toArray();
        return $view;
    }
    
    /**
     * A veces nos resulta muy útil que cada iteración del result set sea un
     * objeto de una entidad de nuestro modelo, para lograr esto podemos usar
     * un -Prototype-. Este prototipo debe pasar como 4to parámetro del constructor
     * de la clase TableGateway.
     * Para construir el prototipo, debemos de crear un objeto de la clase
     * ResultSet y llamar al método setArrayObjectPrototype pasándole como 
     * parámetro un objeto de la entidad a la cual queremos mapear los resultados
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewayResultSetPrototypeAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $rsPrototype = new ResultSet();
        $rsPrototype->setArrayObjectPrototype(new Categoria());
        $tableGateway = new TableGateway('categoria', $adapter, null, $rsPrototype);
        $view->data = $tableGateway->select();
        return $view;
    }
    
    /**
     * Para hacer un WHERE, podemos pasar un string al método select()
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewaySelectStringAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $rsPrototype = new ResultSet();
        $rsPrototype->setArrayObjectPrototype(new Categoria());
        $tableGateway = new TableGateway('categoria', $adapter, null, $rsPrototype);
        $view->data = $tableGateway->select("nombre LIKE '%2%'");
        return $view;
    }
    
    /**
     * Si queremos varias condicionales, podemos pasarle un array al método select()
     * @return \Zend\View\Model\ViewModel
     */
    public function tableGatewaySelectArrayAction()
    {
        $view = new ViewModel();
//        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $rsPrototype = new ResultSet();
        $rsPrototype->setArrayObjectPrototype(new Categoria());
        $tableGateway = new TableGateway('categoria', $adapter, null, $rsPrototype);
        $view->data = $tableGateway->select(array("nombre NOT LIKE '%cat%'",'id<?'=>5));
        return $view;
    }
    
    /**
     * Si queremos más flexibilidad podemos pasar un Closure
     * En este closure llega como parámetro un objeto Select
     * De este objeto select puedo llamar a varios métodos que me permitirán
     * modificar el query, entre ellos el where.
     * @return \Zend\View\Model\ViewModel
     */
    public function selectClosureAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $rsPrototype = new ResultSet();
        $rsPrototype->setArrayObjectPrototype(new Categoria());
        $tableGateway = new TableGateway('categoria', $adapter, null, $rsPrototype);
        $view->data = $tableGateway->select(function (Select $sel){
            $sel->where("nombre LIKE '%1%'")
                ->where("nombre LIKE '%2%'", PredicateSet::OP_OR)
            ;
        });
        return $view;
    }
    
    /**
     * Tambien puedo modificar las columnas que deseo seleccionar
     * @return \Zend\View\Model\ViewModel
     */
    public function selectColsArrayAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select(function (Select $select){
            $select->columns(array('nombre','activo'));
        })->toArray();
        return $view;
    }
    
    /**
     * O usar aliases para las columnas
     * Cuando se usa un alias, se debe tener cuidado de que es probable que la
     * columna ya no corresponda con el atributo del prototipo.
     * En este ejemplo dejo de usar un prototipo por esa razón
     * @return \Zend\View\Model\ViewModel
     */
    public function selectColsArrayAliasAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select(function (Select $select){
            $select->columns(array( 'categoria' => 'nombre', 'valida'=>'activo'));
        })->toArray();
        return $view;
    }
    
    /**
     * Uso de Join con aliases para evitar ambigüedades
     * @return \Zend\View\Model\ViewModel
     */
    public function joinAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('producto', $adapter);
        $view->data = $tableGateway->select(function (Select $select){
            $select->columns(array(
                'producto' => 'nombre',
                'costo'=>'precio_compra',
                'precio'=>'precio_venta'
            ))
            ->join(
                array('c'=>'categoria'),
                'c.id=producto.categoria_id',
                array('categoria'=>'nombre')
            )->join(
                array('pr'=>'proveedor'),
                'pr.id=producto.proveedor_id',
                array('proveedor'=>'nombre')
            )->limit(1);
            
//            var_dump($select->getSqlString());
//            exit;
            
        });
        return $view;
    }
    
    public function insertAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $tableGateway->insert(array(
            'nombre'=> 'Cat '.rand(111,999),
            'creado'=> date('Y-m-d H:i:s'),
            'activo'=> rand(0,1),
        ));
        return $view;
    }
    
    public function updateAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $tableGateway->update(array(
            'nombre'=> 'Cat '.rand(111,999),
            'creado'=> date('Y-m-d H:i:s'),
            'activo'=> rand(0,1),
        ),array('id'=>  rand(3, 6)));
        return $view;
    }
    
    public function deleteAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('dbadapter');
        $tableGateway = new TableGateway('categoria', $adapter);
        $tableGateway->delete(array('id'=> 12));
        return $view;
    }
    
    
    
    public function slAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $categoria = $sl->get('TemaDb\Model\CategoriaTable');
        $producto = $sl->get('TemaDb\Model\ProductoTable');
//        $view->data = $categoria->fetchAll();
        $view->data = $producto->listarProductosCompleto();
        return $view;
    }
    
    
}
