# Importación Masiva de Participantes de Eventos

Esta documentación explica cómo configurar y utilizar el sistema de importación masiva de participantes para eventos en la plataforma EvetCheck.

## Descripción General

El importador masivo permite cargar múltiples participantes a un evento utilizando archivos en formato **CSV**, **TXT** o **JSON**. El sistema automáticamente:
- Crea usuarios y personas si no existen en la base de datos
- Registra la asistencia al evento
- Inscribe automáticamente a actividades de "Refrigerio"
- Valida la información antes de guardarla
- Proporciona un reporte detallado de registros procesados y errores

## Formatos de Archivo Soportados

### 1. Archivo CSV/TXT
- **Formato**: Archivo de texto separado por comas
- **Codificación**: UTF-8 recomendada
- **Primera fila**: Debe contener los nombres de las columnas (encabezados)
- **Separador**: Coma (,)

### 2. Archivo JSON
- **Formato**: Array de objetos JSON
- **Codificación**: UTF-8
- **Estructura**: Cada objeto representa un participante

## Estructura de Datos Requerida

### Campos Obligatorios

| Campo | Tipo | Descripción | Ejemplo |
|-------|------|-------------|---------|
| `nuip` | String | Número único de identificación personal (documento) | "1234567890" |
| `names` | String | Nombres completos del participante | "Juan Carlos" |
| `surnames` | String | Apellidos completos del participante | "González Pérez" |
| `institution_name` | String | Nombre de la institución (ver valores permitidos) | "Universidad de Nariño" |
| `participation_modality` | String | Modalidad de participación (ver valores permitidos) | "Asistente" |

### Campos Opcionales

| Campo | Tipo | Descripción | Ejemplo |
|-------|------|-------------|---------|
| `cel` | String | Número de celular | "3001234567" |
| `phone` | String | Número de teléfono fijo | "27221234" |
| `email` | String | Correo electrónico (debe ser válido) | "juan@email.com" |
| `other_institution` | String | Otra institución (requerido si institution_name es "Otra") | "Instituto Tecnológico" |
| `type` | String | Tipo de participante (ver valores permitidos) | "Estudiante" |
| `stay_type` | String | Tipo de estadía (ver valores permitidos) | "Presencial" |
| `payment_status` | String | Estado de pago (ver valores permitidos) | "Sin pagar" |

## Valores Permitidos

### Modalidades de Participación (`participation_modality`)
- **"Asistente"** - Participante regular
- **"Ponente"** - Persona que presenta una ponencia
- **"Tallerista"** - Persona que dirige un taller
- **"Conferencista"** - Persona que da una conferencia
- **"Organizador"** - Miembro del equipo organizador

### Instituciones (`institution_name`)
- **"Otra"** - Institución no listada (requiere especificar `other_institution`)
- **"Corporación Universitaria Minuto de Dios"**
- **"Fundación Universitaria Católica 'Lumen Gentium'"**
- **"Universidad Católica de Manizales"**
- **"Universidad de Córdoba"**
- **"Universidad de Nariño"**
- **"Universidad del Magdalena"**
- **"Universidad Distrital Francisco José de Caldas"**
- **"Universidad Pedagógica Nacional"**
- **"Universidad Pedagógica y Tecnológica de Colombia"**

### Tipos de Participante (`type`)
- **"Estudiante del Programa de Lic. en Informática de la Universidad de Nariño"**
- **"Estudiante"**
- **"Docente"**
- **"Particular"**
- **"Egresado del programa de Licenciatura en Informática"**
- **"No definido"** (valor por defecto si no se especifica)

### Tipos de Estadía (`stay_type`)
- **"Presencial"** (valor por defecto si no se especifica)
- **"Virtual"**

### Estados de Pago (`payment_status`)
- **"Sin pagar"** (valor por defecto si no se especifica)
- **"No aplica"**
- **"Pagado"**

## Ejemplos de Archivos

### Ejemplo CSV
```csv
nuip,names,surnames,cel,phone,email,institution_name,other_institution,participation_modality,type,stay_type,payment_status
1234567890,Juan Carlos,González Pérez,3001234567,27221234,juan@email.com,Universidad de Nariño,,Asistente,Estudiante,Presencial,Sin pagar
0987654321,María Elena,Rodríguez López,3009876543,,maria@email.com,Otra,Instituto Tecnológico XYZ,Ponente,Docente,Virtual,Pagado
1122334455,Pedro Pablo,Martínez Silva,,,pedro@email.com,Universidad Pedagógica Nacional,,Tallerista,Particular,Presencial,No aplica
```

