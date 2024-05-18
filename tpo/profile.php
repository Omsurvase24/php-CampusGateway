<?php
    include("includes/header.php");
    include("../includes/input.php");
?>

<?php

$userData = getById("users", $_SESSION['user']['userId']);

$data = mysqli_fetch_array($userData);

?>

<h1 class="text-white text-2xl font-medium mb-5">Profile</h1>

<form action="actions.php" method="POST" class="flex flex-col gap-y-2">
    <input type="hidden" name="userId" value="<?= $_SESSION['user']['userId']; ?>">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
        <?= customInput("Name", "text", "name", "Enter your name", $data["name"], "w-full");?>
        <?= customInput("Email", "email", "email", "Enter your email", $data["email"], "w-full");?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
        <?= customInput("Password", "text", "password", "Enter new password", "", "w-full");?>
    </div>

    <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="updateTPOProfile">Update</button>
</form>

<?php
    include("includes/footer.php");
?>