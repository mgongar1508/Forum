# Foro Web

🧩 Descripción General

Esta aplicación web es un foro orientado principalmente a la comunidad de videojuegos, aunque su diseño flexible permite adaptarse a otras temáticas. Los usuarios pueden crear publicaciones, interactuar mediante comentarios y participar activamente en distintas categorías dentro del sistema.

La aplicación está construida utilizando Laravel Jetstream como base para la autenticación y gestión de usuarios, junto con Livewire para crear interfaces dinámicas sin necesidad de una SPA completa. Además, se incorpora JavaScript para mejorar la experiencia de usuario en interacciones específicas.

🏗️ Stack Tecnológico

Backend: Laravel (framework principal)
Autenticación: Laravel Jetstream
Frontend: Blade + Livewire
Interactividad adicional: JavaScript
Base de datos: MySQL

Este enfoque permite un desarrollo rápido, mantenible y con buena experiencia de usuario sin depender completamente de frameworks frontend pesados.

📝 Funcionalidades Principales  
-Publicaciones (Posts):  
Los usuarios pueden crear, editar y eliminar sus publicaciones dentro del foro. Estas publicaciones pueden organizarse en distintas etiquetas, facilitando la navegación y el filtrado de contenido. hay funcionalidades adicionales como likes/dislikes.

-Comentarios:  
Cada publicación admite comentarios, permitiendo a los usuarios interactuar entre sí. Los comentarios pueden estructurarse en forma de hilos (respuestas a otros comentarios), favoreciendo discusiones organizadas. Los usuarios pueden editar o eliminar sus propios comentarios.

-Usuarios:  
El sistema permite el registro, inicio y cierre de sesión mediante Jetstream. Cada usuario dispone de un perfil básico que puede incluir nombre, avatar y una breve biografía.

🛡️ Sistema de Roles (RBAC)  
👑 Admin:  
Acceso total  
Gestión de usuarios (roles, baneos)  
Eliminación de cualquier contenido  
Configuración global  
🛠️ Moderador:  
Moderación de posts y comentarios  
Eliminación de contenido inapropiado  
Gestión de reportes  
👥 Usuario:  
Crear y gestionar su propio contenido  
Participar en el foro  

⚙️ Arquitectura

La aplicación sigue una arquitectura basada en Laravel:

Componentes Livewire: Gestionan la lógica interactiva del frontend (creación de posts, comentarios en tiempo real, etc.)
Blade Templates: Encargados del renderizado de las vistas
Controladores: Manejan la lógica de negocio y la comunicación con los modelos
Modelos (Eloquent): Representan entidades como usuarios, publicaciones, comentarios y roles
Middleware y Policies: Controlan el acceso y permisos según el rol del usuario

🔒 Seguridad

La aplicación incorpora varias medidas de seguridad:
Autenticación robusta mediante Jetstream
Autorización basada en roles usando middleware y policies
Protección contra CSRF integrada en Laravel
Validación de datos tanto en servidor como en cliente

📌 Notas Finales

El uso de Livewire permite construir una experiencia interactiva sin la complejidad de una SPA completa. JavaScript se utiliza de forma complementaria para mejorar la usabilidad en ciertos casos.

La arquitectura del sistema es modular y escalable, lo que facilita la incorporación futura de nuevas funcionalidades como notificaciones en tiempo real, mensajería privada o sistemas avanzados de reputación.
