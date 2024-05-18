<?php
    include("includes/header.php");
?>

<?php

$errors = [
    '0' => 'Not Eligible',
    '2' => 'Already Applied',
    '3' => 'You hold max offers',
    '4' => 'Package difference does not match'
];

if(isset($_GET['jobId']) && empty($_GET['jobId']) || !isset($_GET['jobId'])) {
    redirect("Job not found", "jobs.php", "error");
}

$jobId = $_GET['jobId'];

$userId = $_SESSION['user']['userId'];

$eligibleToApply = checkEligibleForJob($userId, $jobId);

?>

<h1 class="text-white text-2xl font-medium mb-5">Apply</h1>

<?php
    $job = getJobById($jobId);
    
    if(mysqli_num_rows($job) > 0) {
        $data = mysqli_fetch_array($job);
    ?>
        <div class="flex flex-col bg-neutral-800 rounded-lg text-white p-4">
            <div class="mb-7">
                <h4 class="text-lg font-medium"><?= $data['title']; ?></h4>
                <p class="mt-2">at <?= $data['company_name']; ?></p>
                <p class="my-2"><i class="fa-solid fa-location-dot"></i> <?= $data['location']; ?></p>
                <a href="<?= $data['website']?>" target="_blank" class="text-sm"><i class="fa-solid fa-link"></i></a>
            </div>
            <div class="border-t border-neutral-600 py-5">
                <div  class="mb-3">
                    <h4 class="text-base font-semibold">Skills</h4>
                    <p class="text-sm mt-2"><?= $data['required_skills']; ?></p>
                </div>
                <div class="mb-3">
                    <h4 class="text-base font-semibold">Package</h4>
                    <p class="text-sm mt-1"><?= $data['package']; ?> LPA</p>
                </div>
                <div class="mb-3">
                    <h4 class="text-base font-semibold">About this opportunity</h4>
                    <p class="text-sm mt-1"><?= $data['description']; ?></p>
                </div>
            </div>
            <div class="border-t border-neutral-600 py-5">
                <div  class="mb-3">
                    <h4 class="text-base font-semibold">Eligibility Criteria (min percentage)</h4>
                    <p class="text-sm mt-2">SSC percentage: <?= $data['ssc_grade']; ?>%</p>
                    <p class="text-sm mt-2">HSC/ Diploma percentage: <?= $data['hsc_or_diploma_grade']; ?>%</p>
                    <p class="text-sm mt-2">Current percentage: <?= $data['current_grade']; ?>%</p>
                </div>
            </div>

            <?php
            
                if($eligibleToApply == 0 || $eligibleToApply == 2 || $eligibleToApply == 3 || $eligibleToApply == 4) {
                ?>
                    <button disabled class="w-[300px] rounded-full bg-red-600 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-white font-bold hover:opacity-75 transition"><?= $errors[$eligibleToApply]; ?></button>
                <?php
                }
                else if($eligibleToApply == 1) {
                ?>
                    <form action="actions.php" method="POST">
                        <input type="hidden" name="userId" value="<?= $userId?>">
                        <input type="hidden" name="jobId" value="<?= $jobId?>">
                        <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition" type="submit" name="applyForJob">Apply</button>
                    </form>
                <?php
                }
            ?>
        </div>
    <?php
    }
    else {
        redirect("Job not found", "jobs.php", "error");
    }
?>


<?php
    include("includes/footer.php");
?>