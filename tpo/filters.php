<?php
    include("includes/header.php");
    include("../includes/input.php");
?>

<?php

$filters = getAll("filters");

$data = mysqli_fetch_array($filters);

?>

<h1 class="text-white text-2xl font-medium mb-5">Filters</h1>

<form action="actions.php" method="POST" class="flex flex-col gap-y-2">
    <input type="hidden" name="filterId" value="<?= isset($data['id']) ? $data['id']: "" ?>">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
        <?= customInput("Offers", "text", "offers", "Enter no. of offers", isset($data['offers_count']) ? $data['offers_count'] : "", "w-full");?>
        <?= customInput("Package Difference (LPA)", "text", "package", "Enter package difference", isset($data['package_difference']) ? $data['package_difference'] : "", "w-full");?>
    </div>

    <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="updateFilter">Submit</button>
</form>

<?php
    include("includes/footer.php");
?>