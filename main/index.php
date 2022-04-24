<?php require_once '../middleware/is_login.php'; ?>
<?php
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/frame5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Main Menu</title>
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
                <a class="navbar-brand" href="../profile">
                    <img src="../<?= $_SESSION['users']['pic_profile'] ?>" width="30" height="30" alt="" style="border-radius:50%; border:1px solid black">
                </a>
            </span>
        </div>
    </nav>
    <hr>
    <div class="group1">
        <div class="frame5">
            <div class="category" id="categories">
                <h3><u>Mata Pelajaran</u></h3>
                <h4><a href="">Semua Mapel</a> </h4>
            </div>

            <div class="boxBawah border-black-2">
                <div class="header border-black-1">
                    <img src="../assets/logo_head.png" alt="Logo head" class="header-img">
                    <p class="title">AYO BANTU TEMAN-TEMAN <br />YANG LAIN <b>MENDAPATKAN JAWABAN !</b></p>
                </div>

                <div class="items" id="items">
                </div>
            </div>
            <div class="side-right">
                <div class="card">
                    <div class="profile">
                        <img src="../<?= $_SESSION['users']['pic_profile'] ?>" alt="profile" style="border-radius:50%; border:1px solid black">
                        <div class="profile-data">
                            <p><?= $_SESSION['users']['username'] ?></p>
                            <p class="umur"><?= $_SESSION['users']['age'] ?> Tahun</p>
                        </div>
                    </div>
                    <div class="link-profile">
                        <a href="../profile/">Pertanyaan yang pernah dijawab ></a>
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
                <textarea id="questions"></textarea>
                <select id="category-menu">
                </select>
                <button onclick="addQuestion()">TANYAKAN PERTANYAAMU</button>
            </div>
        </div>
    </div>
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
    <script>
        function getDataQuestions(category_id) {
            $("#items").html("");
            let path = "/tubes/ajax/questions"

            if (category_id) {
                path += `/tubes/ajax/questions?category_id=${category_id}`;
            }

            const request = $.ajax({
                url: path,
                method: "get",
                dataType: "xml",
            });

            request.done(function(response) {
                const res = $(response).find("question");
                for (let i = 0; i < res.length; i++) {
                    const element = $(res[i]);
                    const id = element.find("questionId").text();
                    const username = element.find("username").text();
                    const categoryName = element.find("classCategoryName").text();
                    const questions = element.find("questions").text();
                    const pict_profile = element.find("pic_profile").text();

                    $("#items").append(`<div class="item border-black-1">
                        <div class="profile">
                            <img src="../${pict_profile}" alt="profile" >
                            <div class="profile-subject">
                                <h2 class="name">${username}</h2>
                                <p class="subject">${categoryName}</p>
                            </div>
                        </div>
                        <div class="question">
                            <h3>${questions}</h3>
                        </div>
                        <div class="button">
                            <a href="../question?id=${id}" class="btn-white">Jawab</a>
                        </div>
                    </div>`);
                }

            });

            request.fail(function(jqXHR, textStatus) {
                // console.log(jqXHR, textStatus);
            });
        }

        function getdataCategory() {
            $("#category-menu").html("");
            const request = $.ajax({
                url: "/tubes/ajax/category",
                method: "get",
                dataType: "xml",
            });

            request.done(function(response) {
                const res = $(response).find("category");
                for (let i = 0; i < res.length; i++) {
                    const element = $(res[i]);
                    const id = element.find("id").text();
                    const name = element.find("name").text();
                    const created_at = element.find("created_at").text();
                    const updated_at = element.find("updated_at").text();
                    $("#categories").append(`<h4 class="category" data-id="${id}">${name}</h4>`)
                    $("#category-menu").append(`<option value="${id}">${name}</option>`);
                }

                $("#categories .category").click(function() {
                    getDataQuestions($(this).data("id"));
                })

            });

            request.fail(function(jqXHR, textStatus) {
                console.log(jqXHR, textStatus);
            });
        }

        function addQuestion() {
            const category = $("#category-menu").val();
            const question = $("#questions").val();
            if (category && question) {
                const request = $.ajax({
                    url: `/tubes/ajax/questions?type=add&category_id=${category}&questions=${question}`,
                });

                request.done(function(response) {
                    $("#modal-question").css("d-none")
                    location.reload();

                });
            }


        }

        $(document).ready(function() {
            getdataCategory();
            getDataQuestions();
        })
    </script>
</body>

</html>