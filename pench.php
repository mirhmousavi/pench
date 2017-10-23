<?php
class Pench
{
    static $start_time;
    static $start_memory;
    static $start_peak_memory;

    static $end_time;
    static $end_memory;
    static $end_peak_memory;

    public static function start()
    {
        self::$start_time = self::$start_memory = self::$end_time = self::$end_memory = 0;

        self::$start_time        = microtime(true);
        self::$start_memory      = memory_get_usage(false);
        self::$start_peak_memory = memory_get_peak_usage(false);

    }
    public static function end()
    {
        self::$end_time        = microtime(true);
        self::$end_memory      = memory_get_usage(false);
        self::$end_peak_memory = memory_get_peak_usage(false);

        self::$stats = self::stats();
        return self::$stats;
    }
    public static function stats()
    {
        if (self::$start_time == 0 or self::$end_time == 0) {
            self::end();
        }
        if (self::$start_time == 0) {
            throw new Exception('use Pench::start() first!');
        }
        $result                 = [];
        $result['time_elapsed'] = self::$end_time - self::$start_time . ' S';
        $result['memory_usage'] = ((self::$end_memory - self::$start_memory) / 1024 / 1024) . ' KB';

        if (self::$end_peak_memory > self::$start_peak_memory) {
            $result['peak_memory_usage'] = self::$end_peak_memory - self::$start_peak_memory;
        } else {
            $result['peak_memory_usage'] = self::$end_peak_memory;
        };
        $result['peak_memory_usage'] = ($result['peak_memory_usage'] / 1024 / 1024) . ' KB';

        return $result;
    }

    public static function dump($label)
    {
        if (empty(self::$stats)) {
            self::stats();
        }

        $report = self::$stats;
        if ($label) {
            $l[$label] = $report;
        } else {
            $l = $report;
        }
        var_dump($l);
    }
}
