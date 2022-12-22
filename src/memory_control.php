<?php
$file = new SplFileObject(__DIR__ . "/../data.csv");
$byteLimit = 5 * 1024 * 1024;//memory limit in mb
$output = new SplFileObject("php://temp/maxmemory:$byteLimit", "w+");

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