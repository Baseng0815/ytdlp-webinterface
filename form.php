<?php

function set_headers($urls, $audio_only) {
    if (count($urls) > 1) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="archive.zip"');
        return;
    }

    if ($audio_only) {
        header('Content-Type: audio/mpeg');
        header('Content-Disposition: attachment; filename="audio.mp3"');
        return;
    }

    // extract extension of first video format
    $url = $urls[0];

    $formats = shell_exec("yt-dlp --list-formats -q $url");
    if (!$formats) {
        echo 'Something unexpected happened and we can\'t serve your request :(';
        exit;
    }

    $formats = explode("\n", $formats);
    array_pop($formats);

    $choice = explode(" ", preg_replace('!\s+!', ' ', end($formats)));
    $extension = $choice[1];

    header("Content-Type: video/$extension");
    header("Content-Disposition: attachment; filename=\"video.$extension\"");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require('form-get-view.php');

} else {
    $urls = [];
    $audio_only = isset($_POST['audio']);

    if (isset($_FILES['batch']) && !empty($_FILES['batch']['tmp_name'])) {
        if (!($file = fopen($_FILES['batch']['tmp_name'], 'r'))) {
            echo 'Something unexpected happened and we can\'t serve your request :(';
            exit;
        }

        while (!feof($file)) {
            $line = filter_var(trim(fgets($file)), FILTER_VALIDATE_URL);
            if ($line) {
                $urls[] = $line;
            }
        }
    }

    $urls = array_merge($urls, filter_input(INPUT_POST, 'url', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY));

    if (empty($urls)) {
        echo 'You need to supply at least one file name, either through the form or through a batch file';
        exit;
    }

    set_headers($urls, $audio_only);

    $arg = "";
    foreach ($urls as $url) {
        $arg .= escapeshellarg($url) . " ";
    }

    if ($audio_only) {
        $command = "./download --audio $arg";
    } else {
        $command = "./download $arg";
    }

    passthru($command);
}
