<?php

namespace ProcessBundle\Utils;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use ModelBundle\Entity\People;
use ModelBundle\Entity\PeoplePhone;
use ModelBundle\Entity\Orders;
use ModelBundle\Entity\Item;
use ModelBundle\Entity\Shipto;

class PrepareXmlData
{

    /**
     * Receive data for forwarding
     * 
     * @param $data
     * @return array
     */
    public function process($data) {        
        if(!empty($data)) {
            $xml = simplexml_load_file($data->getRealPath(), 'SimpleXMLIterator');

            if(!empty($xml->shiporder)) {
                $data = $this->processOrder($xml);
            } else {
                $data = $this->processPeople($xml);            
            }
        }

        return $data;
    }

    /**
     * Receive xml to prepare objects
     * 
     * @param $data
     * @return array
     */
    public function processPeople($data) {
        $peoplesArr = $phonesArr = array();
                
        foreach ($data as $key => $people) {
            $peopleObj = new People();
            $peopleObj->setId($people->personid);
            $peopleObj->setName($people->personname);
            $peoplesArr[] = $peopleObj;
            
            // Phones
            foreach ($people->phones as $key_ => $phone) { 
                $phonesObj = new PeoplePhone();
                $phonesObj->setPhone($phone->phone);
                $phonesObj->setPeopleId($people->personid);                
                $phonesArr[] = $phonesObj;
            }
        }

        return array('people' => $peoplesArr, 'phones' => $phonesArr);
    }

    /**
     * Receive xml to prepare objects
     * @param $data
     * @return array
     */
    public function processOrder($data) {
        $ordersArr = $shiptoArr = $itensArr = array();
        
        foreach ($data as $key => $order) {
            $orderObj = new Orders();
            $orderObj->setId($order->orderid);
            $orderObj->setPeopleId($order->orderperson);
            $ordersArr[] = $orderObj;
            
            // Shipto
            foreach ($order->shipto as $key_ => $shipto) { 
                $shiptoObj = new Shipto();
                $shiptoObj->setName($shipto->name);
                $shiptoObj->setAddress($shipto->address);
                $shiptoObj->setCity($shipto->city);
                $shiptoObj->setCountry($shipto->country);
                $shiptoObj->setOrderId($order->orderid);                
                $shiptoArr[] = $shiptoObj;
            }

            // Item
            foreach ($order->items->item as $key__ => $item) { 
                $itemObj = new Item();
                $itemObj->setTitle($item->title);
                $itemObj->setNote($item->note);
                $itemObj->setQuantity($item->quantity);
                $itemObj->setPrice($item->price);
                $itemObj->setOrderId($order->orderid);                
                $itensArr[] = $itemObj;
            }
        }

        return array('orders' => $ordersArr, 'shipto' => $shiptoArr, 'itens' => $itensArr);
    }

}


?>