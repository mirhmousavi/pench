# pench
## Another PHP benchmark system
**This library benchmark php applications and show time_elapsed,memory_usage and memory_peak_usage, but you should consider there is no way to get precise amount of memory consumed by the application because there is no way for php to report it, the memory_get_usage(false) just report the memory that is allocated not actually using by the application but it's near the real memory usage by the application.**<br>

Install pench via composer
```
composer require hosseinmousavi/pench:dev-master
```
Then include composer autoload file
```php
require 'vendor/autoload.php';
```
Or just include it
```
require 'src/pench.php';
```
pench API is damn simple, see example below

```php
require 'pench.php';
$haystack = rang(1,1000000);

pench::start();
foreach($haystack as $value) {
  echo $value;
}
$report['foreach']=pench::end();
var_dump($report);
```
Will output
```php
array (size=1)
  'foreach' => 
    array (size=3)
      'time_elapsed' => string '24.709722042084 Sec' (length=19)
      'memory_usage' => string '112 Byte' (length=8)
      'peak_memory_usage' => string '176 Byte' (length=8)
```   
Also you can use dump() to print the report and it's not necessary to call end() because dump itself will call it, it's possible to pass a label to dump() so it'll be clear which result belongs to what part of the program.
```php
require 'pench.php';
pench::start();
$haystack = rang(1,1000000);
array_walk($haystack,function($value){
  echo $value;
});
pench::dump('array_walk');
```
will ouput
```php
array (size=1)
  'array_walk' => 
    array (size=3)
      'time_elapsed' => string '0.11225986480713 Sec' (length=20)
      'memory_usage' => string '152 Byte' (length=8)
      'peak_memory_usage' => string '176 Byte' (length=8)
```
For benchmarking multiple parts you should call pench::start() every time.
```php
pench::start();
foreach($haystack as $value) {
  echo $value;
}
$report['foreach']=pench::end();//or pench::dump('array_foreach') or pench::dump() to print report inline
pench::start();
array_walk($haystack,function($value){
  echo $value;
});

$report['array_walk']=pench::end();//or pench::dump('array_walk') to print report inline
```