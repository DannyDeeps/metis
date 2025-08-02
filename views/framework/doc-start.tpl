<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title>{$title}</title>

    {foreach $css as $file}
        <link rel="stylesheet" href="/assets/css/{$file}.css">
    {/foreach}

</head>
<body>
    {if !empty($notices)}
        {foreach $notices as $notice}
            {include 'toasts/notice.tpl' notice=$notice}
        {/foreach}
    {/if}