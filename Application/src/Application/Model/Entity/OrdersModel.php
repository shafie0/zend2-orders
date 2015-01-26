<?php
namespace Application\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class OrdersModel extends TableGateway{
    private $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null){

		$this->dbAdapter=$adapter;

        return parent::__construct('orders', $this->dbAdapter, $databaseSchema,$selectResultPrototype);
    }
    
	//Generate CRUD methods
	
    public function getOrders(){
		$select=$this->select();
		$datos=$select->toArray();
        
		return $datos;

    }
    
    public function getOneOrder($id){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array('id','customerId','productId','deliveryId', 'productQuantity','productPrice'))
               ->from('orders')
               ->where(array('id' => $id));

        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result=$execute->toArray();        
        return $result[0];
        }
        
     public function addOrder($customerId,$productId,$deliveryId,$productQuantity,$productPrice){
         $insert=$this->insert(array(
                        "customerId" => $customerId,
                        "productId" => $productId,
                        "deliveryId" => $deliveryId,
                        "productQuantity" => $productQuantity,
                        "productPrice" => $productPrice
                   ));
         return $insert;
     }
     
     public function deleteOrder($id){
         $delete=$this->delete(array("id"=>$id));
         return $delete;
     }
     
     public function updateOrder($id,$customerId,$productId,$deliveryId,$productQuantity,$productPrice){
         $update=$this->update(array(
                                "customerId" => $customerId,
                                "productId" => $productId,
                                "deliveryId" => $deliveryId,
                                "productQuantity" => $productQuantity,
                                "productPrice" => $productPrice
                                ),
                                array("id"=>$id));
         return $update;
     }
}
