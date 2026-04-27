# Full Setup Guide

Complete installation and configuration guide for running the Savings and Loan Association Management System from scratch.

---

## Requirements

| Component | Minimum Version |
|-----------|----------------|
| PHP | 8.2+ |
| Composer | 2.x |
| MySQL / MariaDB | 8.0+ / 10.6+ |
| Redis | 7+ |
| Node.js | 18+ |
| Swoole (optional) | 5.x — required for Laravel Octane |

---

## 1. Clone & Install

```bash
git clone <repo-url>
cd Savings-and-Loan-Association

composer install
npm install
```

---

## 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and fill in at minimum the following variables:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

GOOGLE_MAPS_API_KEY=your_google_maps_api_key

# Azure Blob Storage (if used)
AZURE_STORAGE_NAME=your_storage_account
AZURE_STORAGE_KEY=your_storage_key
AZURE_STORAGE_CONTAINER=your_container_name
```

### Read Replicas (optional)

To enable read/write splitting across MySQL replicas, set one or more read hosts:

```env
DB_HOST_READ_1=replica1.db.internal
DB_HOST_READ_2=replica2.db.internal
```

If left empty, all reads fall back to the primary host.

### Database Sharding (optional)

To distribute high-volume tables (`applications`, `taspens`, `contracts`, `installment_schedules`) across multiple database shards:

```env
DB_SHARD_COUNT=2       # number of extra shards (0 = disabled)
DB_SHARD_SIZE=100000   # max rows per shard before spilling to next

# Define shard connections in config/database.php as mysql_shard1, mysql_shard2, etc.
```

---

## 3. Database

```bash
php artisan migrate

# If seeders exist (initial / master data)
php artisan db:seed
```

---

## 4. Storage Link

```bash
php artisan storage:link
```

---

## 5. Build Assets

```bash
npm run build
```

---

## 6. Run (Development)

```bash
php artisan serve
```

Application runs at `http://127.0.0.1:8000`.

---

## 7. Run (Production with Octane / Swoole)

### Install Swoole

```bash
pecl install swoole
```

Add `extension=swoole` to your `php.ini`, then verify:

```bash
php -m | grep swoole
```

### Install & Start Octane

```bash
php artisan octane:install --server=swoole

php artisan octane:start --host=0.0.0.0 --port=8000 --workers=auto
```

---

## 8. Redis Setup

```bash
# Start Redis
redis-server

# Or via systemd
sudo systemctl start redis
sudo systemctl enable redis

# Verify connection
redis-cli ping
# Expected output: PONG
```

Redis is used for four separate purposes (each on a different database index):

| Purpose | Redis DB |
|---------|----------|
| Default | 0 |
| Cache | 1 |
| Queue | 2 |
| Session | 3 |

---

## 9. Queue Worker

```bash
php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
```

Heavy operations dispatched to the queue:
- **Excel report generation** (`reports` queue) — via `GenerateReportJob`
- **PDF generation** — via `GeneratePdfJob`
- **Application status processing** — via `ProcessApplicationStatusJob`

### Production — Supervisor configuration

Create `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/project/artisan queue:work redis --queue=reports,default --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/project/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

---

## 10. Scheduler (Cron)

Add the following entry to the server crontab (`crontab -e`):

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Environment Variables Reference

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `local` |
| `APP_KEY` | Application encryption key | *(generated)* |
| `APP_URL` | Application URL | `http://localhost` |
| `DB_HOST` | Database primary host | `127.0.0.1` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | — |
| `DB_USERNAME` | Database username | — |
| `DB_PASSWORD` | Database password | — |
| `DB_HOST_READ_1` | Read replica host 1 | *(falls back to DB_HOST)* |
| `DB_HOST_READ_2` | Read replica host 2 | — |
| `DB_SHARD_COUNT` | Number of extra shards | `0` |
| `DB_SHARD_SIZE` | Rows per shard before overflow | `100000` |
| `DB_PERSISTENT` | Use persistent PDO connections | `false` |
| `REDIS_HOST` | Redis host | `127.0.0.1` |
| `REDIS_PORT` | Redis port | `6379` |
| `REDIS_PASSWORD` | Redis password | `null` |
| `CACHE_DRIVER` | Cache driver | `redis` |
| `SESSION_DRIVER` | Session driver | `redis` |
| `QUEUE_CONNECTION` | Queue driver | `redis` |
| `GOOGLE_MAPS_API_KEY` | Google Maps API key | — |
| `AZURE_STORAGE_NAME` | Azure Storage account name | — |
| `AZURE_STORAGE_KEY` | Azure Storage access key | — |
| `AZURE_STORAGE_CONTAINER` | Azure container name | — |
| `OCTANE_SERVER` | Octane server engine | `swoole` |
| `SWOOLE_WORKERS` | Number of Swoole workers | *(auto: CPU × 2)* |
| `SWOOLE_TASK_WORKERS` | Number of task workers | *(auto: CPU count)* |
| `SWOOLE_MAX_REQUESTS` | Max requests per worker | `1000` |

---

## Nginx Configuration (Production)

### Standard (PHP-FPM)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### With Octane (Reverse Proxy to port 8000)

```nginx
server {
    listen 80;
    server_name yourdomain.com;

    location / {
        proxy_pass         http://127.0.0.1:8000;
        proxy_http_version 1.1;
        proxy_set_header   Upgrade $http_upgrade;
        proxy_set_header   Connection 'upgrade';
        proxy_set_header   Host $host;
        proxy_set_header   X-Real-IP $remote_addr;
        proxy_set_header   X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
        proxy_cache_bypass $http_upgrade;
    }
}
```

---

## Troubleshooting

### Storage / cache permission errors

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Clear all caches

```bash
php artisan optimize:clear
```

### Optimize for production

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Octane worker management

```bash
php artisan octane:status
php artisan octane:reload   # graceful reload with zero downtime
php artisan octane:stop
```

### Tail application logs

```bash
tail -f storage/logs/laravel.log
```
