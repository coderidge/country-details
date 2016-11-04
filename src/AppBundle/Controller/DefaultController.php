<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        
        $client = new Client();
        
        $results = $client->get('https://restcountries.eu/rest/v1/all');
        
        $frombody = json_decode($results->getBody(),true);
              
       
        foreach($frombody as $body) { 
            // enter return id
                     
        
        $sql="INSERT INTO country_details (country_name,domain_tld,lat,lng,ISO2,ISO3) values(?,?,?,?,?,?)";
    
        $em = $this->getDoctrine()->getManager();
    
        $connection = $em->getConnection();
    
        $statement = $connection->prepare($sql);
    
        $statement->bindParam(1,$body['name']);
        $statement->bindParam(2,$body['topLevelDomain'][0]);
        
        $statement->bindParam(3,$body['latlng'][0]);
        
        $statement->bindParam(4,$body['latlng'][1]);
       
        $statement->bindParam(5,$body['alpha2Code']);
        $statement->bindParam(6,$body['alpha3Code']);
    
        $statement->execute();
                   
        $lastid =  $em->getConnection()->lastInsertId();
                  
            // translations
       
        $em2 = $this->getDoctrine()->getManager();
    
        $connection2 = $em2->getConnection();
           
        $data = array();

                foreach($body['translations'] as $trans) {

                $data[] = "(" . addslashes($lastid) . "," .  "'$trans'"  . ")";    }

                $thedata = implode(",",$data) ;
                
                $sql2 = "INSERT INTO samknows.translations (country_id,translation) values $thedata"; 

                $statement2 = $connection2->prepare($sql2);           

                $statement2->execute();
          
        
                        // borders 
                        foreach($body['borders'] as $bord) { 
                             
                        $data2[] = "(" . addslashes($lastid) . "," .  "'$bord'"  . ")";    }

                        $borderdata = implode(",",$data2) ;

                        $sql3 = "INSERT INTO border_countries (country_id,border_country) values $borderdata";    

                        $statement3 = $connection2->prepare($sql3);           

                        $statement3->execute();   

            
                                
                                foreach($body['languages'] as $lang) { 
                                

                                $data3[] =  "(" . addslashes($lastid) . "," .  "'$lang'"  . ")";    }

                                $langdata = implode(",",$data3);

                                $sql4 = "INSERT INTO languages (country_id,language) values $langdata";    

                                $statement4 = $connection2->prepare($sql4);           

                                $statement4->execute();      
                
           
            
        }
        
       
    }
    
    
    /**
     * @Route("/api",name="api")
     */
    public function api(Request $request) { 
        
        // need to work out a way of connecting tables then displaying sub trees for languages, translations etc 
        $sql = ("select * from country_details");
        
        $em = $this->getDoctrine()->getManager();
    
        $connection = $em->getConnection();
    
        $statement = $connection->prepare($sql);
    
        $statement->execute();
        
        $countries = $statement->fetchAll();
        
        $injson = json_encode($countries);
      
        return  $injson;
        
    }
    
    
}
