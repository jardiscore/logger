# Jardis Logger

![Build Status](https://github.com/jardisCore/logger/actions/workflows/ci.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-success.svg)](phpstan.neon)
[![PSR-3](https://img.shields.io/badge/PSR--3-Logger%20Interface-blue.svg)](https://www.php-fig.org/psr/psr-3/)
[![PSR-4](https://img.shields.io/badge/autoload-PSR--4-blue.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR-12](https://img.shields.io/badge/code%20style-PSR--12-orange.svg)](phpcs.xml)
[![Coverage](https://img.shields.io/badge/coverage-85.66%25-brightgreen.svg)](phpunit.xml)

**PSR-3 Logger for PHP 8.2+ • Simple Start • Enterprise Scale • Domain-Driven Design**

```php
// One line. Done.
$logger = (new Logger('MyApp'))->addConsole(LogLevel::INFO);
$logger->info('Hello World');
```

## What Makes Jardis Logger Special?

### 🚀 Productive in Seconds
No config files, no complex setup. Fluent interface with IDE autocomplete for all 20+ handlers.

### ⚡ Flexibly Scalable
From simple scripts to multi-context enterprise architectures. One logger per bounded context (DDD).

### 🎯 Production-Ready Features
- **20+ Handlers**: File, Console, Slack, Teams, Kafka, RabbitMQ, Redis, Loki, Database, Email, Webhook...
- **Smart Handlers**: FingersCrossed (buffering), Sampling (volume reduction), Conditional (routing)
- **Auto-Enrichment**: Timestamps, UUIDs, Memory, IPs automatically added to every log
- **Multiple Formats**: JSON, Human-Readable, Loki, Slack, Teams, ChromeLogger
- **Named Handlers**: Dynamic handler management at runtime
- **Error Resilience**: One handler fails? Others continue processing

### 🏆 Enterprise-Grade Quality
- **PSR-3 Compliant** - Drop-in replacement
- **PHPStan Level 8** - Highest static analysis level
- **85.66% Code Coverage** - 285 tests, 709 assertions
- **PHP 8.2+ Strict Types** - Full type safety

## Installation

```bash
composer require jardis/core-logger
```

## Quick Start

### Get Started in 3 Lines
```php
use JardisCore\Logger\Logger;
use Psr\Log\LogLevel;

$logger = (new Logger('App'))->addConsole(LogLevel::INFO);
$logger->info('User {user} logged in', ['user' => 'john.doe']);
```

### Fluent Interface - Chain Handlers
```php
$logger = (new Logger('OrderService'))
    ->addConsole(LogLevel::DEBUG)                    // Development: Everything to console
    ->addFile(LogLevel::INFO, '/var/log/app.log')    // Production: INFO+ to file
    ->addSlack(LogLevel::ERROR, 'https://...')       // Alerts: ERROR+ to Slack
    ->addKafkaMq($producer, 'logs');                 // Analytics: Everything to Kafka

$logger->debug('Validating order data');         // → Console only
$logger->info('Order #12345 created');           // → Console + File + Kafka
$logger->error('Payment gateway timeout');       // → ALL handlers
```

### Auto-Enrichment - Automatic Context
```php
$logger = (new Logger('API'))->addFile(LogLevel::INFO, '/var/log/api.log', 'api');

$logger->getHandler('api')
    ->logData()
    ->addField('timestamp', new LogDateTime())     // Root-level (for DB columns, indexing)
    ->addField('request_id', new LogUuid())        // Root-level
    ->addExtra('memory_mb', new LogMemoryUsage())  // Inside 'data' (business context)
    ->addExtra('client_ip', new LogClientIp());    // Inside 'data'

// Every log now automatically includes: timestamp, request_id, memory_mb, client_ip
$logger->info('Request processed', ['endpoint' => '/api/users']);
```

## 📚 Complete Examples

We've created **13 progressive examples** - from simple to enterprise:

### 🎓 Getting Started
| Example | Description | Link |
|---------|-------------|------|
| **01** | Quick Start - One-Line Logger | [→ Code](examples/01-simple-start.php) |
| **02** | File Logging + Context Interpolation | [→ Code](examples/02-file-logging.php) |
| **03** | Multiple Handlers with Level Filtering | [→ Code](examples/03-multiple-handlers.php) |

### 🔧 Advanced Features
| Example | Description | Link |
|---------|-------------|------|
| **04** | Enrichers - Auto-Context (Timestamps, UUIDs, Memory, IP) | [→ Code](examples/04-enrichers.php) |
| **05** | Named Handlers - Dynamic Management | [→ Code](examples/05-named-handlers.php) |
| **06** | Formatters - JSON, Human, Line, Loki, Slack | [→ Code](examples/06-formatters.php) |
| **07** | FingersCrossed - Smart Buffering for Production | [→ Code](examples/07-fingerscrossed.php) |
| **08** | Sampling - Volume Reduction (Percentage, Smart) | [→ Code](examples/08-sampling.php) |
| **09** | Conditional Routing - Multi-Tenant Ready | [→ Code](examples/09-conditional-routing.php) |

### 🏢 Enterprise & Message Queues
| Example | Description | Link |
|---------|-------------|------|
| **10** | DDD Bounded Contexts - Enterprise Architecture | [→ Code](examples/10-ddd-bounded-contexts.php) |
| **11** | Redis Pub/Sub - Real-Time Log Streaming | [→ Code](examples/11-redis-pubsub.php) |
| **12** | RabbitMQ (AMQP) - Enterprise Message Queue | [→ Code](examples/12-rabbitmq.php) |
| **13** | Apache Kafka - High-Throughput Streaming | [→ Code](examples/13-kafka.php) |

## Handler Overview

### Basic Handlers (Fluent Methods)
```php
->addConsole(LogLevel::INFO)                        // STDOUT/STDERR
->addFile(LogLevel::INFO, '/var/log/app.log')      // File with rotation support
->addSyslog(LogLevel::WARNING)                      // System syslog
->addErrorLog(LogLevel::ERROR)                      // PHP error_log()
```

### Chat & Alerts
```php
->addSlack(LogLevel::ERROR, 'https://hooks.slack.com/...')
->addTeams(LogLevel::CRITICAL, 'https://outlook.office.com/...')
->addEmail(LogLevel::CRITICAL, 'admin@example.com', 'logger@example.com')
```

### Observability
```php
->addLoki(LogLevel::INFO, 'http://loki:3100/...', ['service' => 'api'])
->addStash(LogLevel::INFO, 'logstash.local', 5000)
->addBrowserConsole(LogLevel::DEBUG)  // ChromeLogger for DevTools
```

### Message Queues
```php
->addKafkaMq($producer, 'application-logs')
->addRabbitMq($connection, 'logs-exchange')
->addRedisMq($redis, 'logs-channel')
```

### Storage
```php
->addDatabase(LogLevel::INFO, $pdo, 'logs_table')
->addRedis(LogLevel::WARNING, 'localhost', 6379)
```

### Network
```php
->addWebhook(LogLevel::ERROR, 'https://api.example.com/logs', 'webhook', 'POST')
```

### Smart Handlers
```php
// Buffering: Write DEBUG only on ERROR
->addFingersCrossed($handler, LogLevel::ERROR, 100, true)

// Sampling: 10% of DEBUG, 100% of ERROR+
->addSampling($handler, LogSampling::STRATEGY_PERCENTAGE, ['percentage' => 10])

// Routing: Condition-based
->addConditional([
    [fn($l, $m, $ctx) => $ctx['admin'] ?? false, $adminHandler],
    [fn($l, $m, $ctx) => $l === LogLevel::CRITICAL, $alertHandler],
], $defaultHandler)
```

## Enricher Overview

Enrichers are callables that automatically add data to every log:

```php
use JardisCore\Logger\Enricher\{LogDateTime, LogUuid, LogMemoryUsage, LogMemoryPeak, LogClientIp, LogWebRequest};

$handler->logData()
    ->addField('timestamp', new LogDateTime())     // ISO 8601
    ->addField('request_id', new LogUuid())        // UUID v4
    ->addExtra('memory_mb', new LogMemoryUsage())  // Current memory
    ->addExtra('memory_peak_mb', new LogMemoryPeak())
    ->addExtra('client_ip', new LogClientIp())
    ->addExtra('http_request', new LogWebRequest());
```

**Difference:**
- `addField()` → Root-level (DB columns, indexing, search)
- `addExtra()` → Inside 'data' field (business context, dynamic)

## Formatter Overview

Each handler can have its own formatter:

```php
use JardisCore\Logger\Formatter\{LogJsonFormat, LogHumanFormat, LogLineFormat, LogLokiFormat, LogSlackFormat, LogTeamsFormat, LogBrowserConsoleFormat};

$logger->addFile(LogLevel::INFO, '/var/log/app.log', 'json', new LogJsonFormat());
$logger->addConsole(LogLevel::DEBUG, 'console', new LogHumanFormat());
```

- `LogJsonFormat` - Structured JSON for ELK, Splunk
- `LogHumanFormat` - Multi-line, readable for console
- `LogLineFormat` - Compact, single-line
- `LogLokiFormat` - Grafana Loki with labels
- `LogSlackFormat` - Slack Block Kit
- `LogTeamsFormat` - Microsoft Teams MessageCard
- `LogBrowserConsoleFormat` - ChromeLogger Protocol

## Production Features

### Named Handler Management
```php
$logger->addFile(LogLevel::INFO, '/tmp/app.log', 'app_log');
$logger->addFile(LogLevel::ERROR, '/tmp/error.log', 'error_log');

// Retrieve by name
$handler = $logger->getHandler('app_log');

// Remove by name
$logger->removeHandler('error_log');

// Get all handlers of type
$fileHandlers = $logger->getHandlersByClass(LogFile::class);

// Get all handlers
$allHandlers = $logger->getHandlers();
```

### Error Handling
```php
$logger->setErrorHandler(function (\Throwable $e, string $handlerId, string $level, string $message, array $context) {
    error_log("Handler {$handlerId} failed: {$e->getMessage()}");
    // Logger continues with other handlers
});
```

### DDD Architecture Pattern
```php
// Each bounded context has its own logger
class OrderContext {
    private Logger $logger;

    public function __construct() {
        $this->logger = (new Logger('OrderContext'))
            ->addFile(LogLevel::INFO, '/var/log/orders.log')
            ->addKafkaMq($producer, 'order-events');
    }
}

class PaymentContext {
    private Logger $logger;

    public function __construct() {
        $this->logger = (new Logger('PaymentContext'))
            ->addFile(LogLevel::DEBUG, '/var/log/payments.log')
            ->addSlack(LogLevel::CRITICAL, 'https://...');
    }
}
```

## Development

```bash
# Start Docker services (Redis, Kafka, RabbitMQ, MailHog, WireMock)
make start

# Run all tests
make phpunit

# Coverage report
make phpunit-coverage-html

# Static analysis
make phpstan

# Code style check
make phpcs

# Stop services
make stop
```

**Test Statistics:**
- 285 Tests, 709 Assertions
- 85.66% Line Coverage, 75.90% Method Coverage
- Unit + Integration Tests
- PHPStan Level 8, PSR-12

## Requirements

- **PHP 8.2+** (Strict Types)
- **PSR-3** (psr/log)
- **Optional Extensions**: ext-redis, ext-amqp, ext-rdkafka (only for specific handlers)

## License

MIT License - Free to use in commercial and open-source projects.

---

**Made with ❤️ for modern PHP applications.**
