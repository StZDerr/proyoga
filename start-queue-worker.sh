#!/bin/bash

# Путь к проекту
PROJECT_PATH="/path/to/your/proyoga"

# Переходим в директорию проекта
cd $PROJECT_PATH

# Проверяем, запущен ли уже worker
if ! pgrep -f "queue:work" > /dev/null; then
    echo "$(date): Starting queue worker"
    nohup php artisan queue:work --sleep=3 --tries=3 --max-time=3600 >> storage/logs/queue-worker.log 2>&1 &
else
    echo "$(date): Queue worker is already running"
fi