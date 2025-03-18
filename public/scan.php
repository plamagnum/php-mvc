<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Налаштування
$startDir = __DIR__;  // Директорія для сканування

// Сканування PHP файлів
$phpFiles = scanPhpFiles($startDir);

if (empty($phpFiles)) {
    die("Не знайдено PHP файлів");
}

// Побудова графа
$graph = buildGraph($phpFiles);

// Генерація та відображення результату
visualizeGraph($graph);

// Функції
function scanPhpFiles($dir) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    
    $files = [];
    foreach ($iterator as $file) {
        if ($file->isFile() && 'php' === $file->getExtension()) {
            $files[] = $file->getRealPath();
        }
    }
    return $files;
}

function buildGraph($files) {
    $graph = [];
    foreach ($files as $file) {
        $dependencies = findDependencies($file, $files);
        $graph[basename($file)] = [
            'path' => $file,
            'deps' => $dependencies
        ];
    }
    return $graph;
}

function findDependencies($filePath, $allFiles) {
    $content = file_get_contents($filePath);
    $pattern = '/(?:include|require|include_once|require_once)\s*\((?:[\'"])(.+?\.php)(?:[\'"])\)/';
    preg_match_all($pattern, $content, $matches);
    
    $deps = [];
    foreach ($matches[1] as $match) {
        $absPath = realpath(dirname($filePath).DIRECTORY_SEPARATOR.$match);
        if (in_array($absPath, $allFiles)) {
            $deps[] = basename($absPath);
        }
    }
    return array_unique($deps);
}

function visualizeGraph($graph) {
    $nodes = [];
    $edges = [];
    
    foreach ($graph as $file => $data) {
        $nodes[] = "'$file' [label=\"$file\"]";
        foreach ($data['deps'] as $dep) {
            if (isset($graph[$dep])) {
                $edges[] = "'$file' -> '$dep'";
            }
        }
    }
    
    // Генерація DOT-коду
    $dot = "digraph G {\n";
    $dot .= "    node [shape=box, style=rounded, fontname=\"Arial\"];\n";
    $dot .= "    " . implode(";\n    ", $nodes) . ";\n";
    $dot .= "    " . implode(";\n    ", $edges) . ";\n";
    $dot .= "}";
    
    // Візуалізація через Graphviz
    header('Content-Type: image/svg+xml');
    $proc = proc_open('dot -Tsvg', [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ], $pipes);
    
    fwrite($pipes[0], $dot);
    fclose($pipes[0]);
    
    echo stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
}
?>
