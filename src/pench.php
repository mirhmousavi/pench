<?php
class Pench
{
    static $start_time;
    static $start_memory;
    static $start_peak_memory;

    static $end_time;
    static $end_memory;
    static $end_peak_memory;

    static $report = [];

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

        return self::benchmark();
    }

    public static function benchmark()
    {
        if (self::$end_time == 0) {
            return self::end();
        }
        if (!empty(self::$report)) {
            return self::$report;
        }

        if (self::$start_time == 0) {
            throw new Exception('use Pench::start() first!');
        }
        $result                 = [];
        $result['time_elapsed'] = self::calcuate_time_with_unit(self::$end_time - self::$start_time);
        $result['memory_usage'] = self::calcuate_memory_with_unit(self::$end_memory - self::$start_memory);

        if (self::$end_peak_memory > self::$start_peak_memory) {
            $result['peak_memory_usage'] = self::$end_peak_memory - self::$start_peak_memory;
        } else {
            $result['peak_memory_usage'] = self::$end_peak_memory;
        };
        $result['peak_memory_usage'] = self::calcuate_memory_with_unit($result['peak_memory_usage']);
        self::$report                = $result;
        self::$end_time              = 0; //reset benchmark
        return self::$report;
    }

    public static function dump($label = false)
    {
        if (empty(self::$report)) {
            $report = self::end();
        }
        if ($label) {
            $l[$label] = $report;
        } else {
            $l = $report;
        }
        var_dump($l);
    }

    private static function calcuate_memory_with_unit($input)
    {
        if ($input < 1024) {
            return ($input) . ' B';
        } elseif ($input > 1024 and $input < 1048576) {
            return ($input / 1024) . ' KB';
        } else {
            return ($input / 1024 / 1024) . ' MB';
        }

    }
    private static function calcuate_time_with_unit($input)
    {
        if ($input < 300) {
            return $input . ' Sec';
        } else {
            return ($input / 60) . ' Min';
        }

    }
}
