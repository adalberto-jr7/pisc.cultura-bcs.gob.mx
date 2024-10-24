## Administración de reportes del instituto sudcaliforniano de cultura.

### Descripción

Este proyecto tiene como objetivo la creación de un sistema de administración de reportes para el Instituto
Sudcaliforniano de Cultura, el cual permitirá a los usuarios del instituto generar reportes de actividades, eventos y
proyectos realizados por el instituto, así como visualizar y editar los reportes generados por otros usuarios.

### Pasos para instalación

1. Clonar el repositorio en la carpeta de su servidor web.
2. Crear una base de datos en MySQL con el nombre `isc_reportes`.
3. Correr el comando `composer install` en la carpeta del proyecto.
4. Crear una copia del archivo `env.example` a `.env` en la carpeta del proyecto con la siguiente información:
    - Configurar la conexión a la base de datos:
        ```
       DB_CONNECTION=mysql
       DB_HOST=(host de la base de datos)
       DB_PORT=(puerto de la base de datos)
       DB_DATABASE=(nombre de la base de datos)
       DB_USERNAME=(usuario de la base de datos)
       DB_PASSWORD=(contraseña de la base de datos)
      ```
5. Correr el comando `php artisan key:generate` en la carpeta del proyecto.
6. Correr el comando `php artisan migrate` en la carpeta del proyecto.
7. Correr el comando `php artisan db:seed` en la carpeta del proyecto.
8. Correr el comando `npm install` en la carpeta del proyecto.
9. Correr el comando `npm run dev` en la carpeta del proyecto.
10. Correr el comando `php artisan serve` en la carpeta del proyecto.
11. Correr el comando `php artisan queue:work` en la carpeta del proyecto.

