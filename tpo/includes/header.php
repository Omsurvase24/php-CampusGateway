<?php
    session_start();

    include("../middleware/tpoMiddleware.php");
    
    // TPO sidebar links
    $links = [
        ['title' => 'Home', 'url' => 'index.php', 'icon' => 'fa-house' ],
        ['title' => 'Companies', 'url' => 'companies.php', 'icon' => 'fa-building' ],
        ['title' => 'Jobs', 'url' => 'jobs.php', 'icon' => 'fa-briefcase' ],
        ['title' => 'Applications', 'url' => 'applications.php', 'icon' => 'fa-file' ],
        ['title' => 'Offers', 'url' => 'offers.php', 'icon' => 'fa-envelope-open-text' ],
        ['title' => 'Filters', 'url' => 'filters.php', 'icon' => 'fa-filter' ],
        ['title' => 'Profile', 'url' => 'profile.php', 'icon' => 'fa-user' ],
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Campus Gateway | TPO</title>
</head>
<body>
    <div class="bg-black h-full w-full overflow-hidden overflow-y-auto min-h-[100vh]">
        <div class="flex">
            <?php
                include("../includes/sidebar.php");
            ?>

            <div class="flex-1 h-full">
                <div class="flex flex-col bg-black h-[100vh] p-2 w-full">
                    <div class="bg-neutral-900 rounded-lg overflow-y-auto h-full w-full p-4">
