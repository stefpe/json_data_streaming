<?php
$file = new SplFileObject(__DIR__ . "/../data.csv");
$output = __DIR__ . "/../test.json";

$keys = array_map("strtolower", $file->fgetcsv());
$data = [];
while($row = $file->fgetcsv()){
    if ($row[0] === null) continue;
    $data[] = array_combine($keys, $row);
}
try {
    file_put_contents($output, json_encode($data, JSON_THROW_ON_ERROR));
}catch (Throwable $throwable){
    printf("issue during json encode");
}

printf(
    "peak: %d MB",
    memory_get_peak_usage(true)/1024/1024
);
