# NR Tickets

Sistema de gestión de servicios de GPS para técnicos de campo.

## Stack Tecnológico

- **Backend:** Laravel 11, PHP 8.3+
- **Frontend:** Vue 3 (Composition API), Inertia.js, TailwindCSS
- **Autenticación:** Laravel Breeze (Vue)
- **Roles:** Spatie Laravel Permission
- **Imágenes:** Intervention Image
- **Base de datos:** MySQL con UUIDs

## Requisitos

- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8.0+
- Docker (opcional, se asume que ya existe)

## Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd nr-tickets
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con los datos de conexión a MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nr_tickets
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Configurar almacenamiento

```bash
php artisan storage:link
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

Esto creará:
- Roles: `admin` y `tecnico`
- Sucursales de ejemplo (CDMX, GDL, MTY)
- Usuario admin: `admin@example.com` / `password`
- Usuario técnico: `tecnico@example.com` / `password`

### 6. Compilar assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 7. Iniciar servidor

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## Configuración de Branding

El archivo `config/branding.php` permite personalizar:

### Nombres

```php
'app_name' => env('BRANDING_APP_NAME', 'NR Tickets'),
'company_name' => env('BRANDING_COMPANY_NAME', 'NR Impuestos'),
```

### Logos

```php
'logos' => [
    'light' => '/images/logo-light.svg',
    'dark' => '/images/logo-dark.svg',
],
```

Coloca los logos en `public/images/`.

### Paleta de Colores

Los colores se definen en `config/branding.php` y se exponen como variables CSS en `resources/css/app.css`. Para cambiar la paleta:

1. Modificar los valores hex en `config/branding.php`
2. Actualizar las variables CSS correspondientes en `resources/css/app.css`
3. Recompilar: `npm run build`

Uso en clases Tailwind:
```html
<button class="bg-brand-primary-500 hover:bg-brand-primary-600">
    Acción
</button>
```

### Modo Oscuro

El modo oscuro se activa mediante el toggle en la barra de navegación. La preferencia se guarda en `localStorage`.

## Variables de Entorno

| Variable | Descripción | Default |
|----------|-------------|---------|
| `APP_TIMEZONE` | Zona horaria | `America/Mexico_City` |
| `BRANDING_APP_NAME` | Nombre de la aplicación | `NR Tickets` |
| `BRANDING_COMPANY_NAME` | Nombre de la empresa | `NR Impuestos` |
| `EVIDENCE_MAX_SIZE_KB` | Tamaño máximo de evidencias (KB) | `5120` (5MB) |
| `DB_CONNECTION` | Driver de base de datos | `mysql` |

## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/      # Controladores por recurso
│   ├── Middleware/       # Middleware (Inertia, Auth)
│   ├── Requests/         # Form Request Validations
│   └── Resources/        # API Resources (DTOs)
├── Models/               # Modelos Eloquent con UUIDs
├── Policies/             # Políticas de autorización
└── Services/             # Servicios (ej: EvidenceImageService)

resources/
├── js/
│   ├── Components/       # Componentes Vue reutilizables
│   ├── Layouts/          # Layouts de la aplicación
│   └── Pages/            # Páginas Vue (rutas)
└── css/
    └── app.css           # CSS con variables de branding

config/
└── branding.php          # Configuración de branding
```

## Roles y Permisos

### Admin
- Ver todos los servicios
- Gestionar usuarios (crear técnicos)
- Gestionar sucursales
- Acceso completo

### Técnico
- Ver solo sus propios servicios
- Crear nuevos servicios
- Sin acceso a administración

## Funcionalidades

### Servicios
- Registro de servicios de GPS (Instalación, Retiro, Cambio de equipo)
- Captura de número de serie (5-128 caracteres)
- Dos evidencias fotográficas obligatorias
- Compresión automática de imágenes
- Fecha/hora automática en zona CDMX
- Sin edición después de creación

### Evidencias
- Captura directa desde cámara móvil
- Formatos: JPG, PNG
- Máximo 5MB por imagen (configurable)
- Almacenamiento: `storage/app/public/evidences/{servicio_uuid}/`

## Desarrollo

### Ejecutar tests

```bash
php artisan test
```

### Linting PHP

```bash
./vendor/bin/pint
```

### Compilación en modo watch

```bash
npm run dev
```

## Docker

Este proyecto asume que ya tienes Docker configurado. Asegúrate de:

1. Que `DB_HOST` en `.env` apunte al servicio de MySQL de tu docker-compose
2. Que la red de Docker permita la comunicación entre contenedores

## Licencia

Proyecto privado - NR Impuestos
