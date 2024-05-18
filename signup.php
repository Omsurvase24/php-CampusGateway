<?php
    include("includes/header.php");
    include("includes/input.php");

    if(isset($_SESSION['auth'])) {
        $role = $_SESSION['role'];

        if($role == 0) {
            redirect('Already logged in', 'student/index.php');
        }
        else {
            redirect('Already logged in', 'tpo/index.php');
        }
    }
?>

<div class="w-full h-full flex items-center justify-center min-h-[100vh]">
    <form action="functions/authentication.php" method="POST" class="p-5 rounded-lg flex flex-col gap-y-4 border border-neutral-700 bg-neutral-800 w-full m-3 md:w-[400px]">
        <h1 class="text-white font-semibold text-3xl text-center mb-4">Signup</h1>
        <?= customInput("Full Name", "text", "fullName", "Enter your full name", "", "min-w-full");?>
        <?= customInput("Email", "email", "email", "Enter your email", "", "min-w-full");?>
        <?= customInput("Password", "password", "password", "Enter your password", "", "min-w-full");?>

        <button class="w-full rounded-full bg-green-500 border border-transparent px-3 py-3 disabled:cursor-not-allowed disabled:opacity-50 text-black font-bold hover:opacity-75 transition" type="submit" name="signup">Signup</button>

        <p class="text-center text-neutral-500 text-sm mt-3">Already have an account? <a href="login.php" class="underline">Click here</a></p>
    </form>
</div>

<?php
    include("includes/footer.php");
?>