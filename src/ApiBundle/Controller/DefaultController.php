<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\Get; 
use FOS\RestBundle\Controller\Annotations\View; 
use FOS\RestBundle\Controller\FOSRestController; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; 
use Symfony\Component\HttpFoundation\Request; 
use ModelBundle\Entity\People;
use ModelBundle\Entity\PeoplePhone;
use ModelBundle\Entity\Orders;
use ModelBundle\Entity\Item;
use ModelBundle\Entity\Shipto;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{
    /**
    * Get all the data
    * @return array

    * @ApiDoc(
    *  resource=true,
    *  description=" All data",  
    * )
    *
    * @View()
    * @Get("/")
    */
    public function indexAction()
    {
        $people      = $this->getDoctrine()->getRepository("ModelBundle:People")->findAll();
        $peoplePhone = $this->getDoctrine()->getRepository("ModelBundle:PeoplePhone")->findAll();
        $orders      = $this->getDoctrine()->getRepository("ModelBundle:Orders")->findAll();            
        $item        = $this->getDoctrine()->getRepository("ModelBundle:Item")->findAll();
        $shipto      = $this->getDoctrine()->getRepository("ModelBundle:Shipto")->findAll();

        return array(
            'people'      => $people,
            'peoplePhone' => $peoplePhone,
            'orders'      => $orders,
            'item'        => $item,
            'shipto'      => $shipto
        );
    }

    /**
    * Get people the data
    * @return array
    
    * @ApiDoc(
    *  resource=true,
    *  description=" People data",  
    * )
    *
    * @View()
    * @Get("/people")
    */
    public function peopleAction()
    {
        $people      = $this->getDoctrine()->getRepository("ModelBundle:People")->findAll();
        $peoplePhone = $this->getDoctrine()->getRepository("ModelBundle:PeoplePhone")->findAll();

        return array(
            'people'      => $people,
            'peoplePhone' => $peoplePhone
        );
    }

    /**
    * Get orders the data
    * @return array
    
    * @ApiDoc(
    *  resource=true,
    *  description=" Orders data",  
    * )
    *
    * @View()
    * @Get("/orders")
    */
    public function ordersAction()
    {
        $orders      = $this->getDoctrine()->getRepository("ModelBundle:Orders")->findAll();            
        $item        = $this->getDoctrine()->getRepository("ModelBundle:Item")->findAll();
        $shipto      = $this->getDoctrine()->getRepository("ModelBundle:Shipto")->findAll();

        return array(
            'orders'      => $orders,
            'item'        => $item,
            'shipto'      => $shipto
        );
    }
}
