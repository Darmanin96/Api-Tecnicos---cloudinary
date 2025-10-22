<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Cloudinary;

class DatabaseConfig{
    private static $cloudinary = null;
    private static $db = null;




    public static function cargarEnv(){
        $env = __DIR__ . '/../.env';
        if (file_exists($env)) {
            $lines = file($env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (!array_key_exists($key, $_ENV)) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                }
            }
        }
    }

    public static function getCloudinary() {
        if (self::$cloudinary === null) {
            self::cargarEnv();
            $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
            $apiKey = getenv('CLOUDINARY_API_KEY');
            $apiSecret = getenv('CLOUDINARY_API_SECRET');

              if (!$cloudName || !$apiKey || !$apiSecret) {
                throw new Exception(
                    'Cloudinary configuration missing. ' .
                    'Please check your .env file. ' .
                    'Cloud Name: ' . ($cloudName ? 'SET' : 'MISSING') . ', ' .
                    'API Key: ' . ($apiKey ? 'SET' : 'MISSING') . ', ' .
                    'API Secret: ' . ($apiSecret ? 'SET' : 'MISSING')
                );
            }
            
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
