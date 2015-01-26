<?php
namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;

class AddOrder extends Form
{
    public function __construct($name = null)
     {
        parent::__construct($name);
        
       $this->setInputFilter(new \Application\Form\AddOrderValidator());
        
       $this->setAttributes(array(
            'action'=>"",
            'method' => 'post'
        ));

        $this->add(array(
            'name' => 'id',
            'options' => array(
                'label' => 'Id Order: ',
            ),
            'attributes' => array(
                'type' => 'hidden',
                'class' => 'input form-control',
                'required'=>'required',
				'attribs'  => array('disabled' => 'disabled')
            )
        ));

        $this->add(array(
            'name' => 'customerId',
            'options' => array(
                'label' => 'Customer: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
        
         $this->add(array(
            'name' => 'productId',
            'options' => array(
                'label' => 'Product: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
         
          $this->add(array(
            'name' => 'deliveryId',
            'options' => array(
                'label' => 'Delivery Type: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
        
        $this->add(array(
            'name' => 'productQuantity',
            'options' => array(
                'label' => 'Quantity: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
		$this->add(array(
            'name' => 'productPrice',
            'options' => array(
                'label' => 'Price: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(     
                'type' => 'submit',
                'value' => 'Submit',
                'title' => 'Submit',
                'class' => 'btn btn-success'
            ),
        ));
        
        
     }
}
