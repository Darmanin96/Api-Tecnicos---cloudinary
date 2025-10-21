<?php
require_once 'vendor/autoload.php';

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Gravity;
use Cloudinary\Transformation\Crop;

class CloudinaryService {
    private $cloudinary;

    public function __construct($cloudinary) {
        $this->cloudinary = $cloudinary;
    }
}


?>