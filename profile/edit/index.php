<?php require_once '../../middleware/is_login.php'; ?>

<?php require '../../db/index.php'; ?>
<?php if (isset($_POST['submit'])) {
    if ($_FILES['profImage']['name']) {
        $target_dir = '../../assets/users_pic_profile/';
        $target_file = $target_dir . basename($_FILES['profImage']['name']);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        if (
            move_uploaded_file($_FILES['profImage']['tmp_name'], $target_file)
        ) {
        } else {
            echo 'Sorry, there was an error uploading your file.';
        }
        $image =
            'assets/users_pic_profile/' .
            basename($_FILES['profImage']['name']);
        $pic = $image;
    }
    $age = $_POST['age'];
    $email = $_POST['email'];
    $id = $_SESSION['users']['id'];
    $bio = $_POST['bios'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $update = "UPDATE users SET age = '$age', email = '$email',biodata='$bio', password='$pass'";
    if ($_FILES['profImage']['name']) {
        echo 'hereee';
        $update .= ", pic_profile = '$pic' ";
    }
    $update .= "WHERE id = '$id'";
    $queries = mysqli_query($connection, $update);
    $user = "SELECT * FROM users WHERE id = '$id'";
    if ($queries) {
        $query = mysqli_query($connection, $user);
        $row = mysqli_fetch_assoc($query);
        $_SESSION['users'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'biodata' => $row['biodata'],
            'pic_profile' => $row['pic_profile'],
            'age' => $row['age'],
            'created_at' => $row['created_at'],
        ];
        header('Reload:0');
    } else {
        echo "Error: Could not able to execute $update" . mysqli_error($con);
    }
    mysqli_close($connection);
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile </title>
    <link rel="stylesheet" href="../../assets/css/EditProfile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/frame5.css">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <nav class="navbar navbar-expand-lg " style='background-color:plum'>
        <a class="navbar-brand" href="/tubes">
            <img src="../../assets/logo.png" width="30" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link text-dark" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-dark" href="#" id="show-modal"> | Tanyakan Pertanyaan <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="navbar-brand" href="/profile">
                    <img src="../../<?= $_SESSION['users']['pic_profile'] ?>" width="30" height="30" alt="">
                </a>
            </span>
        </div>
    </nav>
    <hr>
    <main>
        <div class="container" style="margin-left:200px">
            <div class="atas">
                <h1>Edit Profile Mu</h1>
                <hr style="color:#b3b3b3">
            </div>
            <div class="isi">
                <div class="sub-left">
                    <form method="post" name="editProfile" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <h2>Umur<span class="tab"></span><input type="text" name="age" value="<?= $_SESSION['users']['age'] ?>"></h2>
                        <hr style="color:#b4c5ff">
                        <h2>EmailMu <span class="tab"></span> &nbsp; <input type="text" name="email" value="<?= $_SESSION['users']['email'] ?>"></h2>
                        <hr style="color:#b4c5ff">
                        <h2>Gambar Profil <span class="tab"></span> <input type="file" name="profImage"></h2>
                        <h2>Password<span class="tab"></span><input type="password" name="pass"></h2>
                        <hr style="color:#b4c5ff">
                        <hr style="color:#b4c5ff">
                        <h2>Bio <span class="tab"></span> &nbsp; <textarea type="text" name="bios"><?= $_SESSION['users']['biodata'] ?></textarea></h2>

                </div>
                <div class="sub-right">
                    <img src="../../<?= $_SESSION['users']['pic_profile'] ?>" class="mt-5 img-circle" alt="avatar">
                    <h2><?= $_SESSION['users']['username'] ?></h2><br><input type="submit" name="submit" value="Simpan">

                    </form>
                </div>
            </div>

        </div>
        <div class="questionBox d-none" id="modal-question">
            <div class="modal-card">
                <div class="headers">
                    <p>Ajukan Pertanyaan</p>
                    <i class="fas fa-times icon-close" id="modal-close"></i>
                </div>
                <textarea id="questions"></textarea>
                <select id="category-menu">
                </select>
                <button onclick="addQuestion()">TANYAKAN PERTANYAAMU</button>
            </div>
        </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const modalQuestion = document.getElementById("modal-question");
        const closeModal = document.getElementById("modal-close");
        const showModal = document.getElementById("show-modal")

        closeModal.addEventListener('click', () => {
            modalQuestion.classList.add("d-none")
        })

        showModal.addEventListener("click", () => {
            modalQuestion.classList.remove("d-none")
        })
    </script>
</body>

</html>