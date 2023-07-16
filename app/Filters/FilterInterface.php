<?php

namespace App\Filters;

interface FilterInterface
{
    /**
     * Apply filters and get sql to db query
     * 
     * @param array $filters
     *
     * @return string
     */
    public function applyFilters(array $filters): string;
}