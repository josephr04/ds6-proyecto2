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

## Pantallas

<p align="center">
  <img src="https://github.com/user-attachments/assets/ca17ea94-8d93-4cc5-bc06-e757d8a7869f" width="600" />
  <img src="https://github.com/user-attachments/assets/f20ed5cf-f9ef-4445-9e3d-e232ac99a52f" width="600" />
  <img src="https://github.com/user-attachments/assets/4b85781a-61be-4e66-90a9-668740bbb048" width="600" />
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/5790c8ce-940f-450b-b5ac-c28b11a58b46" width="300" />
  <img src="https://github.com/user-attachments/assets/6d4f446c-edd6-4d81-90e7-81eef8c4edd5" width="300" />
</p>
/>




