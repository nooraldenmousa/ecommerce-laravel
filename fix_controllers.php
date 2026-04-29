<?php
$dirs = [
    'app/Http/Controllers/Block5',
    'app/Http/Controllers/Block3',
    'app/Http/Controllers/Block4',
];

foreach ($dirs as $dir) {
    $files = glob($dir . '/*.php');
    foreach ($files as $f) {
        $c = file_get_contents($f);
        if (strpos($c, 'use App\Http\Controllers\Controller') === false && strpos($c, 'extends Controller') !== false) {
            $c = str_replace(
                'use Illuminate\Http\Request;',
                "use Illuminate\Http\Request;\nuse App\Http\Controllers\Controller;",
                $c
            );
            file_put_contents($f, $c);
            echo 'Fixed: ' . $f . PHP_EOL;
        }
    }
}
echo 'Done!' . PHP_EOL;
