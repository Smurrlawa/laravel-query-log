## Laravel Query Logger
A simple Laravel package to log all database queries to a configurable log channel. Supports conditional logging by environment and slow query reporting.

---

### 📦 Installation

```shell
composer require smurrlawa/laravel-query-logger
```

---

### ⚙️ Configuration

#### Publish the config file

```shell
php artisan vendor:publish --tag=query-logger-config
```

This will publish the configuration to `config/query-logger.php`.

---

### Available Options

```php
return [
    'enabled' => env('QUERY_LOGGER_ENABLED', true),

    'channel' => env('QUERY_LOGGER_CHANNEL', 'daily'),

    'slow_queries_enabled' => env('QUERY_LOGGER_SLOW_QUERIES_ENABLED', true),

    'slow_queries_threshold' => env('QUERY_LOGGER_SLOW_QUERIES_THRESHOLD', 1000),

    'environments' => ['local', 'staging'],
];
```

#### ✅ Option Descriptions

| Option                    | Description                                                                 |
|--------------------------|-----------------------------------------------------------------------------|
| `enabled`                | Enable or disable query logging completely.                                 |
| `channel`                | The log channel to use (`config/logging.php` or PSR logger class).          |
| `slow_queries_enabled`   | Whether to log slow queries separately.                                     |
| `slow_queries_threshold` | Time in **milliseconds** to consider a query as slow.                       |
| `environments`           | List of environments where query logging should be active.                  |

---

### 🧪 Example Usage

To log all queries in `local` environment and warn about slow queries:

```dotenv
APP_ENV=local

QUERY_LOGGER_ENABLED=true
QUERY_LOGGER_CHANNEL=daily

QUERY_LOGGER_SLOW_QUERIES_ENABLED=true
QUERY_LOGGER_SLOW_QUERIES_THRESHOLD=500
```

---

### 🚀 Features
📝 Logs all database queries (SQL, bindings, execution time)

🐢 Logs slow queries exceeding a customizable threshold

⚙️ Fully configurable via config file and environment variables

🌍 Supports environment-specific logging (e.g., local, staging)

📡 Supports custom log channels and PSR-3 loggers

---

### ✅ Compatibility
Tested with **Laravel 11** and **Laravel 12**.

---

### 📁 License

MIT © [Smurrlawa](https://github.com/smurrlawa)
