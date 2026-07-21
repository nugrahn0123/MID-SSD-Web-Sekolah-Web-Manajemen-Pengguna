<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('The only way to do great work is to love what you do.');
})->purpose('Display an inspiring quote');