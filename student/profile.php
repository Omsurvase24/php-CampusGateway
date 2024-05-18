<?php
    include("includes/header.php");
    include("../includes/input.php");
    include("../includes/textarea.php");
?>

<?php

$studentProfile = getStudentProfile();

$data = mysqli_fetch_array($studentProfile);

?>

<h1 class="text-white text-2xl font-medium">Profile</h1>

<form action="actions.php" method="POST" enctype="multipart/form-data" class="mt-7 flex flex-col gap-y-2">
    <input type="hidden" name="userId" value="<?= $_SESSION['user']['userId']; ?>">
    <div class="flex flex-col gap-y-1 md:gap-y-2">
        <h4 class="text-neutral-300 text-base font-semibold mb-2 md:mb-0">Personal</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("Name", "text", "name", "Enter company name", $data['name'], "w-full");?>
            <?= customInput("Email", "email", "email", "Enter company email", $data['email'], "w-full");?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("Contact Number","text", "contactNo", "Enter company contact", $data['contact_no'], "w-full");?>
            <div>
                <label class='text-sm text-neutral-400'>Gender</label>
                <select name="gender" class="flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white p-0">
                    <option disabled selected>Select gender</option>
                    <option value="male" <?= $data['gender'] == 'male' ? 'selected' : ''?>>Male</option>
                    <option value="female" <?= $data['gender'] == 'female' ? 'selected' : ''?>>Female</option>
                    <option value="other" <?= $data['gender'] == 'other' ? 'selected' : ''?>>Other</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <div>
                <?= customInput("Profile", "file", "profileImage", "", "", "w-full", true, "image/*");?>
                <?php 
                    if(!empty($data['profile_image'])) {
                    ?>
                        <a class="text-neutral-500 text-sm" href="../uploads/profiles/<?= $data['profile_image'];?>" target="_blank"><?= $data['profile_image'];?></a>
                    <?php
                    }
                ?>
            </div>
            <div>
                <?= customInput("Resume", "file", "resume", "", "", "w-full", true, "application/pdf");?>
                <?php 
                    if(!empty($data['resume'])) {
                    ?>
                        <a class="text-neutral-500 text-sm" href="../uploads/resumes/<?= $data['resume'];?>" download><?= $data['resume'];?></a>
                    <?php
                    }
                ?>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-2 md:gap-4">
            <?= customTextarea("Address", "address", 3, "Enter address", $data['address'], "w-full");?>
        </div>
    </div>

    <div class="mt-4 flex flex-col gap-y-1 md:gap-y-2">
        <h4 class="text-neutral-300 text-base font-semibold mb-2 md:mb-0">Education</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("SSC School Name", "text", "sscSchoolName", "Enter ssc school name", $data['ssc_school_name'], "w-full");?>
            <?= customInput("SSC Grade", "text", "sscGrade", "Enter ssc grade", $data['ssc_grade'], "w-full");?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("HSC/ Diploma College Name", "text", "hscOrDiplomaName", "Enter hsc/ diploma college name", $data['hsc_or_diploma_college_name'], "w-full");?>
            <?= customInput("HSC/ Diploma Grade", "text", "hscOrDiplomaGrade", "Enter hsc/ diploma grade", $data['hsc_or_diploma_grade'], "w-full");?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("College Name", "text", "collegeName", "Enter current college name", $data['current_college_name'], "w-full");?>
            <?= customInput("Current Grade", "text", "currentGrade", "Enter current grade", $data['current_grade'], "w-full");?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <div>
                <label class='text-sm text-neutral-400'>Branch</label>
                <select name="branch" class="flex w-full rounded-md bg-neutral-700 border border-transparent px-3 py-3 text-sm font-medium file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none text-white p-0">
                    <option disabled selected>Select branch</option>
                    <option value="Computer Engineering" <?= $data['branch'] == 'Computer Engineering' ? 'selected' : ''?>>Computer Engineering</option>
                    <option value="Information Technology" <?= $data['branch'] == 'Information Technology' ? 'selected' : ''?>>Information Technology</option>
                    <option value="Mechanical Engineering" <?= $data['branch'] == 'Mechanical Engineering' ? 'selected' : ''?>>Mechanical Engineering</option>
                    <option value="Electrical Engineering" <?= $data['branch'] == 'Electrical Engineering' ? 'selected' : ''?>>Electrical Engineering</option>
                    <option value="E & TC Engineering" <?= $data['branch'] == 'E & TC Engineering' ? 'selected' : ''?>>E & TC Engineering</option>
                    <option value="E & CS Engineering" <?= $data['branch'] == 'E & CS Engineering' ? 'selected' : ''?>>E & CS Engineering</option>
                    <option value="AIDS" <?= $data['branch'] == 'AIDS' ? 'selected' : ''?>>AIDS</option>
                    <option value="AIML" <?= $data['branch'] == 'AIML' ? 'selected' : ''?>>AIML</option>
                </select>
            </div>
            <?= customInput("Passout Year", "text", "passoutYear", "Enter passout year", $data['passout_year'], "w-full");?>
        </div>
    </div>

    <div class="mt-4 flex flex-col gap-y-1 md:gap-y-2">
        <h4 class="text-neutral-300 text-base font-semibold mb-2 md:mb-0">Social</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4">
            <?= customInput("Github", "text", "github", "Enter github url", $data['github'], "w-full");?>
            <?= customInput("Linkedin", "text", "linkedin", "Enter linkedin url", $data['linkedin'], "w-full");?>
        </div>
        <div class="grid grid-cols-1 gap-2 md:gap-4">
            <?= customInput("Personal Portfolio", "text", "personalPortfolio", "Enter portfolio url", $data['personal_portfolio'], "w-full");?>
        </div>
    </div>

    <button class="w-[200px] rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition mt-4" type="submit" name="updateStudentProfile">Submit</button>
</form>

<?php
    include("includes/footer.php");
?>