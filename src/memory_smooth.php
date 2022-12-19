<?php
$file = new SplFileObject(__DIR__ . "/../data.csv");
$output = new SplFileObject(__DIR__ . "/../test.json", "w+");

$keys = array_map("strtolower", $file->fgetcsv());
$output->fwrite("[");
$first = true;
while($row = $file->fgetcsv()){
    if ($row[0] === null) continue;
    $prefix = ($first === true)? "" : ",";
    try {
        $output->fwrite($prefix . json_encode(array_combine($keys, $row), JSON_THROW_ON_ERROR));
    }catch(Throwable $throwable){
        continue;
    }
    $first = false;
}
$output->fwrite("]");

printf(
    "peak: %d MB",
    memory_get_peak_usage(true)/1024/1024
);