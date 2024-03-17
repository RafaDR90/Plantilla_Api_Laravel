DETALLES A TENER EN CUENTA

- Si da error el login
    php artisan passport:client --personal

- Video padre
    https://www.youtube.com/watch?v=Uz56BOekpLA&ab_channel=OnlineWebTutor

Pasos a seguir para añadir roles, creamos tabla roles y tabla role_user con id_user y id_role, entonces creamos un
middleware que comprobara si el usuario es un determinado rol, y usamos el middleware en las rutas en api.php
