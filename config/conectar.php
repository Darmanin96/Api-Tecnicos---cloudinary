<?php
require_once 'vendor/autoload.php';
use Cloudinary\Cloudinar;

class DatabaseConfig{
    private static $cloudinary = null;
    private static $db = null;

    public static function getCloudinary() {
        if (self::$cloudinary === null) {
            $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
            $apiKey = getenv('CLOUDINARY_API_KEY');
            $apiSecret = getenv('CLOUDINARY_API_SECRET');

            self::$cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $cloudName,
                    'api_key'    => $apiKey,
                    'api_secret' => $apiSecret,
                ],
                'url' => [
                    'secure' => true
                ]
            ]);
        }
        return self::$cloudinary;
    }

    public static function getDbConnection() {
        if (self::$db === null) {
            $host = getenv('DB_HOST');
            $dbName = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');

            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
            try {
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$db;
    }
}

?>
