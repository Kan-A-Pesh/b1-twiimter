<?php

function parseText($text)
{
    $text = htmlspecialchars($text);
    $text = preg_replace('/\r\n|\r|\n/', '<br>', $text);
    $text = preg_replace('/@([a-zA-Z0-9_-]+)/', '<a href="/profile?u=$1">@$1</a>', $text);
    $text = preg_replace('/[^&]#([a-zA-Z0-9_-]+)/', '<a href="/?q=$1">#$1</a>', $text);
    return $text;
}

function parseMedia($media)
{
    if (empty($media)) {
        return null;
    }

    $snowflake = MediaSnowflake::parse($media);

    $id = $snowflake->getID();
    $ext = $snowflake->getExt();

    return "/media/$id.$ext";
}
