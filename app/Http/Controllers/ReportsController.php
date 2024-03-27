<?php

namespace App\Http\Controllers;

use App\Services\MineGenerator;
use Illuminate\Http\JsonResponse;
use App\Services\ReportsService;
use App\Http\Resources\LeaderResource;

class ReportsController extends Controller
{
    public function generateMining(): JsonResponse
    {
        (new MineGenerator())->generate();

        return response()->json(['success' => true]);
    }

    public function generateReport(int $month): JsonResponse
    {
        $leadersData = (new ReportsService())->getLeaderData($month);

        return LeaderResource::collection($leadersData)->response();
    }
}
