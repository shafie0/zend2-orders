<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;
use Zend\Db\Adapter\Adapter;
use Zend\Crypt\Password\Bcrypt;
use Application\Model\Entity\OrdersModel;
use Application\Form\AddOrder;

class CrudController extends AbstractActionController{
    private $dbAdapter;
    
    public function __construct(){
    }
    
    public function indexAction(){
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $orders=new OrdersModel($this->dbAdapter);
	
        $lista=$orders->getOrders();

        return new ViewModel(
                array(
                    "lista"=>$lista
                ));
    }
    
    public function addAction(){
        $form=new AddOrder("form");
        $vista=array("form"=>$form);
        if($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()){
                //load model
                $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
                $orders=new OrdersModel($this->dbAdapter);
                
                //Recover data from form
                $customerId=$this->request->getPost("customerId");
                $productId=$this->request->getPost("productId");
                $deliveryId=$this->request->getPost("deliveryId");
                $productQuantity=$this->request->getPost("productQuantity");
                $productPrice=$this->request->getPost("productPrice");
                $id=$this->request->getPost("id");
                
                //Insert into DB
                $insert=$orders->addOrder($customerId, $productId, $deliveryId, $productQuantity,$productPrice);
                
				//Message flash $this->flashMessenger()->addMenssage("mensaje");
				if($insert==true){
                    $this->flashMessenger()->setNamespace("add_success")->addMessage("Order added successfull!!");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/crud');
                }else{
                    $this->flashMessenger()->setNamespace("duplicate")->addMessage("Duplicate order!");
                    return $this->redirect()->refresh();
                }
            }else{
                $err=$form->getMessages();
                $vista=array("form"=>$form,'url'=>$this->getRequest()->getBaseUrl(),"error"=>$err);
            }
        }
        return new ViewModel($vista); 
    }
    
    public function viewAction(){
         $id=$this->params()->fromRoute("id",null);
         $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
         $orders=new OrdersModel($this->dbAdapter);
         
         $order=$orders->getOneOrder($id);
         if($order){
             return new ViewModel(
                 array(
                    "id"      => $id,
                    "order" => $order
                )); 
         }else{
             return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/crud');
         } 
    }
    
    public function editAction(){

        $id=$this->params()->fromRoute("id",null);
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

        $orders=new OrdersModel($this->dbAdapter);         
        $order=$orders->getOneOrder($id);

        $form=new AddOrder("form");
        $form->setData($order);
        $vista=array("form"=>$form);
        if($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()){
                //Recover data from form
                $customerId=$this->request->getPost("customerId");
                $productId=$this->request->getPost("productId");
                $deliveryId=$this->request->getPost("deliveryId");
                $productQuantity=$this->request->getPost("productQuantity");
                $productPrice=$this->request->getPost("productPrice");
                $id=$this->request->getPost("id");
                //Update into DB
                $update=$orders->updateOrder($id,$customerId, $productId, $deliveryId, $productQuantity,$productPrice);
                if($update==true){
                    $this->flashMessenger()->setNamespace("add_success")->addMessage("Order edited successfully!");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/crud');
                }else{
                    $this->flashMessenger()->setNamespace("duplicated")->addMessage("Duplicate order!");
                    return $this->redirect()->refresh();
                }
            }else{
                $err=$form->getMessages();
                $vista=array("form"=>$form,'url'=>$this->getRequest()->getBaseUrl(),"error"=>$err);
            }
        }
         return new ViewModel($vista); 
    }
    
    public function deleteAction(){
        $id=$this->params()->fromRoute("id",null);
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $orders=new OrdersModel($this->dbAdapter);
        $delete=$orders->deleteOrder($id);
        if($delete==true){
            $this->flashMessenger()->setNamespace("deleted")->addMessage("Order deleted successfully!");
        }else{
            $this->flashMessenger()->setNamespace("deleted")->addMessage("Order can't be deleted!");
        }   
       return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/crud');
    }
    
}
