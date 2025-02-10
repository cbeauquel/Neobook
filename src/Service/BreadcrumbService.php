<?php

namespace App\Service;

class BreadcrumbService
{
    private array $breadcrumbs = [];
    /**
     * Reçoit un label et une url et les met dans un tableau pour contstruire le fil d'ariane
     */
    public function add(string $label, ?string $url = null): void
    {
        $this->breadcrumbs[] = ['label' => $label, 'url' => $url];
    }
    /**
     * return array récupère le fil d'ariane sous forme de tableau
     */
    public function get(): array
    {
        return $this->breadcrumbs;
    }
}