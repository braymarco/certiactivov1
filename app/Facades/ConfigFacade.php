<?php


namespace App\Facades;


use App\Exceptions\ConfigException;
use App\Models\Config;

class ConfigFacade
{

    /**
     * @throws ConfigException
     */
    public static function get($key, $default = null)
    {
        $cfg = \App\Models\Config::where('key', $key)->first();
        if ($cfg === null && $default === null)
            throw new ConfigException("Config no encontrada");
        if ($cfg === null)
            return $default;
        return $cfg->value;
    }

    /**
     * @throws \Exception
     */
    public static function set($key, $value)
    {
        $cfg = \App\Models\Config::where('key', $key)->first();
        if ($cfg === null) {
            Config::create([
                'key' => $key,
                'value' => $value
            ]);
        } else {
            $cfg->value = $value;
            $cfg->save();
        }
        return $cfg;
    }
}
