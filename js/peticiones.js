function insertarUsuario() {
    var username = document.getElementById('username').value;
    var contrasena = document.getElementById('contrasena').value;
    var admin = document.getElementById('admin').value;

    $.ajax({
        type: 'POST',
        url: 'ajax_requests.php',
        data: {
            action: 'insert_user',
            username: username,
            contrasena: contrasena,
            admin: admin
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function() {
            alert('Error al realizar la petición AJAX');
        }
    });
}

function obtenerEstadisticasUsuarios() {
    $.ajax({
        type: 'GET',
        url: 'ajax_requests.php',
        data: {
            action: 'get_user_stats'
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                console.log(data.stats); // Aquí puedes manejar las estadísticas recibidas
            } else {
                alert('Error: No se pudieron obtener las estadísticas');
            }
        },
        error: function() {
            alert('Error al realizar la petición AJAX');
        }
    });
}
