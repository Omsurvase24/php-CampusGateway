<?php

session_start();

include("../functions/customFunctions.php");

if(isset($_POST['updateStudentProfile'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $sscSchoolName = mysqli_real_escape_string($conn, $_POST['sscSchoolName']);
    $sscGrade = mysqli_real_escape_string($conn, $_POST['sscGrade']);
    $hscOrDiplomaName = mysqli_real_escape_string($conn, $_POST['hscOrDiplomaName']);
    $hscOrDiplomaGrade = mysqli_real_escape_string($conn, $_POST['hscOrDiplomaGrade']);
    $collegeName = mysqli_real_escape_string($conn, $_POST['collegeName']);
    $currentGrade = mysqli_real_escape_string($conn, $_POST['currentGrade']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $passoutYear = mysqli_real_escape_string($conn, $_POST['passoutYear']);
    $github = mysqli_real_escape_string($conn, $_POST['github']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $personalPortfolio = mysqli_real_escape_string($conn, $_POST['personalPortfolio']);

    $path = "../uploads";

    // profile image
    $profileImage = $_FILES['profileImage']['name'];
    $profileImageExtension = pathinfo($profileImage, PATHINFO_EXTENSION);
    $profileImageFileName = time().'_profile.'.$profileImageExtension;

    // resume
    $resume = $_FILES['resume']['name'];
    $resumeExtension = pathinfo($resume, PATHINFO_EXTENSION);
    $resumeFileName = time().'._resume.'.$resumeExtension;

    // update user's name and email from 'users' table
    $updateUserQuery = "UPDATE users SET name = ?, email = ? WHERE id = $userId";

    // check user's information is available in 'information' table. If available then UPDATE existing information else INSERT new record in 'information' table
    $informationExist = "SELECT id, profile_image, resume FROM information WHERE user_id = ?";
    $informationExistStmt = mysqli_prepare($conn, $informationExist);
    mysqli_stmt_bind_param($informationExistStmt, "i", $userId);
    mysqli_stmt_execute($informationExistStmt);
    mysqli_stmt_store_result($informationExistStmt);

    if(mysqli_stmt_num_rows($informationExistStmt) > 0) {
        mysqli_stmt_bind_result($informationExistStmt, $id, $profile, $resume); // previos profile_image and resume
        mysqli_stmt_fetch($informationExistStmt);

        // if profileImage and resume is not uploaded by user then use previos url of them
        if(empty($_FILES['profileImage']['name'])) {
            $profileImageFileName = $profile;
        }
        if(empty($_FILES['resume']['name'])) {
            $resumeFileName = $resume;
        }

        // update existing information
        $updateQuery = "UPDATE information SET contact_no = ?, gender = ?, ssc_school_name = ?, ssc_grade = ?, hsc_or_diploma_college_name = ?, hsc_or_diploma_grade = ?, current_college_name = ?, current_grade = ?, branch = ?, passout_year = ?, address = ?, github = ?, linkedin = ?, personal_portfolio = ?, profile_image = ?, resume = ? WHERE user_id = $userId";
        $updateQueryStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateQueryStmt, "ssssssssssssssss", $contactNo, $gender, $sscSchoolName, $sscGrade, $hscOrDiplomaName, $hscOrDiplomaGrade, $collegeName, $currentGrade, $branch, $passoutYear, $address, $github, $linkedin, $personalPortfolio, $profileImageFileName, $resumeFileName);
        mysqli_stmt_execute($updateQueryStmt);

        if(mysqli_stmt_affected_rows($updateQueryStmt) > 0) {
            mysqli_stmt_close($updateQueryStmt);

            // if profileImage is uploaded by user then use new profileImage and delete previous
            if(!empty($_FILES['profileImage']['name'])) {
                // delete previos profile image
                if(file_exists("../uploads/profiles/".$profile)) {
                    unlink("../uploads/profiles/".$profile);
                }

                move_uploaded_file($_FILES['profileImage']['tmp_name'], $path.'/profiles'.'/'.$profileImageFileName);
            }
            // if resume is uploaded by user then use new resume and delete previous
            if(!empty($_FILES['resume']['name'])) {
                // delete previous resume
                if(file_exists("../uploads/resumes/".$resume)) {
                    unlink("../uploads/resumes/".$resume);
                }

                move_uploaded_file($_FILES['resume']['tmp_name'], $path.'/resumes'.'/'.$resumeFileName);
            }
            
            redirect("Information updated successfully", "profile.php");
        }

        mysqli_stmt_close($updateQueryStmt);
        redirect("Something went wrong. Try again later", "profile.php");
    }
    else {
        // insert new information
        $insertQuery = "INSERT INTO information(user_id, contact_no, gender, ssc_school_name, ssc_grade, hsc_or_diploma_college_name, hsc_or_diploma_grade, current_college_name, current_grade, branch, passout_year, address, github, linkedin, personal_portfolio, profile_image, resume) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertQueryStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertQueryStmt, "issssssssssssssss", $userId, $contactNo, $gender, $sscSchoolName, $sscGrade, $hscOrDiplomaName, $hscOrDiplomaGrade, $collegeName, $currentGrade, $branch, $passoutYear, $address, $github, $linkedin, $personalPortfolio, $profileImageFileName, $resumeFileName);

        if(mysqli_stmt_execute($insertQueryStmt)) {
            mysqli_stmt_close($insertQueryStmt);
            move_uploaded_file($_FILES['profileImage']['tmp_name'], $path.'/profiles'.'/'.$profileImageFileName);
            move_uploaded_file($_FILES['resume']['tmp_name'], $path.'/resumes'.'/'.$resumeFileName);

            redirect("Information updated successfully", "profile.php");
        }

        mysqli_stmt_close($insertQueryStmt);
        redirect("Something went wrong. Try again later", "profile.php");
    }
}
else if(isset($_POST['applyForJob'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $jobId = mysqli_real_escape_string($conn, $_POST['jobId']);

    $insertQuery = "INSERT INTO applications(user_id, job_id) values(?, ?)";
    $insertQueryStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertQueryStmt, "ii", $userId, $jobId);

    if(mysqli_stmt_execute($insertQueryStmt)) {
        mysqli_stmt_close($insertQueryStmt);
        redirect("Application submitted successfully", "apply.php?jobId=$jobId");
    }
    mysqli_stmt_close($insertQueryStmt);
    redirect("Something went wrong. Try again later", "apply.php?jobId=$jobId");
}
else if(isset($_POST['deleteApplication'])) {
    $applicationId = mysqli_real_escape_string($conn, $_POST['applicationId']);

    $deleteQuery = "DELETE FROM applications WHERE id = ?";
    $deleteQueryStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteQueryStmt, "i", $applicationId);

    if(mysqli_stmt_execute($deleteQueryStmt)) {
        mysqli_stmt_close($deleteQueryStmt);
        echo sendResponse(200, 'Application deleted successfully');
        return;
    }
    mysqli_stmt_close($deleteQueryStmt);
    echo sendResponse(500, 'Something went wrong. Please try again');
}

?>