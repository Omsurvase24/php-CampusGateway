<?php
    include("includes/header.php");
    include("../includes/input.php");
    include("../includes/textarea.php");
?>

<h1 class="text-white text-2xl font-medium">Add Job</h1>

<form action="actions.php" method="POST" class="mt-7 flex flex-col gap-y-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php echo customInput("Title", "text", "title", "Enter job title", "", "w-full");?>
        <div>
            <label class='text-sm text-neutral-400'>Company</label>
            <select name="companyId" class="flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white p-0">
                <option disabled selected>Select company</option>
                <?php
                    $companies = getAll("companies");

                    if(mysqli_num_rows($companies) > 0) {
                        foreach($companies as $company) {
                        ?>
                            <option value="<?= $company['id']?>"><?= $company['name']?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php echo customInput("Package","text", "package", "Enter package", "", "w-full");?>
        <?php echo customInput("Required Skills", "text", "skills", "Enter required skills", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php echo customInput("Job Location","text", "location", "Enter job location", "", "w-full");?>
        <?php echo customInput("Website", "text", "website", "Enter job url", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <?php echo customTextarea("Description", "description", 3, "Enter job description", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php echo customInput("SSC percentage (min)","number", "sscGrade", "Enter ssc percentage (min)", "", "w-full");?>
        <?php echo customInput("HSC/ diploma percentage (min)","number", "hscOrDiplomaGrade", "Enter hsc/ diploma percentage (min)", "", "w-full");?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php echo customInput("Current percentage (min)", "number", "currentGrade", "Enter current percentage (min)", "", "w-full");?>
    </div>

    <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="addJob">Submit</button>
</form>

<?php
    include("includes/footer.php");
?>