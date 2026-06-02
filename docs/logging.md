# Laravel Logging
    Laravel logging is a process notes activities, errors, warnings, or certain information which occurs in an application.

    In laravel, logging used to help developers :

        - Tracking errors
        - Application debug
        - Monitor system activity
        - Know the process that is running

    Laravel provides powerful logging system using the Monolog library.

# Logging Configuration
    - By default, laravel uses config/logging.php file for  logging configuration.
    - While the default channel settings is usually taken from file : LOG_CHANNEL=stack

# Log File Location

By default, Laravel stores log files in:

```bash
storage/logs/
```

Example:

```bash
storage/logs/laravel.log
```

---

# Using Logging in Laravel

Laravel provides the `Log` facade for writing logs.

Import the facade first:

```php
use Illuminate\Support\Facades\Log;
```

Example usage:

```php
Log::info("User logged in successfully");
```

---

# Logging Levels

Laravel supports multiple logging levels.

| Level     | Description                 |
| --------- | --------------------------- |
| emergency | System is unusable          |
| alert     | Immediate action required   |
| critical  | Critical conditions         |
| error     | General errors              |
| warning   | Warning messages            |
| notice    | Important but normal events |
| info      | Informational messages      |
| debug     | Debugging information       |

Examples:

```php
Log::error("Database connection failed");
```

```php
Log::warning("Storage capacity is almost full");
```

```php
Log::debug("User data", [$user]);
```

---

# Logging Additional Context Data

You can also send additional data into logs:

```php
Log::info("User information", [
    "id" => $user->id,
    "email" => $user->email
]);
```

This is very useful for debugging and monitoring.

---

# Logging Channels

Laravel uses channels to determine where logs should be written.

Some built-in channels include:

* single
* daily
* stack
* slack
* syslog

Example:

```php
Log::channel('daily')->info("Daily log message");
```

---

# Daily Logging

If you use the `daily` channel, Laravel automatically creates a new log file every day.

Example:

```env
LOG_CHANNEL=daily
```

Generated log file example:

```bash
laravel-2026-06-02.log
```

This helps manage large log files more efficiently.

---

# Logging with Try Catch

Logging is commonly used with `try-catch` blocks.

Example:

```php
try {
    DB::table('users')->get();
} catch (\Exception $e) {
    Log::error($e->getMessage());
}
```

This allows errors to be stored inside log files for easier debugging.

---

# The logger() Helper

Laravel also provides a global helper function:

```php
logger("Hello Logger");
```

Or:

```php
logger()->error("Something went wrong");
```

---

# Common Use Cases

Logging is commonly used for:

* User login/logout activity
* Error tracking
* API request monitoring
* Feature debugging
* System monitoring
* Recording important application events

---

# Conclusion

Laravel Logging is an essential feature for monitoring and debugging applications.

It helps developers:

* Detect problems faster
* Monitor application behavior
* Store important system information
* Improve debugging efficiency

Laravel logging is:

* Easy to use
* Flexible
* Powerful
* Integrated with Monolog
