<?php

namespace App\Classe ;
use Mailjet\Client;
use Mailjet\Resources;

Class Mail{

    private $api_key='82072a7cc67cec2fe1354ea3b73ec1a1';
    private $api_key_secret='6d4394ea51f3e660d1ecfa3d98404bb8';
    public function send($to_email,$to_name,$subject, $content){
        $mj=new Client ($this->api_key,$this->api_key_secret,true,['version' => 'v3.1']);
      
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "waelferhi28@gmail.com",
                        'Name' => "Marque Blanche"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name,
                        ]
                    ],
                    'TemplateID' => 4787755,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                        
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;
    }
}
