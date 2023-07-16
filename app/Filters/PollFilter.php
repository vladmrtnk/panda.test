<?php

namespace App\Filters;

class PollFilter implements FilterInterface
{
    private array $availableFieldsForSorting = ['title', 'published', 'created_at'];

    /**
     * @param array $filters
     *
     * @return string
     */
    public function applyFilters(array $filters): string
    {
        $sql = "";

        foreach ($filters as $filterName => $filter) {
            switch ($filterName) {
                case ('sort_by'):
                    if (in_array($filter, $this->availableFieldsForSorting)) {
                        $sql .= "ORDER BY $filter ";
                    }
                    break;
                case ('sort_order'):
                    if ($sql != '') {
                        if ($filter == 'asc') {
                            $sql .= "ASC";
                        } elseif ($filter == 'desc') {
                            $sql .= "DESC";
                        }
                    }

                    break;
            }
        }

        return $sql;
    }
}