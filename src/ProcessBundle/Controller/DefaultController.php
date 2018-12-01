<?php

namespace ProcessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);

        return $this->render('ProcessBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/processar", name="processar")
     */
    public function processAction(Request $request)
    {
        $message = array('error' => 'Erro ao importar arquivo');

        if ($request->isMethod('POST')) {      
            $file = $request->files->get('files');    
            if(!empty($file)) {
                $message = array('success' => 'true');
                $data = array();

                foreach ($file as $key => $value) {                    
                    if($value->getClientOriginalExtension() != 'xml') {
                        $message = array('error' => 'Formato do arquivo inválido ('.$value->getClientOriginalExtension().')');  
                        $data = array();
                        break;      
                    } else {
                        $data[] = $this->get('app.preparexmldata')->process($value);
                    }

                }   
                
                if(!empty($data)){
                    foreach ($data as $key => $value) {
                        $this->persistData($value);                                        
                    }
                }

            } else {
                $message = array('error' => 'Selecione no mínimo 1 arquivo');
            }        
        } else {
            return $this->forward('ProcessBundle:Default:index');
        }

        return $this->render('ProcessBundle:Default:proccess.html.twig', array('message' => utf8_encode(json_encode($message))));
    } 
    
    /**
     * Save data
     * 
     * @param $data
     * @return boolean
     */
    private function persistData($data) {
        if(!empty($data)) {
            foreach($data as $key => $value) {
                $em = $this->getDoctrine()->getManager();  
                foreach ($value as $key_ => $value_) {
                    $em->persist($value_);
                    $em->flush();
                }
            }

            return true;
        }

        return false;
    }

}
