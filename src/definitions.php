<?php

namespace PHPMaker2024\Sakila;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Platforms;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Events;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use FastRoute\RouteParser\Std;
use Illuminate\Encryption\Encrypter;
use HTMLPurifier_Config;
use HTMLPurifier;

// Connections and entity managers
$definitions = [];
$dbids = array_keys(Config("Databases"));
foreach ($dbids as $dbid) {
    $definitions["connection." . $dbid] = \DI\factory(function (string $dbid) {
        return ConnectDb(Db($dbid));
    })->parameter("dbid", $dbid);
    $definitions["entitymanager." . $dbid] = \DI\factory(function (ContainerInterface $c, string $dbid) {
        $cache = IsDevelopment()
            ? DoctrineProvider::wrap(new ArrayAdapter())
            : DoctrineProvider::wrap(new FilesystemAdapter(directory: Config("DOCTRINE.CACHE_DIR")));
        $config = Setup::createAttributeMetadataConfiguration(
            Config("DOCTRINE.METADATA_DIRS"),
            IsDevelopment(),
            null,
            $cache
        );
        $conn = $c->get("connection." . $dbid);
        return new EntityManager($conn, $config);
    })->parameter("dbid", $dbid);
}

return [
    "app.cache" => \DI\create(CacheProvider::class),
    "app.flash" => fn(ContainerInterface $c) => new Messages(),
    "app.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "email.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "sms.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "app.audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler($GLOBALS["RELATIVE_PATH"] . "log/audit.log")), // For audit trail
    "app.logger" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log/log.log")),
    "sql.logger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debug.stack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "app.csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "html.purifier.config" => fn(ContainerInterface $c) => HTMLPurifier_Config::createDefault(),
    "html.purifier" => fn(ContainerInterface $c) => new HTMLPurifier($c->get("html.purifier.config")),
    "debug.stack" => \DI\create(DebugStack::class),
    "debug.sql.logger" => \DI\create(DebugSqlLogger::class),
    "debug.timer" => \DI\create(Timer::class),
    "app.security" => \DI\create(AdvancedSecurity::class),
    "user.profile" => \DI\create(UserProfile::class),
    "app.session" => \DI\create(HttpSession::class),
    "mime.types" => \DI\create(MimeTypes::class),
    "app.language" => \DI\create(Language::class),
    PermissionMiddleware::class => \DI\create(PermissionMiddleware::class),
    ApiPermissionMiddleware::class => \DI\create(ApiPermissionMiddleware::class),
    JwtMiddleware::class => \DI\create(JwtMiddleware::class),
    Std::class => \DI\create(Std::class),
    Encrypter::class => fn(ContainerInterface $c) => new Encrypter(AesEncryptionKey(base64_decode(Config("AES_ENCRYPTION_KEY"))), Config("AES_ENCRYPTION_CIPHER")),

    // Tables
    "actor" => \DI\create(Actor::class),
    "actor_info" => \DI\create(ActorInfo::class),
    "address" => \DI\create(Address::class),
    "category" => \DI\create(Category::class),
    "city" => \DI\create(City::class),
    "country" => \DI\create(Country::class),
    "customer" => \DI\create(Customer::class),
    "customer_list2" => \DI\create(CustomerList2::class),
    "film" => \DI\create(Film::class),
    "film_actor" => \DI\create(FilmActor::class),
    "film_category" => \DI\create(FilmCategory::class),
    "film_list2" => \DI\create(FilmList2::class),
    "film_text" => \DI\create(FilmText::class),
    "inventory" => \DI\create(Inventory::class),
    "language2" => \DI\create(Language2::class),
    "nicer_but_slower_film_list" => \DI\create(NicerButSlowerFilmList::class),
    "payment" => \DI\create(Payment::class),
    "rental" => \DI\create(Rental::class),
    "sales_by_film_category" => \DI\create(SalesByFilmCategory::class),
    "sales_by_store" => \DI\create(SalesByStore::class),
    "staff" => \DI\create(Staff::class),
    "staff_list2" => \DI\create(StaffList2::class),
    "store" => \DI\create(Store::class),
    "audittrail" => \DI\create(Audittrail::class),
    "exportlog" => \DI\create(Exportlog::class),
    "DashboardAll" => \DI\create(DashboardAll::class),
    "dashboardall" => \DI\create(DashboardAll::class),

    // User table
    "usertable" => \DI\get("staff"),
] + $definitions;
