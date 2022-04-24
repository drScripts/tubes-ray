<?php require_once './middleware/is_not_login.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ASK TM</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&family=Rozha+One&family=Rubik:wght@800&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="../assets/logoASKTM.png" class="headerFlex">
        <div class="links">
            <a href="/login">Masuk</a><a href="register">Daftar</a>
            <!-- YANG BERTANYA BELOM DI ISI MAU KEMANANYA -->
        </div>
    </header>
    <main>
        <h1>Dari bertanya jadi<br>mengerti</h1>
        <p>Ask TOO MUCH, adalah platform bagi para pelajar<br>untuk saling membantu memberi ilmu pelajaran</p>


        <img src="../assets/meme1.jpg">
        <?php
        require '../db/index.php';

        if (isset($_POST['submit'])) {
            if ($_POST['search'] != '') {
                // INI KALO PENCET TOMBOL YANG ABU BULET, KEMANANYA JUGA BELOM
            }
        }
        ?>
    </main>
    <footer>
        <div class="container">
            <h2>CREATOR</h2>
            <p>@michaelasheren</p>
            <p>@bryanimanuel</p>
            <p>@feliciakiani</p>
            <p>@rayjo</p>

        </div>

        <div class="container">
            <h2>About Company</h2>
            <p>_____</p>
            <p>Address : Jalan AskFM </p>
            <p>Social Links : </p>
            <a href="https://instagram.com/michaelasheren_?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="assets/ig_icon.png" alt="michaelasheren_ ig" width="20" height="20"></a>
            <a href="https://instagram.com/bryanimanuell17?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="assets/ig_icon.png" alt="bryanimanuell17 ig" width="20" height="20"></a>
            <a href="https://instagram.com/feliciakiani?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="assets/ig_icon.png" alt="feliciakiani ig" width="20" height="20"></a>
            <a href="https://instagram.com/_rayjoo?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="assets/ig_icon.png" alt="rayjo ig" width="20" height="20"></a>


        </div>

        <div class="container emailUs">
            <div class="left">
                <h2>Contact Us</h2>
            </div>
            <div class="right">
            <form>
                 <input type="email" name="myEmail" id="myEmail" placeholder="Enter your email" /> <br>
                 <textarea name="message" id="message" rows="2" cols="50"> Enter message :</textarea> <br>
                 <input type="submit" value="Send Email" name="sendEmail" onclick="sendEmail()"/>
             </form>
            </div>
        </div>

    </footer>
</body>

</html>