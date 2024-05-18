<?php
    include("includes/header.php");
?>

<h1 class="text-white text-2xl font-medium mb-5">Applied</h1>

<div class="flex flex-col bg-neutral-800 rounded-lg text-white">
  <div class="overflow-x-auto">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden" id="appliedTable">
        <?php
            $appliedJobs = getAppliedJobs($_SESSION['user']['userId']);

            if(mysqli_num_rows($appliedJobs) > 0) {
            ?>    

            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium border-neutral-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Job Title</th>
                        <th scope="col" class="px-6 py-4">Company</th>
                        <th scope="col" class="px-6 py-4">Package</th>
                        <th scope="col" class="px-6 py-4">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($appliedJobs as $job) {
                        ?>
                            <tr class="border-b border-neutral-600">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= $job['id']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $job['title']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $job['company_name']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $job['package']?> LPA</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <button id="deleteApplication" value="<?= $job['application_id'];?>"><i class="fa-solid fa-trash"></i></button>  
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
                <p class="text-neutral-400 py-3">No records found</p>
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