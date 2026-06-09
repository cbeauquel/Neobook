<?php

namespace App\Service;

use App\Entity\Format;
use App\Entity\Sale;

class PriceCalculatorService
{
    /**
     * Retourne le prix HT applicable (remisé si promo active, sinon prix normal)
     */
    public function getCurrentPriceHT(Format $format): string|null
    {
        $activeSale = $this->getActiveSale($format);
        
        if ($activeSale) {
            return $activeSale->getReducedPriceHT();
        }
        
        return $format->getPriceHT();
    }

    /**
     * Retourne le prix TTC applicable (remisé si promo active, sinon prix normal)
     */
    public function getCurrentPriceTTC(Format $format): string|null
    {
        $activeSale = $this->getActiveSale($format);
        
        if ($activeSale) {
            return $activeSale->getReducedPriceTTC();
        }
        
        return $format->getPriceTTC();
    }

    /**
     * Vérifie si le format a une promotion active
     */
    public function hasActiveSale(Format $format): bool
    {
        return $this->getActiveSale($format) !== null;
    }

    /**
     * Retourne la promotion active pour ce format, ou null
     */
    public function getActiveSale(Format $format): ?Sale
    {
        $now = new \DateTime();
        
        // Récupère toutes les promotions liées à ce format
        // Note: il faudra ajouter une relation inverse dans l'entité Format
        // ou adapter selon ta structure exacte
        $sales = $format->getSales(); // À adapter selon ton entité
        
        foreach ($sales as $sale) {
            if ($this->isSaleActive($sale, $now)) {
                return $sale;
            }
        }
        
        return null;
    }

    /**
     * Vérifie si une promotion est active à une date donnée
     */
    private function isSaleActive(Sale $sale, \DateTime $date): bool
    {
        $startDate = $sale->getSalesStartDate();
        $endDate = $sale->getSalesEndDate();
        
        // Vérifie que la date est dans l'intervalle [start, end]
        return $date >= $startDate && $date <= $endDate;
    }

    /**
     * Calcule le pourcentage de réduction (utile pour l'affichage)
     */
    public function getDiscountPercentage(Format $format): ?float
    {
        $activeSale = $this->getActiveSale($format);
        
        if (!$activeSale) {
            return null;
        }
        
        $originalPrice = (float) $format->getPriceHT();
        $reducedPrice = (float) $activeSale->getReducedPriceHT();
        
        if ($originalPrice <= 0) {
            return null;
        }
        
        $discount = (($originalPrice - $reducedPrice) / $originalPrice) * 100;
        
        return round($discount, 2);
    }

    /**
     * Retourne le montant économisé en euros
     */
    public function getSavingsAmount(Format $format): ?string
    {
        $activeSale = $this->getActiveSale($format);
        
        if (!$activeSale) {
            return null;
        }
        
        $originalPrice = (float) $format->getPriceHT();
        $reducedPrice = (float) $activeSale->getReducedPriceHT();
        
        $savings = $originalPrice - $reducedPrice;
        
        return number_format($savings, 2, '.', '');
    }
}
