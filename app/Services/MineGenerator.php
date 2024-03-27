<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Mining;
use App\Models\Company;

class MineGenerator
{
    protected const UNITS = ['kg', 'g'];

    public function generate(): void
    {
        Mining::truncate();

        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $companies = Company::all();
            foreach ($companies as $company) {
                $miningsCount = rand(0, 10);
                for ($i = 0; $i < $miningsCount; $i++) {
                    $weight = rand(1, 200);

                    $unit = self::UNITS[array_rand(self::UNITS)];

                    Mining::create([
                        'company_id' => $company->id,
                        'mine_date_time' => $currentDate->toDateTimeString(),
                        'value' => $weight,
                        'unit' => $unit,
                    ]);
                }
            }

            $currentDate->addDay();
        }
    }
}
