<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'country' => $this->country,
            'plan' => $this->plan,
            'plan_unit' => $this->plan_unit,
            'total_weight' => $this->total_weight,
            'unit' => $this->unit,
        ];
    }
}
