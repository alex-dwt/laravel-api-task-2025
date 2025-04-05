<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InvestmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('campaigns', CampaignController::class)->only(['index', 'show']);

Route::apiResource('investments', InvestmentController::class)->only(['store']);
