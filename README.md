🌐 API-Tecnicos: Backend de Gestión de Gastos

API-Tecnicos actúa como el backend central del sistema de gestión de gastos, funcionando como puente de datos entre la aplicación móvil Proyecto-movil y la plataforma web de administración TecnicosTabla.

Su función principal es gestionar la autenticación de técnicos, el registro de gastos y el almacenamiento seguro de la información y evidencias asociadas.

✨ Funcionalidad Principal

La API-Tecnicos proporciona los endpoints necesarios para:

Autenticar y obtener el listado de técnicos.

Registrar nuevos gastos de técnicos.

Consultar todos los registros de gastos.

Eliminar registros de gastos específicos.

Gestionar la subida y organización de imágenes en Cloudinary.

☁️ Gestión de Imágenes en Cloudinary

Todas las imágenes enviadas desde Proyecto-movil (comida y ticket/factura) se almacenan automáticamente en Cloudinary, dentro de una carpeta específica:

<p aligh="center"><img width="1440" height="785" alt="image" src="https://github.com/user-attachments/assets/bb1e15c9-a837-42c3-a00d-edc0830336cf" /></p>



Esta estructura permite:

Mantener las imágenes organizadas por tipo de proyecto.

Facilitar la administración y auditoría de los gastos.

Garantizar un acceso centralizado y seguro a las evidencias visuales.

Las rutas de las imágenes almacenadas se guardan en la base de datos y se devuelven a través de los endpoints de consulta de gastos.

🛠️ Estructura de Datos y Endpoints

La API interactúa con la base de datos a través de dos tablas principales:

tecnicos

gastos_tecnicos

1️⃣ Gestión de Técnicos (Tabla tecnicos)

Este endpoint se utiliza principalmente para la autenticación y validación de usuarios en Proyecto-movil.

Endpoint de Consulta

GET /api/tecnicos

Descripción:
Devuelve el listado completo de técnicos registrados en el sistema.

<p align="center"> <img width="1423" height="884" alt="Listado de técnicos" src="https://github.com/user-attachments/assets/c60a75e9-da67-48ad-8ce5-d8a855a56694" /> </p>
2️⃣ Gestión de Gastos (Tabla gastos_tecnicos)

Esta es la funcionalidad central de la API y se encarga del registro, consulta y eliminación de los gastos realizados por los técnicos.

📄 Consulta de Gastos

GET /api/gastos

Descripción:
Retorna todos los registros de gastos, incluyendo:

Código del técnico

Importe

Fecha

Rutas de las imágenes almacenadas en Cloudinary (gastos_tecnicos/)

<p align="center"> <img width="1407" height="920" alt="Consulta de gastos" src="https://github.com/user-attachments/assets/22673bd1-1426-4788-b7b2-8a6262393472" /> </p>
🗑️ Eliminación de Gastos

DELETE /api/gastos/{id}

Descripción:
Permite eliminar un registro de gasto específico utilizando su identificador (id).
Esta funcionalidad es clave para la administración de datos desde TecnicosTabla.

<p align="center"> <img width="1398" height="646" alt="Eliminación de gasto" src="https://github.com/user-attachments/assets/211d1303-5ac5-4432-8244-288ebfdd54f3" /> </p>
➕ Registro de Gastos

POST /api/gastos

Descripción:
Endpoint utilizado por Proyecto-movil para crear nuevos registros de gastos.
Incluye:

Recepción de datos del gasto.

Subida de imágenes (comida y ticket).

Almacenamiento automático de las imágenes en la carpeta gastos_tecnicos de Cloudinary.

Persistencia de las rutas de las imágenes en la base de datos.
