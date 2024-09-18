<?php
/**
 * debug.php
 * 
 * Arquivo de configuração abrangente para depuração no PHP.
 * Inclui funções para ativar/desativar a depuração, utilitários de inspeção,
 * tratamento global de erros e exceções, e integração com ferramentas externas.
 */

/**
 * Classe Debug
 * 
 * Gerencia as configurações de depuração, utilitários e tratamento de erros/exceções.
 */
class Debug {
    private static $logFilePath = __DIR__ . '/_app/var/log/php/error.log';

    public static function enable($logToFile = true, $logFile = null) {
        // Se um caminho personalizado for fornecido, use-o
        if ($logFile !== null) {
            self::$logFilePath = $logFile;
        }

        // Verificar se o diretório existe
        $logDir = dirname(self::$logFilePath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true); // Cria o diretório com permissões 755
        }

        // Verificar se o arquivo de log existe, se não, cria
        if (!file_exists(self::$logFilePath)) {
            touch(self::$logFilePath);
            // Ajustar as permissões do arquivo de log
            chmod(self::$logFilePath, 0664);
        }

        // Configurar o error_log do PHP
        ini_set('error_log', self::$logFilePath);
        ini_set('log_errors', '1');
        ini_set('display_errors', '1'); // Para exibir erros na tela durante a depuração
        error_reporting(E_ALL);

        // Handlers personalizados
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleError($errno, $errstr, $errfile, $errline) {
        $message = "[" . date('Y-m-d H:i:s') . "] Erro: {$errstr} em {$errfile} na linha {$errline}\n";
        error_log($message, 3, self::$logFilePath);
        echo nl2br(htmlspecialchars($message));
    }

    public static function handleException($exception) {
        $message = "[" . date('Y-m-d H:i:s') . "] Exceção não tratada: " . $exception->getMessage() . " em " . $exception->getFile() . " na linha " . $exception->getLine() . "\n";
        error_log($message, 3, self::$logFilePath);
        echo nl2br(htmlspecialchars($message));
        exit(1);
    }

    public static function handleShutdown() {
        $error = error_get_last();
        if ($error !== NULL) {
            $message = "[" . date('Y-m-d H:i:s') . "] Erro Fatal: {$error['message']} em {$error['file']} na linha {$error['line']}\n";
            error_log($message, 3, self::$logFilePath);
            echo nl2br(htmlspecialchars($message));
        }
    }

    /**
     * Função para registrar mensagens no log.
     * 
     * @param string $message Mensagem a ser registrada.
     */
    public static function log($message) {
        error_log($message, 3, self::$logFilePath);
    }

    /**
     * Função utilitária para imprimir variáveis de forma legível.
     * 
     * @param mixed $var Variável a ser inspecionada.
     * @param bool $die Se verdadeiro, encerra o script após a exibição.
     */
    public static function dump($var, $die = false) {
        echo '<pre style="background-color:#f4f4f4; padding:10px; border:1px solid #ccc; overflow:auto;">';
        var_dump($var);
        echo '</pre>';
        if ($die) {
            exit;
        }
    }

    /**
     * Função utilitária para imprimir variáveis de forma amigável.
     * 
     * @param mixed $var Variável a ser inspecionada.
     * @param bool $die Se verdadeiro, encerra o script após a exibição.
     */
    public static function print_r_pre($var, $die = false) {
        echo '<pre style="background-color:#f4f4f4; padding:10px; border:1px solid #ccc; overflow:auto;">';
        print_r($var);
        echo '</pre>';
        if ($die) {
            exit;
        }
    }

    /**
     * Função utilitária para rastrear o tempo de execução do script.
     * 
     * @param string $label Rótulo para o marcador de tempo.
     */
    public static function timer($label = 'Time') {
        static $timers = [];
        $currentTime = microtime(true);
        if (!isset($timers[$label])) {
            $timers[$label] = $currentTime;
            echo "<div style='background-color:#e7f3fe; padding:5px; margin:5px 0;'>Timer '{$label}' started at {$currentTime}.</div>";
        } else {
            $elapsed = $currentTime - $timers[$label];
            echo "<div style='background-color:#e7f3fe; padding:5px; margin:5px 0;'>Timer '{$label}' elapsed time: {$elapsed} seconds.</div>";
            unset($timers[$label]);
        }
    }

    /**
     * Função utilitária para rastrear o uso de memória.
     */
    public static function memoryUsage() {
        $memory = memory_get_usage(true);
        $formattedMemory = self::formatBytes($memory);
        echo "<div style='background-color:#fff3cd; padding:5px; margin:5px 0;'>Current memory usage: {$formattedMemory}.</div>";
    }

    /**
     * Formata bytes em unidades legíveis.
     * 
     * @param int $bytes Número de bytes.
     * @return string String formatada.
     */
    private static function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), 2) . ' ' . $units[$power];
    }
}

