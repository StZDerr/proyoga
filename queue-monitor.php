<?php

// Скрипт для мониторинга очередей
// Использование: php queue-monitor.php

$projectPath = __DIR__;
$logFile = $projectPath . '/storage/logs/queue-monitor.log';

function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
    echo "[$timestamp] $message" . PHP_EOL;
}

function isQueueWorkerRunning() {
    // Для Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $output = shell_exec('tasklist /FI "IMAGENAME eq php.exe" /FO CSV');
        return strpos($output, 'queue:work') !== false;
    }
    // Для Linux/Unix
    else {
        $output = shell_exec('pgrep -f "queue:work"');
        return !empty(trim($output));
    }
}

function startQueueWorker() {
    global $projectPath;
    
    writeLog("Запуск обработчика очередей...");
    
    // Для Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $command = "cd /d \"$projectPath\" && start /B php artisan queue:work --sleep=3 --tries=3 --timeout=60 > storage/logs/queue-worker.log 2>&1";
        pclose(popen($command, 'r'));
    }
    // Для Linux/Unix
    else {
        $command = "cd $projectPath && nohup php artisan queue:work --sleep=3 --tries=3 --timeout=60 > storage/logs/queue-worker.log 2>&1 &";
        shell_exec($command);
    }
    
    writeLog("Обработчик очередей запущен");
}

// Основная логика
writeLog("Проверка статуса обработчика очередей...");

if (isQueueWorkerRunning()) {
    writeLog("Обработчик очередей уже работает");
} else {
    writeLog("Обработчик очередей не найден");
    startQueueWorker();
}

// Проверка количества задач в очереди
try {
    $dbPath = $projectPath . '/.env';
    if (file_exists($dbPath)) {
        // Подключаемся к базе данных для проверки очереди
        $env = file_get_contents($dbPath);
        preg_match('/DB_DATABASE=(.*)/', $env, $matches);
        $database = trim($matches[1] ?? 'proyoga');
        
        preg_match('/DB_USERNAME=(.*)/', $env, $matches);
        $username = trim($matches[1] ?? 'root');
        
        preg_match('/DB_PASSWORD=(.*)/', $env, $matches);
        $password = trim($matches[1] ?? '');
        
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=$database", $username, $password);
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM jobs WHERE attempts = 0");
        $pendingJobs = $stmt->fetch()['count'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM failed_jobs");
        $failedJobs = $stmt->fetch()['count'];
        
        writeLog("Задач в очереди: $pendingJobs | Неудачных: $failedJobs");
    }
} catch (Exception $e) {
    writeLog("Ошибка при проверке базы данных: " . $e->getMessage());
}

writeLog("Проверка завершена");