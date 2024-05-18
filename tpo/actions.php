<?php

session_start();

include("../functions/customFunctions.php");

if(isset($_POST['addCompany'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $insertQuery = "INSERT INTO companies(name, email, contact_no, website, address, description) values(?, ?, ?, ?, ?, ?)";
    $insertQueryStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertQueryStmt, "ssssss", $name, $email, $contactNo, $website, $address, $description);

    if(mysqli_stmt_execute($insertQueryStmt)) {
        mysqli_stmt_close($insertQueryStmt);
        redirect("Company registered successfully", "companies.php");
    }
    
    mysqli_stmt_close($insertQueryStmt);
    redirect("Could not register company. Please try again", "add-company.php", "error");
}
else if(isset($_POST['addJob'])) {
    // TODO: need to send email/ notifications to the eligible students when the job is added (also check for which chance)
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $companyId = mysqli_real_escape_string($conn, $_POST['companyId']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $sscGrade = mysqli_real_escape_string($conn, $_POST['sscGrade']);
    $hscOrDiplomaGrade = mysqli_real_escape_string($conn, $_POST['hscOrDiplomaGrade']);
    $currentGrade = mysqli_real_escape_string($conn, $_POST['currentGrade']);

    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn);

    $insertQuery = "INSERT INTO jobs(title, company_id, package, required_skills, location, website, description, ssc_grade, hsc_or_diploma_grade, current_grade) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertQueryStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertQueryStmt, "ssssssssss", $title, $companyId, $package, $skills, $location, $website, $description, $sscGrade, $hscOrDiplomaGrade, $currentGrade);

    if(mysqli_stmt_execute($insertQueryStmt)) {
        $jobId = mysqli_insert_id($conn);

        try {
            // send notifications
            $selectEligibleStudent = "SELECT i.user_id FROM information i JOIN jobs j ON i.ssc_grade >= j.ssc_grade AND i.hsc_or_diploma_grade >= j.hsc_or_diploma_grade AND i.current_grade >= j.current_grade WHERE j.id = ?";
            $selectEligibleStudentStmt = mysqli_prepare($conn, $selectEligibleStudent);
            mysqli_stmt_bind_param($selectEligibleStudentStmt, "i", $jobId);
            mysqli_stmt_execute($selectEligibleStudentStmt);    
            $selectEligibleStudentResult = mysqli_stmt_get_result($selectEligibleStudentStmt);

            while ($row = mysqli_fetch_assoc($selectEligibleStudentResult)) {
                $userId = $row['user_id'];
                $notificationMessage = "New Registration: " . $title . ' (' . $package . ' LPA)';

                $insertNotification = "INSERT INTO notifications (user_id, job_id, message) VALUES (?, ?, ?)";
                $insertNotificationStmt = mysqli_prepare($conn, $insertNotification);
                mysqli_stmt_bind_param($insertNotificationStmt, "iis", $userId, $jobId, $notificationMessage);
                mysqli_stmt_execute($insertNotificationStmt);
                mysqli_stmt_close($insertNotificationStmt);
            }

            mysqli_commit($conn);
            mysqli_stmt_close($insertQueryStmt);
            mysqli_autocommit($conn, true);
            redirect("Job registered successfully", "jobs.php");
        } 
        catch (Error $e) {
            mysqli_rollback($conn);
            mysqli_autocommit($conn, true);
            redirect("Could not register job. Please try again", "add-job.php", "error");
        }
    }
    else {
        mysqli_stmt_close($insertQueryStmt);
        mysqli_autocommit($conn, true);
        redirect("Could not register job. Please try again", "add-job.php", "error");
    }
}
else if(isset($_POST['editCompany'])) {
    $companyId = mysqli_real_escape_string($conn, $_POST['companyId']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $updateQuery = "UPDATE companies SET name = ?, email = ?, contact_no = ?, website = ?, address = ?, description = ? WHERE id = ?";
    $updateQueryStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateQueryStmt, "ssssssi", $name, $email, $contactNo, $website, $address, $description, $companyId);
    mysqli_stmt_execute($updateQueryStmt);

    if(mysqli_stmt_affected_rows($updateQueryStmt) > 0) {
        mysqli_stmt_close($updateQueryStmt);
        redirect("Company information updated successfully", "edit-company.php?id=$companyId");
    }

    mysqli_stmt_close($updateQueryStmt);
    redirect("Could not update company. Please try again", "edit-company.php", "error");
}
else if(isset($_POST['editJob'])) {
    $jobId = mysqli_real_escape_string($conn, $_POST['jobId']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $companyId = mysqli_real_escape_string($conn, $_POST['companyId']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $sscGrade = mysqli_real_escape_string($conn, $_POST['sscGrade']);
    $hscOrDiplomaGrade = mysqli_real_escape_string($conn, $_POST['hscOrDiplomaGrade']);
    $currentGrade = mysqli_real_escape_string($conn, $_POST['currentGrade']);

    $updateQuery = "UPDATE jobs SET title = ?, company_id = ?, package = ?, required_skills = ?, location = ?, website = ?, description = ?, ssc_grade = ?, hsc_or_diploma_grade = ?, current_grade = ? WHERE id = ?";
    $updateQueryStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateQueryStmt, "sissssssssi", $title, $companyId, $package, $skills, $location, $website, $description, $sscGrade, $hscOrDiplomaGrade, $currentGrade, $jobId);
    mysqli_stmt_execute($updateQueryStmt);

    if(mysqli_stmt_affected_rows($updateQueryStmt) > 0) {
        mysqli_stmt_close($updateQueryStmt);
        redirect("Job information updated successfully", "edit-job.php?id=$jobId");
    }

    mysqli_stmt_close($updateQueryStmt);
    redirect("Could not update job. Please try again", "edit-job.php", "error");
}
else if(isset($_POST['deleteJob'])) {
    $jobId = $_POST['jobId'];
    $role = $_SESSION['role'];

    if($role == 1) {
        try {
            $jobExist = "SELECT * FROM jobs WHERE id = $jobId";
            $jobExistRun = mysqli_query($conn, $jobExist);
            if(mysqli_num_rows($jobExistRun) > 0) {
                $deleteQuery = "DELETE FROM jobs WHERE id = $jobId";
                $deleteQueryRun = mysqli_query($conn, $deleteQuery);
                if($deleteQueryRun) {
                    echo sendResponse(200, 'Job deleted successfully');
                }
                else {
                    echo sendResponse(500, 'Could not delete job');
                }
            }
            else {
                echo sendResponse(401, 'Job not found');
            }
        } 
        catch (Exception $e) {
            echo sendResponse(500, 'Something went wrong. Try again later');
        }
    }
    else {
        echo sendResponse(401, 'Unauthorized access');
    }
}
else if(isset($_POST['deleteCompany'])) {
    $companyId = $_POST['companyId'];
    $role = $_SESSION['role'];

    // disable autocommit
    mysqli_autocommit($conn, false);

    if($role == 1) {
        try {
            // start transaction
            mysqli_begin_transaction($conn);

            $companyExistQuery = "SELECT * FROM companies WHERE id = $companyId";
            $companyExistQueryRun = mysqli_query($conn, $companyExistQuery);
            if(mysqli_num_rows($companyExistQueryRun) > 0) {
                // delete all jobs related to company
                $deleteJobsQuery = "DELETE FROM jobs WHERE company_id = $companyId";
                $deleteJobsQueryRun = mysqli_query($conn, $deleteJobsQuery);
                if($deleteJobsQueryRun) {
                    $deleteCompanyQuery = "DELETE FROM companies WHERE id = $companyId";
                    $deleteCompanyQueryRun = mysqli_query($conn, $deleteCompanyQuery);

                    if($deleteCompanyQueryRun) {
                        // commit all transactions if all queries succeed 
                        mysqli_commit($conn);
                        echo sendResponse(200, 'Company deleted successfully');
                    }
                    else {
                        mysqli_rollback($conn);
                        echo sendResponse(500, 'Could not delete company');
                    }
                }
                else {
                    mysqli_rollback($conn);
                    echo sendResponse(500, 'Could not delete company');
                }
            }
            else {
                echo sendResponse(401, 'Company not found');
            }
        } 
        catch (Exception $e) {
            mysqli_rollback($conn);
            echo sendResponse(500, 'Something went wrong. Try again later');
        }
        finally {
            // enable autocommit
            mysqli_autocommit($conn, true);
        }
    }
    else {
        echo sendResponse(401, 'Unauthorized access');
    }
}
else if(isset($_POST['getApplicants'])) {
    $jobId = $_POST['jobId'];

    $selectApplicants = "SELECT u.*, a.id AS application_id, i.* FROM applications a JOIN users u ON a.user_id = u.id LEFT JOIN information i ON u.id = i.user_id WHERE a.job_id = ?";
    $selectApplicantsStmt = mysqli_prepare($conn, $selectApplicants);
    mysqli_stmt_bind_param($selectApplicantsStmt, "i", $jobId);
    mysqli_stmt_execute($selectApplicantsStmt);
    $result = mysqli_stmt_get_result($selectApplicantsStmt);

    if($result) {
        $applicants = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $applicants[] = [
                'jobId' => $jobId,
                'userId' => $row['id'],
                'applicationId' => $row['application_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'gender' => $row['gender'],
                'contactNo' => $row['contact_no'],
                'sscGrade' => $row['ssc_grade'],
                'hscOrDiplomaGrade' => $row['hsc_or_diploma_grade'],
                'currentGrade' => $row['current_grade'],
                'branch' => $row['branch'],
                'github' => $row['github'],
                'linkedin' => $row['linkedin'],
                'portfolio' => $row['personal_portfolio'],
                'resume' => $row['resume'],
            ];
        }

        echo sendDataWithResponse(200, $applicants);
    }
    else {
        echo sendResponse("404", "Applicants not found");
    }
}
else if(isset($_POST['offerJob'])) {
    $jobId = $_POST['jobId'];
    $userId = $_POST['userId'];

    $offerExist = "SELECT * FROM offers WHERE user_id = ? AND job_id = ?";
    $offerExistStmt = mysqli_prepare($conn, $offerExist);
    mysqli_stmt_bind_param($offerExistStmt, "ii", $userId, $jobId);
    mysqli_stmt_execute($offerExistStmt);
    mysqli_stmt_store_result($offerExistStmt);

    if(mysqli_stmt_num_rows($offerExistStmt) > 0) {
        mysqli_stmt_close($offerExistStmt);
        echo sendResponse(500, "Offer already alloted");
        return;
    }

    $selectPackage = "SELECT package FROM jobs WHERE id = ?";
    $selectPackageStmt = mysqli_prepare($conn, $selectPackage);
    mysqli_stmt_bind_param($selectPackageStmt, "i", $jobId);
    mysqli_stmt_execute($selectPackageStmt);
    mysqli_stmt_store_result($selectPackageStmt);

    if(mysqli_stmt_num_rows($selectPackageStmt) > 0) {
        mysqli_stmt_bind_result($selectPackageStmt, $package); 
        mysqli_stmt_fetch($selectPackageStmt);

        $insertOffer = "INSERT INTO offers (user_id, job_id, package_offered) VALUES (?, ?, ?)";
        $insertOfferStmt = mysqli_prepare($conn, $insertOffer);
        mysqli_stmt_bind_param($insertOfferStmt, "iis", $userId, $jobId, $package);
        mysqli_stmt_execute($insertOfferStmt);

        mysqli_stmt_close($selectPackageStmt);
        mysqli_stmt_close($insertOfferStmt);

        echo sendResponse(200, "Offer alloted successfully");
    }
    else {
        echo sendResponse(500, "Something went wrong. Try again later");
    }
}
else if(isset($_POST['getOffers'])) {
    $jobId = $_POST['jobId'];

    $selectOffers = "SELECT u.id as users_id, u.*, i.*, j.*, o.id as offer_id FROM users u JOIN information i ON u.id = i.user_id JOIN offers o ON u.id = o.user_id JOIN jobs j ON o.job_id = j.id WHERE o.job_id = ?";
    $selectOffersStmt = mysqli_prepare($conn, $selectOffers);
    mysqli_stmt_bind_param($selectOffersStmt, "i", $jobId);
    mysqli_stmt_execute($selectOffersStmt);
    $result = mysqli_stmt_get_result($selectOffersStmt);

    if($result) {
        $offers = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $offers[] = [
                'offerId' => $row['offer_id'],
                'userId' => $row['users_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'gender' => $row['gender'],
                'contactNo' => $row['contact_no'],
                'sscGrade' => $row['ssc_grade'],
                'hscOrDiplomaGrade' => $row['hsc_or_diploma_grade'],
                'currentGrade' => $row['current_grade'],
                'branch' => $row['branch'],
                'jobTitle' => $row['title'],
                'package' => $row['package'],
                'github' => $row['github'],
                'linkedin' => $row['linkedin'],
                'portfolio' => $row['personal_portfolio'],
                'resume' => $row['resume'],
            ];
        }

        echo sendDataWithResponse(200, $offers);
    }
    else {
        echo sendResponse("404", "Offers not found");
    }
}
else if(isset($_POST['deleteOffer'])) {
    $offerId = $_POST['offerId'];

    $deleteQuery = "DELETE FROM offers WHERE id = $offerId";
    $deleteQueryRun = mysqli_query($conn, $deleteQuery);

    if($deleteQueryRun) {
        echo sendResponse(200, 'Offer deleted successfully');
    }
    else {
        echo sendResponse(500, 'Could not delete offer');
    }
}
else if(isset($_POST['updateTPOProfile'])) {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo $userId;
    echo $name;
    echo $email;
    echo $password;

    $updateQuery = "UPDATE users SET ";

    if(!empty($password)) {
        $updateQuery .= "email = ?, name = ?, password = ? WHERE id = ?";
    }
    else {
        $updateQuery .= "email = ?, name = ? WHERE id = ?";
    }

    echo $updateQuery;

    $updateQueryStmt = mysqli_prepare($conn, $updateQuery);

    if(!empty($password)) {
        mysqli_stmt_bind_param($updateQueryStmt, "sssi", $email, $name, $password, $userId);
    }
    else {
        mysqli_stmt_bind_param($updateQueryStmt, "ssi", $email, $name, $userId);
    }

    mysqli_stmt_execute($updateQueryStmt);

    if(mysqli_stmt_affected_rows($updateQueryStmt) > 0) {
        mysqli_stmt_close($updateQueryStmt);
        redirect("Profile updated successfully", "profile.php");
    }

    redirect("Something went wrong. Try again later", "profile.php", "error");
}
else if(isset($_POST['updateFilter'])) {
    $offers = $_POST['offers'];
    $package = $_POST['package'];
    $filterId = $_POST['filterId'];

    $selectQuery = "SELECT * FROM filters";
    $result = mysqli_query($conn, $selectQuery);

    if($result) {
        $count = mysqli_num_rows($result);

        if($count > 0) {
            $updateQuery = "UPDATE filters SET package_difference = ?, offers_count = ? WHERE id = ?";
            $updateQueryStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateQueryStmt, "sss", $package, $offers, $filterId);
            mysqli_stmt_execute($updateQueryStmt);

            if(mysqli_stmt_affected_rows($updateQueryStmt) > 0) {
                mysqli_stmt_close($updateQueryStmt);

                redirect("Filter updated successfully", "filters.php");
            } else {
                redirect("Something went wrong. Try again later", "filters.php", "error");
            }
        }
        else {
            $insertFilter = "INSERT INTO filters (package_difference, offers_count) VALUES (?, ?)";
            $insertFilterStmt = mysqli_prepare($conn, $insertFilter);
            mysqli_stmt_bind_param($insertFilterStmt, "ss", $package, $offers);
            mysqli_stmt_execute($insertFilterStmt);
            mysqli_stmt_close($insertFilterStmt);

            redirect("Filter updated successfully", "filters.php");
        }
    }
    else {
        redirect("Something went wrong. Try again later", "filters.php", "error");
    }
}

?>