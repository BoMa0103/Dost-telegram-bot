<?php

namespace App\Services\Dots\DTO;

abstract class DotsDTO
{
    const DELIVERY_TO_DOOR = 0;
    const DELIVERY_TO_FLAT = 1;
    const DELIVERY_PICKUP = 2;
    const DELIVERY_PRE_ORDER = 3;
    const DELIVERY_TIME_FASTEST = 0;
    const PAYMENT_CASH = 1;
    const PAYMENT_ONLINE = 1;
    const PAYMENT_TERMINAL = 3;
    const TYPE_ORDERED_ONLINE = 1;
    const TYPE_ORDERED_BY_OPERATOR = 2;
    const TYPE_ORDERED_BY_COMPANY = 3;
    const TYPE_ORDERED_BY_IOS_APP = 4;
    const TYPE_ORDERED_BY_ANDROID_APP = 5;
    const TYPE_ORDERED_BY_API = 6;
}
