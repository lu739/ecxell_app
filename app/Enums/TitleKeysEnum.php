<?php

namespace App\Enums;

enum TitleKeysEnum: string
{
    case TYPE_ID = 'type_id';
    case TITLE = 'title';
    case DATE_CREATED = 'date_created';
    case IS_CHAIN = 'is_chain';
    case WORKER_COUNT = 'worker_count';
    case HAS_OUTSOURCE = 'has_outsource';
    case HAS_INVESTORS = 'has_investors';
    case DATE_DEADLINE = 'date_deadline';
    case IS_ON_TIME = 'is_on_time';
    case PAYMENT_FIRST_STEP = 'payment_first_step';
    case PAYMENT_SECOND_STEP = 'payment_second_step';
    case PAYMENT_THIRD_STEP = 'payment_third_step';
    case PAYMENT_FOURTH_STEP = 'payment_fourth_step';
    case DATE_CONTRACT = 'date_contract';
    case SERVICE_COUNT = 'service_count';
    case COMMENT = 'comment';
    case EFFICIENCY = 'efficiency';

    public function excellKeys(): string
    {
        return match ($this) {
            self::TYPE_ID => 'tip',
            self::TITLE => 'naimenovanie',
            self::DATE_CREATED => 'data_sozdaniia',
            self::IS_CHAIN => 'setevik',
            self::WORKER_COUNT => 'kolicestvo_ucastnikov',
            self::HAS_OUTSOURCE => 'nalicie_autsorsinga',
            self::HAS_INVESTORS => 'nalicie_investorov',
            self::DATE_DEADLINE => 'dedlain',
            self::IS_ON_TIME => 'sdaca_v_srok',
            self::PAYMENT_FIRST_STEP => 'vlozenie_v_pervyi_etap',
            self::PAYMENT_SECOND_STEP => 'vlozenie_vo_vtoroi_etap',
            self::PAYMENT_THIRD_STEP => 'vlozenie_v_tretii_etap',
            self::PAYMENT_FOURTH_STEP => 'vlozenie_v_cetvertyi_etap',
            self::DATE_CONTRACT => 'podpisanie_dogovora',
            self::SERVICE_COUNT => 'kolicestvo_uslug',
            self::COMMENT => 'kommentarii',
            self::EFFICIENCY => 'znacenie_effektivnosti',
        };
    }

    public static function getEnumKeyFromRussianValue(string $value): ?string {
        foreach (self::cases() as $enumCase) {
            if ($enumCase->excellKeys() === $value) {
                return $enumCase->value;
            }
        }
        return null;
    }
}
