<?php

use App\Jobs\SendDailyCommissionReport;
use App\Jobs\SendSalesAdminReport;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SendDailyCommissionReport)->dailyAt('23:00');

Schedule::job(new SendSalesAdminReport)->dailyAt('23:00');

