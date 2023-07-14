<?php

namespace App\Services\Users\DTO;

class UserDTO
{
    private function __construct(
        private int     $telegramId,
        private string  $name,
        private ?string $phone,
        private string  $lang,
    )
    {
    }

    public static function fromArray(array $data): UserDTO
    {
        return new self(
            $data['telegram_id'],
            $data['name'],
            $data['phone'],
            $data['lang'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'telegram_id' => $this->getTelegramId(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'lang' => $this->getLang(),
        ];
    }

    /**
     * @return int
     */
    public function getTelegramId(): int
    {
        return $this->telegramId;
    }

    /**
     * @param int $telegramId
     */
    public function setTelegramId(int $telegramId): void
    {
        $this->telegramId = $telegramId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }
}
