<?php
    include("includes/header.php");
?>

<div class="flex items-center justify-between mb-5">
    <h1 class="text-white text-2xl font-medium">Companies</h1>
    <a href="add-company.php"><i class="fa-solid fa-plus text-white cursor-pointer hover:text-neutral-400 transition"></i></a>
</div>

<div class="flex flex-col bg-neutral-800 rounded-lg text-white">
  <div class="overflow-x-auto">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden">
        <?php
            $companies = getAll("companies");

            if(mysqli_num_rows($companies) > 0) {
            ?>    

            <table class="min-w-full text-left text-sm font-light" id="companyTable">
                <thead class="border-b font-medium border-neutral-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Contact</th>
                        <th scope="col" class="px-6 py-4">Edit</th>
                        <th scope="col" class="px-6 py-4">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($companies as $company) {
                        ?>
                            <tr class="border-b border-neutral-600">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= $company['id']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $company['name']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $company['email']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $company['contact_no']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><a href="edit-company.php?id=<?= $company['id']?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <button id="deleteCompany" value="<?= $company['id'];?>"><i class="fa-solid fa-trash"></i></button>    
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                </tbody>
            </table>

            <?php
            }
            else {
            ?>
                <p>No records found</p>
            <?php
            }
        ?>
      </div>
    </div>
  </div>
</div>

<?php
    include("includes/footer.php");
?>