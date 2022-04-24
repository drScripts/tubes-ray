<?php require_once '../middleware/is_login.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/frame5.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <title>Profile</title>
    <link rel="icon" href="../assets/logo.png" type="image/icon type">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg " style='background-color:plum'>
        <a class="navbar-brand" href="/">
            <img src="../assets/logo.png" width="30" height="30" alt="">
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
                <a class="navbar-brand" href="./profile">
                    <img src="../<?= $_SESSION['users']['pic_profile'] ?>" width="30" height="30" style="border-radius:50%" alt="">
                </a>
            </span>
        </div>
    </nav>
    <div class="framekanan">
        <div class="card" style="border:1px solid black; margin:20px;">
            <div class="profile">
                <img src="../<?= $_SESSION['users']['pic_profile'] ?>" alt="profile" style="border-radius:50%; border:1px solid black">
                <div class="profile-data">
                    <p><b><?= $_SESSION['users']['username'] ?></b></p>
                    <p class="umur"><?= $_SESSION['users']['age'] ?> Tahun</p>
                    <p><?= $_SESSION['users']['biodata'] ?></p>
                </div>
            </div>

            <button type="submit" class="editprofile" onclick="location.href = '../profile/edit';">Edit
                Profile</b></button>


            <div class="info-profile">
                <p class="sub-judul">Keterangan</p>
                <p><b class="info">Email</b> </t> <?= $_SESSION['users']['email'] ?> </p>
                <p><b class="info">Umur</b> </t> <?= $_SESSION['users']['age'] ?></p>
                <p><b class="info">Bergabung</b> </t> <?= date(
                                                            'd M Y',
                                                            strtotime($_SESSION['users']['created_at'])
                                                        ) ?> </p>
            </div>
            <button type="submit" class="logout" onclick="location.href = '../logout';">Logout</b></button>
        </div>
        <div class="right">
            <div class="mb-3">
                <button type="submit" class="jawaban toggle" data-name="answer">Jawaban</button>
                <button type="submit" class="pertanyaan toggle" data-name="questions">Pertanyaan</button>
            </div>
            <div class="row" id="items">

            </div>
        </div>
    </div>

    <div class="questionBox d-none" id="modal-question">
        <div class="modal-card">
            <div class="headers">
                <p>Ajukan Pertanyaan</p>
                <i class="fas fa-times icon-close" id="modal-close"></i>
            </div>
            <textarea id="questions" style="border:1px solid black"></textarea>
            <select id="category-menu">
            </select>
            <button onclick="addQuestion()">TANYAKAN PERTANYAAMU</button>
        </div>
    </div>
</body>

<script>
    function getAnswer() {
        $("#items").html("");
        const request = $.ajax({
            url: '../ajax/answer',
            method: "get",
            dataType: "xml",
        });

        request.done(function(response) {
            const res = $(response).find("answerData");
            for (let i = 0; i < res.length; i++) {
                const element = $(res[i]);
                const id = element.find("answerId").text();
                const answer = element.find("answer").text();
                const question_id = element.find("id").text();
                const question = element.find("questions").text();


                $("#items").append(`
                <div class="col col-md-3 mb-4 ">
                    <div class="card" style="border : 1px solid black">
                        <div class="card-body">
                            <h5 class="card-title">${question}</h5>
                            <p class="card-text">${answer}</p>
                            <a href="../question?id=${question_id}" class="btn btn-primary">Go To Question</a>
                        </div>
                    </div>
                </div>
                `);
            }

        });

        request.fail(function(jqXHR, textStatus) {
            console.log(jqXHR, textStatus);
        });
    }

    function getQuestion() {
        $("#items").html("");
        const request = $.ajax({
            url: '../ajax/questions/by_user.php',
            method: "get",
            dataType: "xml",
        });

        request.done(function(response) {
            console.log(response);
            const res = $(response).find("question");
            for (let i = 0; i < res.length; i++) {
                const element = $(res[i]);
                const id = element.find("answerId").text();
                const question_id = element.find("questionId").text();
                const question = element.find("questions").text();


                $("#items").append(`
                <div class="col col-md-3 mb-4 ">
                    <div class="card" style="border : 1px solid black">
                        <div class="card-body">
                            <h5 class="card-title">${question}</h5> 
                            <a href="../question?id=${question_id}" class="btn btn-primary">Go To Question</a>
                        </div>
                    </div>
                </div>
                `);
            }

        });

        request.fail(function(jqXHR, textStatus) {
            console.log(jqXHR, textStatus);
        });
    }


    $(window).ready(function() {
        getAnswer();
        $("button.toggle").click(function() {
            const request = $(this).data("name");

            if (request === 'questions') {
                getQuestion()
            } else {
                getAnswer()
            }


        })
    })
</script>

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

</html>