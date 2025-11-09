#!/bin/bash

# Путь к проекту
PROJECT_PATH="/var/www/istokiya_rf_usr/data/www/xn--h1aafpog8g.xn--p1ai"

# Переходим в директорию проекта
cd $PROJECT_PATH

# Проверяем, запущен ли уже worker
if ! pgrep -f "queue:work" > /dev/null; then
    echo "$(date): Starting queue worker"
    nohup php artisan queue:work --sleep=3 --tries=3 --timeout=90 --max-time=1800 --max-jobs=50 >> storage/logs/queue-worker.log 2>&1 &
else
    # Проверяем, как долго работает процесс (если больше 30 минут - перезапускаем)
    pid=$(pgrep -f "queue:work")
    runtime=$(ps -o etimes= -p "$pid" 2>/dev/null | tr -d ' ')
    
    if [ ! -z "$runtime" ] && [ "$runtime" -gt 1800 ]; then
        echo "$(date): Restarting queue worker (runtime: ${runtime}s)"
        pkill -f "queue:work"
        nohup php artisan queue:work --sleep=3 --tries=3 --timeout=90 --max-time=1800 --max-jobs=50 >> storage/logs/queue-worker.log 2>&1 &
    else
        echo "$(date): Queue worker is running (runtime: ${runtime}s)"
    fi
fi