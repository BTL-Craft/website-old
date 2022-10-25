<?php

if (file_exists(__DIR__.'/../../.env.json')) {
    return json_decode(__DIR__.'/../../.env.json', true);
} else {
    copy(__DIR__.'/../../.env.json.example', __DIR__.'/../../.env.json');
    return json_decode(__DIR__.'/../../.env.json', true);
}

