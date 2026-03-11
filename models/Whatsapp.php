<?php
/*TODO: llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../Models/Ticket.php");

class Whastapp extends Conectar{

    protected $account_sid = 'AC2f57c617c0fb91278f501093d6473357';
    protected $auth_token = '414dcaa1f266346f83bf7ab79e4e189e';

    /* TODO: Enviar alerta por Whastapp de ticket Abierto */
    public function w_ticket_abierto($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["cats_nom"];
            $telefono = $row["usu_telf"];
        }

        //TODO: Número de teléfono de destino (con el prefijo internacional)
        $to = 'whatsapp:'.$telefono.'';

        //TODO: Número de teléfono remitente (con el prefijo internacional)
        $from = 'whatsapp:+14155238886';

        $message = 'Estimado se ha recepcionado su ticket con nro: '.$id.' y '.$titulo.' de la categoria: '.$categoria.' y subcategoria: '.$subcategoria.'.';

        //TODO: URL de la API de Twilio para enviar mensajes de WhatsApp
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' .  $this->account_sid . '/Messages.json';

        //TODO: Datos para enviar el mensaje
        $data = array(
            'To' => $to,
            'From' => $from,
            'Body' => $message
        );

        //TODO: Configurar la solicitud HTTP
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->account_sid . ':' . $this->auth_token);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //TODO: Realizar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

        //TODO: Procesar la respuesta
        if ($response) {
            return 'Mensaje enviado con éxito.';
        } else {
            return 'Error al enviar el mensaje: ' . curl_error($ch);
        }
    }

    /* TODO: Enviar alerta por Whastapp de ticket Cerrado */
    public function w_ticket_cerrado($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["cats_nom"];
            $telefono = $row["usu_telf"];
        }

        //TODO: Número de teléfono de destino (con el prefijo internacional)
        $to = 'whatsapp:'.$telefono.'';

        //TODO: Número de teléfono remitente (con el prefijo internacional)
        $from = 'whatsapp:+14155238886';

        $message = 'Estimado su ticket con nro: '.$id.' y '.$titulo.' de la categoria: '.$categoria.' y subcategoria: '.$subcategoria.'. Ha sido Cerrado por favor validar.';

        //TODO: URL de la API de Twilio para enviar mensajes de WhatsApp
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' .  $this->account_sid . '/Messages.json';

        //TODO: Datos para enviar el mensaje
        $data = array(
            'To' => $to,
            'From' => $from,
            'Body' => $message
        );

        //TODO: Configurar la solicitud HTTP
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->account_sid . ':' . $this->auth_token);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //TODO: Realizar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

        //TODO: Procesar la respuesta
        if ($response) {
            return 'Mensaje enviado con éxito.';
        } else {
            return 'Error al enviar el mensaje: ' . curl_error($ch);
        }

    }

    /* TODO: Enviar alerta por Whastapp de ticket Asignado */
    public function w_ticket_asignado_usuario($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["cats_nom"];
            $telefono = $row["usu_telf"];
        }

        //TODO: Número de teléfono de destino (con el prefijo internacional)
        $to = 'whatsapp:'.$telefono.'';

        //TODO: Número de teléfono remitente (con el prefijo internacional)
        $from = 'whatsapp:+14155238886';

        $message = '(Usuario)Estimado su ticket con nro: '.$id.' y '.$titulo.' de la categoria: '.$categoria.' y subcategoria: '.$subcategoria.'. Ha sido asignado para su soporte y asistencia.';

        //TODO: URL de la API de Twilio para enviar mensajes de WhatsApp
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' .  $this->account_sid . '/Messages.json';

        //TODO: Datos para enviar el mensaje
        $data = array(
            'To' => $to,
            'From' => $from,
            'Body' => $message
        );

        //TODO: Configurar la solicitud HTTP
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->account_sid . ':' . $this->auth_token);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //TODO: Realizar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

        //TODO: Procesar la respuesta
        if ($response) {
            return 'Mensaje enviado con éxito.';
        } else {
            return 'Error al enviar el mensaje: ' . curl_error($ch);
        }

    }

    public function w_ticket_asignado_soporte($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["cats_nom"];
        }

        $usuario = new Usuario();
        $datos2 = $usuario->get_usuario_x_id($datos[0]["usu_asig"]);

        //TODO: Número de teléfono de destino (con el prefijo internacional)
        $to = 'whatsapp:'.$datos2[0]["usu_telf"].'';

        //TODO: Número de teléfono remitente (con el prefijo internacional)
        $from = 'whatsapp:+14155238886';

        $message = '(Soporte)Estimado su ticket con nro: '.$id.' y '.$titulo.' de la categoria: '.$categoria.' y subcategoria: '.$subcategoria.'. Ha sido asignado para su soporte y asistencia.';

        //TODO: URL de la API de Twilio para enviar mensajes de WhatsApp
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' .  $this->account_sid . '/Messages.json';

        //TODO: Datos para enviar el mensaje
        $data = array(
            'To' => $to,
            'From' => $from,
            'Body' => $message
        );

        //TODO: Configurar la solicitud HTTP
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->account_sid . ':' . $this->auth_token);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //TODO: Realizar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

        //TODO: Procesar la respuesta
        if ($response) {
            return 'Mensaje enviado con éxito.';
        } else {
            return 'Error al enviar el mensaje: ' . curl_error($ch);
        }

    }
}

?>