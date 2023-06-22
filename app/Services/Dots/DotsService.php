<?php

namespace App\Services\Dots;

use App\Services\Dots\Providers\DotsProvider;
use App\Services\Dots\Resolvers\DishByIdResolver;

class DotsService
{

    public function __construct(
        private readonly DotsProvider $dotsProvider,
        private readonly DishByIdResolver $dishByIdResolver
    ) {
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function findDishById(string $id, string $companyId): ?array
    {
        return $this->dishByIdResolver->resolve($id, $companyId);
    }

    /**
     * @return array
     */
    public function getCities(): array
    {
        return $this->dotsProvider->getCityList();
    }

    /**
     * @return array
     */
    public function getCompanies(string $cityId): array
    {
        return $this->dotsProvider->getCompanyList($cityId);
    }

    /**
     * @return array
     */
    public function getCompanyInfo(string $companyId): array
    {
        return $this->dotsProvider->getCompanyInfo($companyId);
    }

    /**
     * @return array
     */
    public function getOrderInfo(string $orderId): array
    {
        return $this->dotsProvider->getOrderInfo($orderId);
    }

    /**
     * @return array
     */
    public function getDishes(string $companyId): array
    {
        return $this->dotsProvider->getMenuList($companyId);
    }

    /**
     * @return array
     */
    public function getOnlinePaymentData(string $orderId): array
    {
        return $this->dotsProvider->getOnlinePaymentData($orderId);
    }

    /**
     * @param array $data
     * @return array
     */
    public function makeOrder(array $data): array
    {
        return $this->dotsProvider->makeOrder($data);
    }

}
