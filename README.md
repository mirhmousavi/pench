# pench
<h2>Another PHP benchmark system</h2>
pench API is damn simple, see example below:

```php
require 'pench.php';
$haystack = rang(1,1000000);

Pench::start();
foreach($haystack as $value) {
  echo $value;
}
$report['foreach']=Pench::end();
var_dump($report);
```
will output
```php
array (size=1)
  'foreach' => 
    array (size=3)
      'time_elapsed' => string '24.709722042084 Sec' (length=19)
      'memory_usage' => string '112 Byte' (length=8)
      'peak_memory_usage' => string '176 Byte' (length=8)
```   
also you can use dump function to print the report and it's not necessary to call end() because dump itself will call it, it's possible to pass a label to dump() so it's obvious which result belong to what part of the program
```php
require 'pench.php';
Pench::start();
$haystack = rang(1,1000000);
array_walk($haystack,function($value){
  echo $value;
});
Pench::dump('array_walk');
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
      
