<?php

namespace App\Actions\Project\Dto;

use App\Enums\TitleKeysEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CreateProjectDto
{
    public function __construct(
        private string $type_id,
        private string $title,
        private string $date_created,
        private string $is_chain,
        private int $worker_count,
        private bool $has_outsource,
        private string $has_investors,
        private ?string $date_deadline,
        private ?bool $is_on_time,
        private int $payment_first_step,
        private int $payment_second_step,
        private int $payment_third_step,
        private int $payment_fourth_step,
        private string $date_contract,
        private int $service_count,
        private string $comment,
        private float $efficiency,
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
            // string, integer, float
            type_id: $collection->get(TitleKeysEnum::TYPE_ID->excellKeys()),
            title: $collection->get(TitleKeysEnum::TITLE->excellKeys()),
            worker_count: $collection->get(TitleKeysEnum::WORKER_COUNT->excellKeys()),
            payment_first_step: $collection->get(TitleKeysEnum::PAYMENT_FIRST_STEP->excellKeys()),
            payment_second_step: $collection->get(TitleKeysEnum::PAYMENT_SECOND_STEP->excellKeys()),
            payment_third_step: $collection->get(TitleKeysEnum::PAYMENT_THIRD_STEP->excellKeys()),
            payment_fourth_step: $collection->get(TitleKeysEnum::PAYMENT_FOURTH_STEP->excellKeys()),
            service_count: $collection->get(TitleKeysEnum::SERVICE_COUNT->excellKeys()),
            comment: $collection->get(TitleKeysEnum::COMMENT->excellKeys()),
            efficiency: $collection->get(TitleKeysEnum::EFFICIENCY->excellKeys()),
            // date
            date_contract: self::getDate($collection->get(TitleKeysEnum::DATE_CONTRACT->excellKeys()),),
            date_created: self::getDate($collection->get(TitleKeysEnum::DATE_CREATED->excellKeys()),),
            date_deadline: self::getDate($collection->get(TitleKeysEnum::DATE_DEADLINE->excellKeys()),),
            // bool
            is_chain: self::getBool($collection->get(TitleKeysEnum::IS_CHAIN->excellKeys()),),
            has_outsource: self::getBool($collection->get(TitleKeysEnum::HAS_OUTSOURCE->excellKeys()),),
            has_investors: self::getBool($collection->get(TitleKeysEnum::HAS_INVESTORS->excellKeys()),),
            is_on_time: self::getBool($collection->get(TitleKeysEnum::IS_ON_TIME->excellKeys()),),
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
            'payment_first_step' => $this->getPaymentFirstStep(),
            'payment_second_step' => $this->getPaymentSecondStep(),
            'payment_third_step' => $this->getPaymentThirdStep(),
            'payment_fourth_step' => $this->getPaymentFourthStep(),
            'date_contract' => $this->getDateContract(),
            'service_count' => $this->getServiceCount(),
            'comment' => $this->getComment(),
            'efficiency' => $this->getEfficiency(),
        ];
    }


    public function getTypeId(): string
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

    public function getPaymentFirstStep(): int
    {
        return $this->payment_first_step;
    }

    public function getPaymentSecondStep(): int
    {
        return $this->payment_second_step;
    }

    public function getPaymentThirdStep(): int
    {
        return $this->payment_third_step;
    }

    public function getPaymentFourthStep(): int
    {
        return $this->payment_fourth_step;
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
}
