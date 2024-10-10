<?php

namespace App\Enums;

enum TaskStatusesEnum: int
{
    case NEW = 1;
    case SUCCESS = 2;
    case WITH_FAILED_ROWS = 3;
    case FAIL = 4;

    public function description(): string
    {
        return match ($this) {
            self::NEW => 'Новый',
            self::SUCCESS => 'Успешно загружен',
            self::WITH_FAILED_ROWS => 'Обработан с ошибками',
            self::FAIL => 'Не был загружен',
        };
    }
}
