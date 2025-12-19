# Especificación de Casos de Uso — Sistema de Gestión de Empleados

Este documento contiene la especificación de casos de uso para un sistema de Gestión de Empleados. Cada caso de uso está descrito en formato de conversación (diálogo) entre el Usuario y el Sistema e incluye los flujos alternativos relevantes.

## Alcance
Gestionar la información de empleados de una organización: crear, listar, ver detalle, editar, eliminar, buscar y generar reportes.

## Actores
- Administrador (usuario con permisos para crear/editar/eliminar)
- Usuario autenticado (puede listar y ver detalles; según permisos puede buscar)
- Sistema (aplica validaciones, persistencia y reglas de negocio)

---

### Caso de Uso UC1 — Autenticarse
- Actor primario: Administrador / Usuario
- Precondición: El usuario tiene una cuenta registrada.
- Postcondición: El usuario queda autenticado y puede realizar acciones según su rol.
- Disparador: Un usuario intenta ingresar al sistema.

Flujo principal (conversación):
1. Usuario: "Quiero iniciar sesión con mi nombre de usuario y contraseña."
2. Sistema: "Por favor, ingrese su nombre de usuario y contraseña." (muestra formulario)
3. Usuario: "Aquí están mis credenciales." (envía credenciales)
4. Sistema: "Verificando credenciales..." (valida contra la base de datos)
5. Sistema: "Inicio de sesión exitoso. Bienvenido/a, [Nombre]." (redirige al panel correspondiente)

Casos alternativos:
- A1: Credenciales inválidas
  - Usuario: "Aquí mis credenciales." (envía credenciales incorrectas)
  - Sistema: "Credenciales inválidas. ¿Desea reintentar?" (muestra mensaje de error)
  - Usuario: "Sí." / "No." (si reintenta vuelve al paso 2; si no, cancela)
- A2: Cuenta bloqueada
  - Sistema: "La cuenta está bloqueada. Contacte al administrador." (muestra instrucciones)

---

### Caso de Uso UC2 — Crear Empleado
- Actor primario: Administrador
- Precondición: Administrador autenticado.
- Postcondición: Se crea un nuevo registro de empleado en el sistema.
- Disparador: Administrador solicita crear un empleado nuevo.

Flujo principal (conversación):
1. Administrador: "Quiero crear un nuevo empleado." (inicia formulario)
2. Sistema: "Por favor, complete los datos: nombre, apellido, fecha de nacimiento, correo, cargo, departamento, fecha de ingreso, salario." (muestra formulario)
3. Administrador: "Ingreso los datos y envío el formulario." (envía datos)
4. Sistema: "Validando datos..." (valida campos obligatorios y formato)
5. Sistema: "Empleado creado con éxito. ID: 12345." (muestra confirmación y detalles)

Casos alternativos:
- A1: Datos incompletos o formato inválido
  - Sistema: "El campo [X] es obligatorio / formato inválido." (muestra errores)
  - Administrador: "Corrijo los datos." (corrige y reenvía; vuelve al paso 4)
- A2: Correo ya registrado
  - Sistema: "Ya existe un empleado con este correo. ¿Desea vincular o usar otro correo?" (muestra opciones)
  - Administrador: elige acción (usar otro correo o cancelar)
- A3: Error de persistencia (DB)
  - Sistema: "Ocurrió un error al guardar. Intente de nuevo o contacte soporte." (muestra mensaje)

---

### Caso de Uso UC3 — Listar Empleados
- Actor primario: Usuario autenticado / Administrador
- Precondición: Usuario autenticado.
- Postcondición: Se muestran los empleados según filtros y paginación.
- Disparador: Usuario solicita ver la lista de empleados.

Flujo principal (conversación):
1. Usuario: "Muéstrame la lista de empleados." (accede a la vista listar)
2. Sistema: "Obteniendo empleados..." (consulta y aplica paginación)
3. Sistema: "Aquí está la lista (página 1 de N)." (muestra tabla con nombre, cargo, departamento y acciones)
4. Usuario: "Quiero ir a la página 2 / cambiar el tamaño de página / aplicar filtros." (interactúa con controles)
5. Sistema: "Actualizando vista con los criterios seleccionados." (refresca lista)

Casos alternativos:
- A1: No hay empleados registrados
  - Sistema: "No hay empleados que mostrar." (ofrece opción de crear uno nuevo)
- A2: Filtros inválidos
  - Sistema: "El filtro [X] no es válido. Se aplicaron los filtros válidos." (muestra aviso)

---

### Caso de Uso UC4 — Ver Detalle de Empleado
- Actor primario: Usuario autenticado / Administrador
- Precondición: Usuario autenticado.
- Postcondición: Se muestra la ficha detallada del empleado.
- Disparador: Usuario solicita ver el detalle de un empleado desde la lista.

Flujo principal (conversación):
1. Usuario: "Abrir detalle del empleado [ID]." (clic en "Ver")
2. Sistema: "Cargando detalle del empleado..." (consulta datos completos)
3. Sistema: "Aquí está la ficha de [Nombre Apellido]: cargo, departamento, contacto, historial, observaciones." (muestra interfaz)
4. Usuario: "Quiero ver historial de cargos / documentos adjuntos." (navega dentro de la ficha)
5. Sistema: "Mostrando historial / documentos." (muestra datos relacionados)

Casos alternativos:
- A1: Empleado no encontrado (id inválido o eliminado)
  - Sistema: "El empleado solicitado no existe o fue eliminado." (muestra mensaje)
- A2: No tiene permisos para ver ciertos campos
  - Sistema: "No tiene permisos para ver [campo]." (oculta o enmascara la información)

---

