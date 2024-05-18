<?php
    // default links
    $defaultLinks = [
        ['title' => 'Home', 'url' => 'index.php', 'icon' => 'home' ],
        ['title' => 'Profile', 'url' => 'index.php', 'icon' => 'user' ],
    ];

    $activePage = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
?>

<div class="flex h-full">
    <div class="hidden md:flex flex-col gap-y-2 bg-black h-[100vh] p-2 w-[300px]">
        <div class="bg-neutral-900 rounded-lg overflow-y-auto h-full w-full p-4 flex flex-col justify-between gap-y-5">
            <ul class="flex flex-col gap-y-4">
                <?php
                    $sidebarLinks = isset($links) ? $links : $defaultLinks;

                    foreach($sidebarLinks as $link) {
                        $title = $link['title'];
                        $url = $link['url'];
                        $icon = $link['icon'];
                    ?>
                        <li>
                            <a href="<?php echo $url;?>" class="flex flex-row h-auto items-center w-full gap-x-4 text-base font-medium cursor-pointer hover:text-white transition text-neutral-400 py-1 <?= $activePage == $url ? 'text-white': '' ?>"> <i class="w-5 fa-solid <?php echo $icon;?>"></i> <?php echo $title;?></a>
                        </li>
                    <?php
                    }
                ?>
            </ul>

            <form action="../functions/authentication.php" method="POST">
                <button class="w-full rounded-md bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</div>