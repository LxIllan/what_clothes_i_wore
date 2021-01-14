<?php

class Util {

    public const DRESS_ITEM_PHOTO = 0;
    public const USER_PHOTO = 1;
    public const APP_NAME = 'Used Clothing';
    public const CATEGORIES = [1 => 'Accesorios', 'Calzado', 'Complementos', 'Piernas', 'Torso'];
    public const SEX = [1 => 'Femenino', 'Masculino', 'Unisex'];
    public const AVAILABLE = ['Unavailable', 'Available'];
    public const STR_FOOTER = 'Copyright © Used Clothing 2021';

    public static function uploadPhoto(?array $photo, int $uploadId, int $typeOfPhoto = 0) : string {
        $defaulPhoto = ['img/dress_items/default.jpg', 'img/users/default.jpg'];
        $folder = ($typeOfPhoto == 0) ? 'dress_items' : 'users';
        $photoName = 'img/' . $folder . '/' . 'IMG_' . $uploadId . '.jpeg';
        if ((isset($photo)) && (($photo['type'] == 'image/jpeg') || ($photo['type'] == 'image/jpg') || ($photo['type'] == 'image/png'))) {
            $source = $photo['tmp_name'];
            $destination = 'img/' . $folder . '/' . $photo['name'];
            $photoName = 'img/' . $folder . '/' . 'IMG_' . $uploadId . '.' . end((explode('.', $photo['name'])));
            
            if (is_uploaded_file($source)) {
                array_map('unlink', glob('img/' . $folder . '/' . 'IMG_' . $uploadId . '.*'));
            } else {
                echo 'Error: El fichero encontrado no fue procesado por la subida correctamente';
                return $defaulPhoto[$typeOfPhoto];
            }
            if (@move_uploaded_file($source, $destination)) {
                if (rename($destination, $photoName)) {
                    return $photoName;
                } else {
                    unlink($photoName);
                    return $defaulPhoto[$typeOfPhoto];
                }
            } else {
                return $defaulPhoto[$typeOfPhoto];
            }
        }
        return (file_exists($photoName)) ? $photoName : $defaulPhoto[$typeOfPhoto];
    }

    public static function changeDateFormat(string $date, bool $showHour = false) : string {
        return ($showHour) ? date('Y-m-d H:i:s', strtotime($date)) : date('d/F/Y', strtotime($date));
    }

    public static function createPassword(int $numChars = 8) : string {
        $str = "0123456789abcdefghijklmnopqrstuvwxyz0123456789"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $lenStr = strlen($str);
        $clave = '';
        $i = 0;
        while ($i++ < $numChars) {
            $clave .= $str[rand(0, $lenStr)];
        }
        return $clave;
    }    
    
    private static function limpiarCadena(string $str) : string {
        $inyecciones = array(
            '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
            '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
            '@<![\s\S]*?--[ \t\n\r]*>@',         // Elimina los comentarios multi-línea
            '/[^a-zA-ZáéíóúñÁÉÍÓÚÑ ]/'		// Elimina números y todo tipo de signo
            );
        $str = preg_replace($inyecciones, '', $str);
        return $str;
    }
    
    public static function sanitizar(string $str) : string {
        if (is_array($str)) {
            foreach ($str as $var => $val) {
                $salida[$var] = self::sanitizar($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            $salida  = self::limpiarCadena($str);
            //$salida = mysqli::real_escape_string ($str);
        }
        return $salida;
    }

    public static function validateEmail($email) : bool {
        return (filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}

/*
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> Better check yourself, you're not looking too good.
</div>
*/