### Ejemplo JSON
```json
[
  {
    "nuip": "1234567890",
    "names": "Juan Carlos",
    "surnames": "González Pérez",
    "cel": "3001234567",
    "phone": "27221234",
    "email": "juan@email.com",
    "institution_name": "Universidad de Nariño",
    "other_institution": null,
    "participation_modality": "Asistente",
    "type": "Estudiante",
    "stay_type": "Presencial",
    "payment_status": "Sin pagar"
  },
  {
    "nuip": "0987654321",
    "names": "María Elena",
    "surnames": "Rodríguez López",
    "cel": "3009876543",
    "phone": null,
    "email": "maria@email.com",
    "institution_name": "Otra",
    "other_institution": "Instituto Tecnológico XYZ",
    "participation_modality": "Ponente",
    "type": "Docente",
    "stay_type": "Virtual",
    "payment_status": "Pagado"
  }
]
```

## Proceso de Importación

### 1. Preparación del Archivo
1. Prepare su archivo CSV o JSON con los datos de los participantes
2. Verifique que todos los campos obligatorios estén completos
3. Asegúrese de que los valores correspondan exactamente a los permitidos
4. Guarde el archivo con codificación UTF-8

### 2. Ejecución de la Importación
1. Acceda al sistema EvetCheck
2. Navegue al evento donde desea importar participantes
3. Busque la opción "Importar Participantes" o "Importación Masiva"
4. Seleccione su archivo preparado
5. Haga clic en "Importar"

### 3. Resultados de la Importación
El sistema mostrará un reporte con:
- **Registros leídos**: Total de registros procesados
- **Registros guardados**: Participantes importados exitosamente
- **Registros fallidos**: Registros que no pudieron ser procesados
- **Detalle de errores**: Lista específica de errores por registro

## Comportamiento del Sistema

### Creación Automática de Usuarios
- Si un participante no existe en el sistema (basado en el NUIP), se crea automáticamente
- El usuario se crea con rol de "assistant" (asistente)
- La contraseña se genera automáticamente usando: Primera letra del primer nombre + Primera letra del primer apellido + NUIP

### Validaciones y Restricciones
- **NUIP único**: No se puede registrar el mismo NUIP dos veces para el mismo evento
- **Email válido**: Si se proporciona email, debe tener formato válido
- **Institución requerida**: Si se selecciona "Otra", debe especificarse `other_institution`
- **Caracteres especiales**: Se respetan tildes y caracteres especiales en nombres

### Inscripción Automática a Actividades
- Los participantes se inscriben automáticamente a actividades que contengan "Refrigerio" en el nombre
- El estado de estas inscripciones es "SU" (Sin usar/registrar)

## Errores Comunes y Soluciones

### Error: "Ya existe una inscripción para esta persona en este evento"
**Causa**: El NUIP ya está registrado para el evento
**Solución**: Verifique si el participante ya fue registrado previamente

### Error: "El campo email debe ser una dirección de correo válida"
**Causa**: El formato del email es incorrecto
**Solución**: Corrija el formato del email (ejemplo: usuario@dominio.com)

### Error: "El campo nuip es obligatorio"
**Causa**: El campo NUIP está vacío o falta
**Solución**: Complete el campo NUIP para todos los registros

### Error: "El campo institution_name es obligatorio"
**Causa**: No se especificó la institución
**Solución**: Seleccione una institución válida de la lista permitida

### Error de formato de archivo
**Causa**: El archivo no tiene el formato correcto o está corrupto
**Solución**: 
- Para CSV: Verifique que tenga encabezados en la primera fila
- Para JSON: Valide que sea un array de objetos válido
- Asegúrese de que el archivo esté en UTF-8

## Recomendaciones

### Antes de la Importación
1. **Pruebe con pocos registros**: Haga una prueba inicial con 2-3 registros
2. **Valide los datos**: Revise que todos los valores correspondan a los permitidos
3. **Respalde su archivo**: Mantenga una copia del archivo original

### Durante la Importación
1. **No interrumpa el proceso**: Espere a que termine completamente
2. **Revise los resultados**: Analice el reporte de importación
3. **Corrija errores**: Si hay registros fallidos, corrija los datos y vuelva a importar

### Después de la Importación
1. **Verifique los participantes**: Confirme que los participantes aparezcan en la lista del evento
2. **Revise las actividades**: Confirme las inscripciones automáticas a refrigerios
3. **Comunique las credenciales**: Informe a los participantes sobre sus credenciales de acceso

## Soporte Técnico

Si encuentra problemas durante la importación:
1. Revise esta documentación
2. Verifique el formato de su archivo
3. Consulte los mensajes de error específicos
4. Contacte al administrador del sistema si el problema persiste

---

**Nota**: Esta documentación corresponde a la versión actual del sistema EvetCheck. Los campos y valores permitidos pueden cambiar en futuras actualizaciones.