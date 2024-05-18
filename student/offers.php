<?php
    include("includes/header.php");
?>



<h1 class="text-white text-2xl font-medium mb-5">Offers</h1>

<div class="flex flex-col bg-neutral-800 rounded-lg text-white">
  <div class="overflow-x-auto">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden">

        <?php

        $offers = getOffersByUserId($_SESSION['user']['userId']);

        if(mysqli_num_rows($offers) > 0) {
        ?>
            <table class="min-w-full text-left text-sm font-light" id="jobTable">
                <thead class="border-b font-medium border-neutral-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Job Title</th>
                        <th scope="col" class="px-6 py-4">Company</th>
                        <th scope="col" class="px-6 py-4">Package</th>
                        <th scope="col" class="px-6 py-4">Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($offers as $offer) {
                        ?>
                            <tr class="border-b border-neutral-600">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= $offer['id']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $offer['title']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $offer['company_name']?></td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $offer['package']?> LPA</td>
                                <td class="whitespace-nowrap px-6 py-4"><?= $offer['location']?></td>
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