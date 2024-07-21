<?php
namespace Api\Common\Log;

use ErrorException;

class Log {

    protected static string $storageLogPathRoot;

    //Cadastrar rota de pasta do log ./ will be the index.php folder
    public static function storageLogRoute(string $storageLogPathRoot){
        self::$storageLogPathRoot = $storageLogPathRoot;
    }

    public static function Log($logContent, string $label, string $folder = 'default-logs') {
        $completeRootPath = self::$storageLogPathRoot.'/'.$folder.'/';
        $file = $completeRootPath.'['.$label.']'.date('Y-m-d',time()).'.json';
        
        self::createPathIfNecessary($completeRootPath);

        self::createFileIfNecessary($file);

        file_put_contents($file, self::manipulateLogFile($file, $label, $logContent));
    }


    private static function createPathIfNecessary(string $completeRootPath){
        if (!is_dir($completeRootPath)){
            shell_exec('mkdir -p '.$completeRootPath);
        }
    }

    private static function createFileIfNecessary(string $file){
        if(!file_exists($file)){
            file_put_contents($file, '[]');
        }
    }

    private static function manipulateLogFile(string $file, string $label, $contentData) {   
        $fileContent = json_decode(trim(file_get_contents($file)), true);

        $id = bin2hex(random_bytes(3));
        $time = date('Y-m-d|H:i:s:', time());
        $fileContent["Log_id<".$id.'>'.$time] = [
                "Log_Id" => $id,
                "Date" => $time,
                "Label" => $label,
                "Content" => $contentData
                ];
              
        return json_encode($fileContent,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }

}

