<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StatsExport implements FromArray, ShouldAutoSize
{
    protected $statsData;

    public function __construct(array $statsData)
    {
        $this->statsData = $statsData;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        return $this->statsData;
    }
}