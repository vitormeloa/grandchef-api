<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case OPEN = 'open';
    case APPROVED = 'approved';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
