<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReportsService
{
    public function getLeaderData($month): Collection
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $year = ($month <= $currentMonth) ? $currentYear : ($currentYear - 1);

        $results = DB::table('countries')
            ->join('companies', 'countries.id', '=', 'companies.country_id')
            ->join('minings', 'companies.id', '=', 'minings.company_id')
            ->select('countries.name as country', 'countries.plan', 'countries.unit as plan_unit', DB::raw('SUM(IF(minings.unit = "t", minings.value * 1000000, IF(minings.unit = "kg", minings.value * 1000, minings.value))) AS total_weight'))
            ->groupBy('countries.name', 'countries.plan', 'countries.unit')
            ->havingRaw('total_weight > IF(countries.unit = "t", countries.plan * 1000000, IF(countries.unit = "kg", countries.plan * 1000, countries.plan))')
            ->whereYear('minings.mine_date_time', $year)
            ->whereMonth('minings.mine_date_time', $month)
            ->get();

        $results->transform(function ($item, $key) {
            if ($item->total_weight >= 1000000) {
                $item->total_weight = round($item->total_weight / 1000000, 2);
                $item->unit = 't';
            } elseif ($item->total_weight >= 1000) {
                $item->total_weight = round($item->total_weight / 1000, 2);
                $item->unit = 'kg';
            } else {
                $item->unit = 'g';
            }

            return $item;
        });

        return $results;
    }
}
