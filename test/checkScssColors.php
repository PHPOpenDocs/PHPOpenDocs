<?php

declare(strict_types=1);

$filename = __DIR__ . "/../app/public/scss/colors.scss";

$contents = file_get_contents($filename);

if ($contents === false) {
    echo "Failed to read file: $filename\n";
    exit(-1);
}

function getBlock($contents, int $bracket_offset): string
{
    $lines = explode("\n", $contents);
    $linesToKeep = [];
    $bracket_count = 0;

    foreach ($lines as $line) {

        if (strpos($line, ":root {") !== false) {
            $bracket_count += 1;
        }

        if ($bracket_count === $bracket_offset) {
            $line = trim($line);
            if (strpos($line, "}") === 0) {
                return implode("\n", $linesToKeep);
            }

            $linesToKeep[] = $line;
        }

//        $letters = str_split("", $line);
//
//        foreach ($letters as $letter) {
//
//
//        if ($bracket_count === $bracket_offset) {
//            if ($letter === "}") {
//                return implode("\n", $lettersToKeep);
//            }
//            $lettersToKeep[] = $letter;
//        }
//        else if ($letter === '{') {
//            $bracket_count += 1;
//        }
//

    }

    echo "Failed to find ending } after the $bracket_offset {\n";
    exit(-1);
}

function extract_colors(array $lines)
{
    $colorsFound = [];

    foreach ($lines as $line) {
        $pattern = "#\s*--(?P<name>\w*):\s(?P<value>.*);#iu";
        $matched = preg_match($pattern, $line, $matches);
        if ($matched === 1) {
            $colorsFound[$matches['name']] = $matches['value'];
        }
    }

    return $colorsFound;
}


$light_sccs_block = getBlock($contents, 1);
$dark_sccs_block = getBlock($contents, 2);


$light_lines = explode("\n", $light_sccs_block);
$dark_lines = explode("\n", $dark_sccs_block);

//var_dump($light_lines);

$light_colors = extract_colors($light_lines);
$dark_colors = extract_colors($dark_lines);

$result = 0;

$previous_light_color = null;
foreach ($light_colors as $light_color => $light_color_value) {
    if (array_key_exists($light_color, $dark_colors) !== true) {
        echo "Light color $light_color does not exist in dark colors.\n";
        $result = -1;
    }

    if ($previous_light_color !== null) {
        if (strcmp($previous_light_color, $light_color) > 0) {
            echo "Light color $previous_light_color and $light_color are not in alphabetical order.\n";
            $result = -1;
        }
    }

    $previous_light_color = $light_color;
}

$previous_dark_color = null;
foreach ($dark_colors as $dark_color => $dark_color_value) {
    if (array_key_exists($dark_color, $light_colors) !== true) {
        echo "Dark color $dark_color does not exist in light colors.\n";
        $result = -1;
    }

    if ($previous_dark_color !== null) {
        if (strcmp($previous_dark_color, $dark_color) > 0) {
            echo "Dark color $previous_dark_color and $dark_color are not in alphabetical order.\n";
            $result = -1;
        }
    }

    $previous_dark_color = $dark_color;
}

if ($result === 0) {
    echo "Seems okay, there are " . count($light_colors) . " colors.\n";
}

exit($result);