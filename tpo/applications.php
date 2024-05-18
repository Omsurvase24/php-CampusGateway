<?php
    include("includes/header.php");
?>

<?php

$jobId = "";

if(isset($_GET['jobId']) && !empty($_GET['jobId'])) {
    $jobId = $_GET['jobId'];    
}

?>

<div class="flex items-center justify-between mb-5">
    <h1 class="text-white text-2xl font-medium">Applications</h1>
    <div>
        <select id="applicationJobId" class="flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white p-0">
            <option disabled selected>Select job</option>
                <?php
                    $jobs = getJobs();

                    if(mysqli_num_rows($jobs) > 0) {
                        foreach($jobs as $job) {
                        ?>
                            <option value="<?= $job['id']; ?>" <?= $jobId == $job['id'] ? 'selected' : ''; ?> ><?= $job['title']; ?> (<?= $job['company_name']; ?>)</option>
                        <?php
                        }
                    }
                ?>
        </select>
    </div>
</div>

<div class="flex flex-col bg-neutral-800 rounded-lg text-white">
  <div class="overflow-x-auto">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden" id="applicationsTable">
        <p class="text-neutral-400 py-3">Select job to see applicants data</p>
      </div>
    </div>
   </div>
</div>


<?php
    include("includes/footer.php");
?>