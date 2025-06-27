<?php

namespace App\Helpers;

class NetworkHelper
{
    public static function getPingToInternet($dnsTarget)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec("ping -n 1 $dnsTarget", $output);
            $joined = implode("\n", $output);

            // Tangkap nilai Average = <1ms atau 2ms
            if (preg_match('/Average = (<)?(\d+)?ms/', $joined, $matches)) {
                return ($matches[1] === '<') ? 1 : (int) ($matches[2] ?? 0);
            } else {
                return null;
            }
        } else {
            $output = shell_exec("ping -c 1 $dnsTarget | grep 'time='");
            preg_match('/time=([\d.]+)\s*ms/', $output, $matches);
            return isset($matches[1]) ? (float)$matches[1] : null;
        }
    }
}
