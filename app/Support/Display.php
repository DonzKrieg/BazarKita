<?php

namespace App\Support;

use Carbon\CarbonImmutable;

final class Display
{
    public static function rupiah(?int $amount): string
    {
        return $amount === null ? 'Belum ada informasi' : 'Rp'.number_format($amount, 0, ',', '.');
    }

    public static function wib(?string $timestamp): string
    {
        return $timestamp === null
            ? 'Belum ada informasi'
            : CarbonImmutable::parse($timestamp)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y, H.i').' WIB';
    }
}
