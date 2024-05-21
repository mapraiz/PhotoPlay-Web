bbdd.php

<?php
    function connect_database()
    {
        $db = “(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.1.34)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))” ;

        if ($c=OCILogon(“system”, “your database password“, $db)) {
        
            echo “Successfully connected to Oracle.\n”;
            
            OCILogoff($c);
        
        } else {
        
            $err = OCIError();
            
            echo “Connection failed.” . $err[text];
        
        }
    }

    
   


    function get_juegos()
    {
        
        $mysqli = connect_database();
        
        $sql = "SELECT * FROM Juego";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $juegos = array();

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $imagen = "";
        $precio = -1;
        $enlace = "";
        $id_categoria = -1;
        $id_user = -1;
        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $imagen, $precio,
                                    $enlace, $id_categoria, $id_user);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        while($sentencia->fetch())
        {
            $juego = array('idJuego' => $id_juego, 'titulo' => $titulo, 'descripcion' => $descripcion,
                            'imagen' => $imagen, 'precio' => $precio, 'enlace' => $enlace,
                        'idCategoria' => $id_categoria);
            $juegos[] = $juego;
        }
        $mysqli->close();
        return $juegos;
    }
    

    function get_juegos_id($idJuego)
    {
        
        $mysqli = connect_database();
        
        $sql = "SELECT * FROM Juego WHERE id_juego = ?";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("i",$idJuego);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $juego = array();

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $imagen = "";
        $precio = -1;
        $enlace = "";
        $id_categoria = -1;
        $id_user = -1;
        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $imagen, $precio,
                                    $enlace, $id_categoria, $id_user);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        if($sentencia->fetch())
        {
            $juego = array('idJuego' => $id_juego, 'titulo' => $titulo, 'descripcion' => $descripcion,
                            'imagen' => $imagen, 'precio' => $precio, 'enlace' => $enlace,
                        'idCategoria' => $id_categoria);
        }
        $mysqli->close();
        return $juego;
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

    function get_noticias()
    {
        $mysqli = connect_database();
        
        
        $sql = "SELECT * FROM noticia ORDER BY id_noticia DESC";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $noticias = array();

        $id_noticia = -1;
        $titulo = "";
        $fecha = "";
        $texto = "";
        $imagen = "";
        $resumen = "";
        $id_autor = -1;
        $vincular = $sentencia->bind_result($id_noticia, $titulo, $fecha, $texto, $imagen,
                                    $resumen, $id_autor);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        while($sentencia->fetch())
        {
            $noticia = array('id_noticia' => $id_noticia, 'titulo' => $titulo, 'fecha' => $fecha,
                            'texto' => $texto, 'imagen' => $imagen, 'resumen' => $resumen,
                        'id_autor' => $id_autor);
            $noticias[] = $noticia;
        }
        
        
        $mysqli->close();
        return $noticias;
    }

    function get_noticia($id_noticia)
    {
         $mysqli = connect_database();
        
        
        $sql = "SELECT * FROM noticia WHERE id_noticia = ?";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("i", $id_noticia);
        if(!$asignar)
        {
            echo "Fallo en la asignación ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        

        $id_noticia = -1;
        $titulo = "";
        $fecha = "";
        $texto = "";
        $imagen = "";
        $resumen = "";
        $id_autor = -1;
        $vincular = $sentencia->bind_result($id_noticia, $titulo, $fecha, $texto, $imagen,
                                    $resumen, $id_autor);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        while($sentencia->fetch())
        {
            $noticia = array('id_noticia' => $id_noticia, 'titulo' => $titulo, 'fecha' => $fecha,
                            'texto' => $texto, 'imagen' => $imagen, 'resumen' => $resumen,
                        'id_autor' => $id_autor);
            
        }
        
        
        $mysqli->close();
        return $noticia;
    }


    function insert_noticia($titulo, $fecha, $texto, $imagen, $resumen, $idAutor)
    {
        
        $mysqli = connect_database();

        
        
        $sql = "INSERT INTO noticia(titulo, fecha, texto, imagen, resumen, id_autor) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
            
        }

        $asignar = $sentencia->bind_param("sssssi", $titulo, $fecha, $texto, $imagen, $resumen, $idAutor);
        if(!$asignar)
        {         
    
   
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
            
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
            
        }
        
        $mysqli->close();
        return true;
    }


    function insert_miembro($nombre, $instrumento, $fecha_nacimiento, $ciudad_origen)
    {
        
        $mysqli = connect_database();
        
        $sql = "INSERT INTO miembroGrupo(nombre, instrumento, fecha_nacimiento, ciudad_origen) 
                        VALUES (?, ?, ?, ?)";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("ssds", $nombre, $instrumento, $fecha_nacimiento, $ciudad_origen);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $mysqli->close();
        return true;
    }
    
?>