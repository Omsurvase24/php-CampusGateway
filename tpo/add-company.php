<?php
    include("includes/header.php");
    include("../includes/input.php");
    include("../includes/textarea.php");
?>

<h1 class="text-white text-2xl font-medium">Add Company</h1>

<form action="actions.php" method="POST" class="mt-7 flex flex-col gap-y-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?= customInput("Name", "text", "name", "Enter company name", "", "w-full");?>
        <?= customInput("Email", "email", "email", "Enter company email", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?= customInput("Contact Number","text", "contactNo", "Enter company contact", "", "w-full");?>
        <?= customInput("Website", "text", "website", "Enter company website url", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <?= customTextarea("Address", "address", 3, "Enter company address", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <?= customTextarea("Description", "description", 3, "Enter company description", "", "w-full");?>
    </div>

    <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="addCompany">Submit</button>
</form>

<?php
    include("includes/footer.php");
?>