<?php
    include("includes/header.php");
    include("../includes/input.php");
    include("../includes/textarea.php");
?>

<h1 class="text-white text-2xl font-medium">Edit Company</h1>

<?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $companyId = $_GET['id'];

        $company = getById("companies", $companyId);

        if(mysqli_num_rows($company) > 0) {
            $data = mysqli_fetch_array($company);
        ?>
            <form action="actions.php" method="POST" class="mt-7 flex flex-col gap-y-2">
                <input type="hidden" name="companyId" value="<?= $data['id'];?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?= customInput("Name", "text", "name", "Enter company name", $data['name'], "w-full");?>
                    <?= customInput("Email", "email", "email", "Enter company email", $data['email'], "w-full");?>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?= customInput("Contact Number","text", "contactNo", "Enter company contact", $data['contact_no'], "w-full");?>
                    <?= customInput("Website", "text", "website", "Enter company website url", $data['website'], "w-full");?>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <?= customTextarea("Address", "address", 3, "Enter company address", $data['address'], "w-full");?>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <?= customTextarea("Description", "description", 3, "Enter company description", $data['description'], "w-full");?>
                </div>

                <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="editCompany">Update</button>
            </form>
        <?php
        }
        else {
            redirect("Company not found", "companies.php", "error");
        }
    ?>
    <?php
    }
    else {
        redirect("Company not found", "companies.php", "error");
    }

?>

<?php
    include("includes/footer.php");
?>