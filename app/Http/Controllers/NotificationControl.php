<?php
class NotificationControl {
    
    function __construct(){

        define( 'API_ACCESS_KEY', 'AAAAmsazadk:APA91bGJWNJeVIzrzKTbcXUMHzNT3bT5KyVq8Q_aO0_Cb97N59cjkPE9N3wPOvwJI_uD63AhcWJz1ScyVkBz12TKDUDzpUqSEohZU5Xsw6Ag6rIg_3xkcVwAEttZcNh9J9WNPwNZF0xO' );
    }

    public static function notif($title, $message, $token, $type, $orderId){
            
        $msg = array
        (
            "message" 	=> $message,
            "title"		=> $title
        );

        $fields = array
        (
            'registration_ids' 	=> $token,
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );

        return response()->json( $result );
    }

    public static function notifId($title, $message, $token,$type, $orderId, $tellId){

        $msg = array
        (
            "message" 	=> $message,
            "title"		=> $title
        );

        $fields = array
        (
            'registration_ids' 	=> $token,
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );

        return response()->json( $result );
    }
}