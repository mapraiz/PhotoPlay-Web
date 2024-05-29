<?php

function connect_database()
{
    $username = 'c##photoplay';
    $password = 'almi123';
    $connection_string = '//3.221.255.12:1521/ORCLCDB';  

    $conn = oci_connect($username, $password, $connection_string);

    if (!$conn) {
        $error = oci_error();
        echo "Oracle connection error: " . $error['message'];
        exit;
    }else{
        echo "Oracle connection success";
    }

    
   
    function change_username($username, $newUsername){
        $oci = connect_database();
        
        $sql = "UPDATE usuario SET username=? WHERE username=?";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
            return false;
        }

        $asignar = $sentencia->bind_param("ss", $username, $newUsername);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$oci->errno;
            return false;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
            return false;
        }else{
            return true;
        }

        
        
    }

    function change_score($score, $newScore, $fecha, $newFecha){
        $oci = connect_database();
        
        $sql = "UPDATE partida SET puntuacion= :newPuntuacion , fecha= :newFecha WHERE puntuacion= :puntuacion, fecha= :fecha";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
            return false;
        }
        $ba = array(':newPuntuacion' => $newScore, ':newFecha' => $newFecha, ':puntuacion' => $score, ':fecha' => $fecha);

        foreach ($ba as $key => $val) {

            // oci_bind_by_name($stid, $key, $val) does not work
            // because it binds each placeholder to the same location: $val
            // instead use the actual location of the data: $ba[$key]
            $asignar=oci_bind_by_name($sentencia, $key, $ba[$key]);
            if(!$asignar)
            {
                echo "Fallo en la asignacion de parametros ".$oci->errno;
            }
        }
       

       
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
            return false;
        }else{
            return true;
        }

        
        
    }


    function get_users()
    {
        
        $oci = connect_database();
        
        $sql = "SELECT * FROM usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
       
        
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $users = array();

        $id_usuario = -1;
        $username = "";
        $contraseña = "";
        $admin = -1;
       
        $vincular = $sentencia->bind_result($id_usuario, $username, $contraseña, $admin);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $user = array('id_usuario' => $id_usuario, 'username' => $username, 'contraseña' => $contraseña,
                            'admin' => $admin);
            $users[] = $user;
        }
        $oci->close();
        return $users;
    }

    function get_current_username($id_usuario){
          
        $oci = connect_database();
        
        $sql = "SELECT username FROM usuario WHERE id_usuario= :id_usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
        
        $asignar = oci_bind_by_name($sentencia, ':id_usuario', $id_usuario, );
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$oci->errno;
        }
        
        
        $ejecucion = oci_execute($sentencia);
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        $curs = oci_new_cursor($oci);
        oci_execute($curs);
        
        

        
        $username = "";
        
       
        while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
            
            $username = $row['username']
        }
       
        $oci->close();
        return $username;
    }
    function get_scores_user($id_usuario)
    {
        
        $oci = connect_database();
        
        $sql = "SELECT * FROM partida WHERE id_usuario= :id_usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
        
        $asignar = oci_bind_by_name($sentencia, ':id_usuario', $id_usuario);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$oci->errno;
        }
        
        
        $ejecucion = oci_execute($sentencia);
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $scores = array();

        $id_partida = -1;
        $fecha = "";
        $puntuacion = "";
        $id_usuario = -1;
       
        $vincular = $sentencia->bind_result($id_partida, $fecha, $puntuacion, $id_usuario);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $score = array('id_partida' => $id_partida, 'fecha' => $fecha, 'puntuacion' => $puntuacion,
                            'id_usuario' => $id_usuario);
            $scores[] = $score;
        }
        $oci->close();
        return $scores;
    }

    function get_scores()
    {
        
        $oci = connect_database();
        
        $sql = "SELECT usuario.username, partida.puntuacion FROM partida INNER JOIN usuario ON partida.id_usuario = usuario.id_usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
       
        
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $scores = array();

        $username= "";
        
        $puntuacion = "";
        
       
        $vincular = $sentencia->bind_result($username, $puntuacion);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $score = array('username' => $username, 'puntuacion' => $puntuacion);
            $scores[] = $score;
        }
        $oci->close();
        return $scores;
    }
    

    
    
    function login($user, $password)
    {
        $mysqli = connect_database();

        $sql = "SELECT id_usuario FROM usuarios WHERE usuario = ? 
            AND contraseña = ?";
            
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("ss", $user, $password);
        if(!$asignar)
        {
            echo "Fallo en la asignación ".$mysqli->errno;
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecución ".$mysqli->errno;
        }

        $usuario = -1;
        $vincular = $sentencia->bind_result($usuario);
        if(!$vincular)
        {
            echo "Fallo al asociar parámetros ".$mysqli->errno;
        }

        $result = false;
        if($sentencia->fetch())
        {
            $result = $usuario;
        }

        $mysqli->close();
        return $result;
    }


function get_user($conn, $username, $password)
{
    $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);

    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    return $row;
}
?>
