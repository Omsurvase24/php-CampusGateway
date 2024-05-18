<?php
    include("includes/header.php");
?>

<h1 class="text-white text-2xl font-medium mb-5">Notifications</h1>

<?php

    $notifications = getAllNotifications($_SESSION['user']['userId']);

    if(mysqli_num_rows($notifications) > 0) {
        foreach($notifications as $notification) {
        ?>
            <div class="bg-neutral-800 p-5 mb-3 rounded-md">
                <h4 class="text-white font-medium text-sm mb-2"><?= $notification['message']; ?></h4>
                <a href="apply.php?jobId=<?=$notification['job_id']?>" class="underline text-neutral-300 text-sm">Apply here</a>
            </div>
        <?php
        }
    }
    else {
    ?>
        <p class="text-neutral-400 py-3">No records found</p>
    <?php
    }
?>


<?php
    include("includes/footer.php");
?>