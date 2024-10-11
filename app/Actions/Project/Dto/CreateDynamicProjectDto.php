<?php

namespace App\Actions\Project\Dto;

use App\Enums\TitleKeysEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CreateDynamicProjectDto
{
    public function __construct(
        private int $type_id,
        private string $title,
        private string $date_created,
        private string $is_chain,
        private int $worker_count,
        private bool $has_outsource,
        private string $has_investors,
        private ?string $date_deadline,
        private ?bool $is_on_time,
        private string $date_contract,
        private int $service_count,
        private string $comment,
        private float $efficiency,
        private ?string $json_payments,
    )
    {
    }

    private static function getBool(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return Str::lower($value) === 'да' ? '1' : '0';
    }
    private static function getDate(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return Date::excelToDateTimeObject($value)->format('Y-m-d');
    }

    public static function fromCollection(Collection $collection): self
    {
        return new self(
            // string, integer, float, array
            type_id: $collection->get(TitleKeysEnum::TYPE_ID->excellNumericKey()),
            title: $collection->get(TitleKeysEnum::TITLE->excellNumericKey()),
            worker_count: $collection->get(TitleKeysEnum::WORKER_COUNT->excellNumericKey()),
            service_count: $collection->get(TitleKeysEnum::SERVICE_COUNT->excellNumericKey()),
            comment: $collection->get(TitleKeysEnum::COMMENT->excellNumericKey()),
            efficiency: $collection->get(TitleKeysEnum::EFFICIENCY->excellNumericKey()),
            json_payments: $collection->get(TitleKeysEnum::JSON_PAYMENTS->value),
            // date
            date_contract: self::getDate($collection->get(TitleKeysEnum::DATE_CONTRACT->excellNumericKey()),),
            date_created: self::getDate($collection->get(TitleKeysEnum::DATE_CREATED->excellNumericKey()),),
            date_deadline: self::getDate($collection->get(TitleKeysEnum::DATE_DEADLINE->excellNumericKey()),),
            // bool
            is_chain: self::getBool($collection->get(TitleKeysEnum::IS_CHAIN->excellNumericKey()),),
            has_outsource: self::getBool($collection->get(TitleKeysEnum::HAS_OUTSOURCE->excellNumericKey()),),
            has_investors: self::getBool($collection->get(TitleKeysEnum::HAS_INVESTORS->excellNumericKey()),),
            is_on_time: self::getBool($collection->get(TitleKeysEnum::IS_ON_TIME->excellNumericKey()),),
        );
    }


    public function toArray() {
        return [
            'type_id' => $this->getTypeId(),
            'title' => $this->getTitle(),
            'date_created' => $this->getDateCreated(),
            'is_chain' => $this->getIsChain(),
            'worker_count' => $this->getWorkerCount(),
            'has_outsource' => $this->getHasOutsource(),
            'has_investors' => $this->getHasInvestors(),
            'date_deadline' => $this->getDateDeadline(),
            'is_on_time' => $this->getIsOnTime(),
            'payments' => $this->getJsonPayments(),
            'date_contract' => $this->getDateContract(),
            'service_count' => $this->getServiceCount(),
            'comment' => $this->getComment(),
            'efficiency' => $this->getEfficiency(),
            'json_payments' => $this->getJsonPayments(),
        ];
    }


    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function getDateCreated(): string
    {
        return $this->date_created;
    }

    public function getIsChain(): string
    {
        return $this->is_chain;
    }

    public function getWorkerCount(): int
    {
        return $this->worker_count;
    }

    public function getHasOutsource(): bool
    {
        return $this->has_outsource;
    }

    public function getHasInvestors(): string
    {
        return $this->has_investors;
    }

    public function getDateDeadline(): ?string
    {
        return $this->date_deadline;
    }

    public function getIsOnTime(): ?bool
    {
        return $this->is_on_time;
    }


    public function getDateContract(): string
    {
        return $this->date_contract;
    }

    public function getServiceCount(): int
    {
        return $this->service_count;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getEfficiency(): float
    {
        return $this->efficiency;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getJsonPayments(): ?string
    {
        return $this->json_payments;
    }
}
