<?php require_once '../middleware/is_login.php'; ?>

<?php
require_once '../db/index.php';

if (!isset($_GET['id'])) {
    header('Location: /main');
}

$id = $_GET['id'];

$query = "SELECT * FROM questions LEFT JOIN answers ON questions.id=answers.question_id LEFT JOIN users ON answers.user_id = users.id WHERE questions.id = '$id'";

$allData = [];
$response = mysqli_query($connection, $query);

while ($data = mysqli_fetch_assoc($response)) {
    $allData[] = $data;
}
?>



<?php if (isset($_POST['submit'])) {
    $answer = $_POST['answer'];
    $user_id = $_SESSION['users']['id'];
    $question_id = $id;

    $query = "INSERT INTO answers(answer,question_id,user_id) VALUES ('$answer','$question_id','$user_id')";

    $response = mysqli_query($connection, $query);

    return header('Refresh:0');
} ?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/jawaban.css">
    <link rel="stylesheet" href="../assets/css/frame5.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Jawban</title>

</head>
 
<body> 
<nav class="navbar navbar-expand-lg " style='background-color:plum'>
  <a class="navbar-brand" href="/">
    <img src="../assets/logo.png" width="30" height="30" alt="" >
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
    <img src="../<?= $_SESSION['users'][
        'pic_profile'
    ] ?>" width="30" height="30" alt="" >
  </a>
    </span>
  </div>
</nav> 

    <div class="row">
        <div class="col col-md-6">
            <!--Kiri-->
            <div class="left-card">
                <div class="row">
                    <?php foreach ($allData as $data): ?>
                       <?php if ($data['username']): ?>
                        <div class="col col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $data[
                                        'username'
                                    ] ?></h5>
                                    <p class="card-text"><?= $data[
                                        'answer'
                                    ] ?></p>
                                </div>
                            </div>
                        </div> 
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col col-md-6">
            <!--Kanan-->
            <div class="right-card p-4">
                <p><?= $allData[0]['questions'] ?></p>
                <hr>
                <p>TULIS JAWABAN MU DISINI!</p>
                <div>
                    <form method="post">
                        <textarea name="answer" required></textarea>
                        <br>
                        <button name="submit">MASUKAN JAWABAN!</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="questionBox d-none" id="modal-question">
            <div class="modal-card">
                <div class="headers">
                    <p>Ajukan Pertanyaan</p>
                    <i class="fas fa-times icon-close" id="modal-close"></i>
                </div>
                <textarea></textarea>
                <select>
                    <option value="">Bahasa Sunda</option>
                    <option value="">Bahasa Indonesia</option>
                    <option value="">Bahasa Inggris</option>
                </select>
                <button>TANYAKAN PERTANYAAMU</button>
            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
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
