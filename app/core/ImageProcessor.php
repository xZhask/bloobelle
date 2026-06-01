<?php
namespace App\Core;

class ImageProcessor {
    /**
     * Procesa una imagen subida, la redimensiona y la convierte a WebP.
     *
     * @param string $tmpPath Ruta temporal del archivo subido.
     * @param string $destDir Directorio de destino físico.
     * @param string $filenamePrefix Prefijo para el nombre del archivo generado.
     * @param int $maxWidth Ancho o alto máximo de la imagen.
     * @param int $quality Calidad de la compresión WebP (0-100).
     * @return string|false Nombre del archivo generado (con extensión .webp) o false si falla.
     */
    public static function processAndSave(string $tmpPath, string $destDir, string $filenamePrefix, int $maxWidth = 800, int $quality = 80) {
        if (!file_exists($tmpPath)) return false;

        $info = getimagesize($tmpPath);
        if ($info === false) return false;

        [$width, $height, $type] = $info;

        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = @imagecreatefromjpeg($tmpPath);
                break;
            case IMAGETYPE_PNG:
                $image = @imagecreatefrompng($tmpPath);
                break;
            case IMAGETYPE_WEBP:
                $image = @imagecreatefromwebp($tmpPath);
                break;
            default:
                return false; // Formato no soportado
        }

        if (!$image) return false;

        // Calcular nuevas dimensiones manteniendo la proporción
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth || $height > $maxWidth) {
            $ratio = $width / $height;
            if ($ratio > 1) {
                $newWidth = $maxWidth;
                $newHeight = (int)($maxWidth / $ratio);
            } else {
                $newHeight = $maxWidth;
                $newWidth = (int)($maxWidth * $ratio);
            }
        }

        // Crear nueva imagen con las nuevas dimensiones
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Conservar transparencia (útil si el original era PNG con fondo transparente)
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);

        // Redimensionar e interpolar
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Crear el directorio si no existe
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        // Generar nombre de archivo único con extensión .webp
        $filename = uniqid($filenamePrefix) . '.webp';
        $destPath = rtrim($destDir, '/') . '/' . $filename;

        // Guardar como WebP
        $success = imagewebp($newImage, $destPath, $quality);

        return $success ? $filename : false;
    }
}