### Caso de Uso UC5 — Editar Empleado
- Actor primario: Administrador
- Precondición: Administrador autenticado; empleado existente.
- Postcondición: Datos actualizados del empleado.
- Disparador: Administrador solicita editar los datos de un empleado.

Flujo principal (conversación):
1. Administrador: "Quiero editar al empleado [ID]." (clic en "Editar")
2. Sistema: "Cargando formulario con los datos actuales..." (muestra formulario con valores)
3. Administrador: "Modifico los campos necesarios y envío." (envía formulario)
4. Sistema: "Validando cambios..." (valida reglas: formato, obligatoriedad, y restricciones de negocio)
5. Sistema: "Datos actualizados correctamente." (muestra confirmación y nueva ficha)

Casos alternativos:
- A1: Conflicto de edición (otro usuario modificó registro)
  - Sistema: "El registro fue modificado por otro usuario. ¿Desea sobrescribir o ver los cambios?" (muestra diferencias)
  - Administrador: elige acción (sobrescribir / revisar)
- A2: Campos inválidos
  - Sistema: "El campo [X] no es válido." (muestra errores)
  - Administrador: “Corrijo y reenvío.” (vuelve al paso 4)
- A3: Intento de cambiar campos no permitidos
  - Sistema: "No puede modificar [campo] debido a restricciones de negocio." (bloquea la edición de esos campos)

---

### Caso de Uso UC6 — Eliminar Empleado
- Actor primario: Administrador
- Precondición: Administrador autenticado; empleado existente.
- Postcondición: Registro eliminado o marcado como inactivo según política.
- Disparador: Administrador solicita eliminar un empleado.

Flujo principal (conversación):
1. Administrador: "Eliminar al empleado [ID]." (clic en "Eliminar")
2. Sistema: "¿Está seguro que desea eliminar a [Nombre Apellido]? Esta acción puede ser irreversible." (pide confirmación)
3. Administrador: "Sí, confirmar eliminación." (confirma)
4. Sistema: "Eliminando registro..." (aplica política: eliminar físicamente o marcar como inactivo)
5. Sistema: "Empleado eliminado / marcado como inactivo." (muestra confirmación)

Casos alternativos:
- A1: Cancelación por parte del administrador
  - Administrador: "Cancelar." (cancela operación)
  - Sistema: "Operación cancelada." (no realiza cambios)
- A2: Restricción por relaciones (empleado vinculado a procesos)
  - Sistema: "No se puede eliminar porque el empleado está vinculado a [póliza/registro/proceso]. ¿Desea inactivar en su lugar?" (muestra opciones)
  - Administrador: elige acción (inactivar / cancelar)

---

### Caso de Uso UC7 — Buscar Empleados
- Actor primario: Usuario autenticado / Administrador
- Precondición: Usuario autenticado.
- Postcondición: Se muestran los resultados que coinciden con los criterios de búsqueda.
- Disparador: Usuario realiza una búsqueda por nombre, departamento, cargo, correo u otros criterios.

Flujo principal (conversación):
1. Usuario: "Buscar empleados por nombre: 'María' y departamento: 'Contabilidad'." (ingresa criterios)
2. Sistema: "Buscando empleados que coincidan..." (ejecuta consulta con filtros y paginación)
3. Sistema: "Se encontraron X resultados." (muestra lista filtrada)
4. Usuario: "Abrir detalle / editar / exportar resultados." (selecciona acción sobre resultados)
5. Sistema: "Ejecutando acción seleccionada." (muestra resultado de la acción)

Casos alternativos:
- A1: Búsqueda sin resultados
  - Sistema: "No se encontraron empleados que coincidan con los criterios." (ofrece opciones para ampliar búsqueda)
- A2: Criterios inválidos o demasiado amplios
  - Sistema: "El criterio [X] no es válido o la búsqueda devolvería demasiados resultados. Refine su búsqueda." (sugiere filtros)

---

### Caso de Uso UC8 — Generar Reporte de Empleados
- Actor primario: Administrador
- Precondición: Administrador autenticado.
- Postcondición: Se genera y descarga (o envía) un reporte con los datos solicitados.
- Disparador: Administrador solicita generar un reporte (por ejemplo: nómina, edad, antigüedad, por departamento).

Flujo principal (conversación):
1. Administrador: "Generar reporte de empleados por departamento: Recursos Humanos, formato: PDF." (configura parámetros)
2. Sistema: "Generando reporte..." (compone, aplica filtros y formato)
3. Sistema: "Reporte listo. ¿Descargar o enviar por correo?" (muestra opciones)
4. Administrador: "Descargar." (elige descarga)
5. Sistema: "Iniciando descarga: empleados_reporte_RRHH_2025-12-17.pdf" (ofrece enlace)

Casos alternativos:
- A1: Volumen grande / operación en background
  - Sistema: "El reporte será preparado en segundo plano; le notificaremos cuando esté listo." (ofrece opción de recibir correo)
- A2: Parámetros inválidos
  - Sistema: "El parámetro [X] no es válido." (muestra error)
- A3: Error al exportar
  - Sistema: "Ocurrió un error al generar el reporte. Intente de nuevo o contacte soporte." (muestra mensaje)

---

## Recomendaciones y notas finales
- Validar permisos a nivel de actor en cada caso de uso — algunos actores solo deben ver datos y no modificarlos.
- Implementar auditoría para las acciones de creación, edición y eliminación (quién, cuándo, qué cambió).
- Definir política de eliminación (borrado físico vs. marcado como inactivo) y reflejarla en UC6.
- Considerar flujos de confirmación y notificaciones (correo/in-app) para eventos críticos.

---

Archivo generado: `README.md` — contiene la especificación de casos de uso en formato de conversación y los casos alternativos.
