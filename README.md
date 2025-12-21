# TecnoMarket

Esta es una aplicación full-stack web-móvil que permite administrar los productos de una tienda ficticia llamada 
TecnoMarket. Incluye autenticación de usuarios, gestión de productos y 
categorías, y catálogos de productos. 

## Herramientas y Tecnologías Usadas
- **Android Studio** – Entorno de desarrollo
- **Kotlin** – Lenguaje de programación principal
- **phpMyAdmin** – Gestión de base de datos local
- **XML** – Diseño de la interfaz de usuario
- **Bootstrap** – Framework para interfaces responsivas y modernas

## Arquitectura de la Aplicación
La aplicación sigue el patrón de diseño **MVC (Modelo–Vista–Controlador)**:

- **Modelo**:  
  Clases que representan los datos del sistema (`Producto`, `Categoría`, `Usuario`).

- **Vista**:  
  Actividades y fragmentos encargados de mostrar la interfaz de usuario.

- **Controlador**:  
  Manejo de la lógica de negocio, navegación entre pantallas y validaciones.

## Roles y Seguridad
La aplicación cuenta con un sistema de autenticación y control de acceso basado en roles:

### Administrador
- Ver productos y categorías  
- Agregar nuevos productos y categorías  
- Editar productos y categorías  
- Eliminar productos y categorías  

### Empleado
- Visualizar productos  
- Visualizar categorías  

La autenticación se realiza mediante **correo institucional y contraseña**, y el acceso a las funcionalidades se controla mediante lógica condicional según el rol del usuario.

## Funciones Principales
- Inicio de sesión con autenticación
- Gestión de productos
- Gestión de categorías
- Catálogo de productos
- Control de acceso por roles
