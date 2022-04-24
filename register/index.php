<?php require_once '../middleware/is_not_login.php'; ?>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link rel="icon" href="../assets/logo.png" type="image/icon type">
	<link rel="stylesheet" href="../assets/css/register.css">

</head>

<body>
	<p class="f_line"><b> Ayo Lakukan Register!</b></p>
	<p class="s_line"> Lakukan register agar dapat memiliki akun </p>

	<form id="formRegister" method="post" onsubmit="return submitRegister()">
		<input type="email" name="email" id="input" class="email" placeholder="email" />
		<p></p>

		<input type="text" name="username" id="input" class="username" placeholder="username" onkeyup="showHint(this.value, '../register/usernameHints.php', 'txtHintUsername')" />
		<p style='color:red;' id="txtHintUsername"></p>

		<input type="password" name="password" id="input" class="password" placeholder="password (min: 8 characters)" onkeyup="showHint(this.value, '../register/passwordHints.php', 'txtHintPassword')" />
		<p id="txtHintPassword"></p>

		<button type="submit" id="regist" class="btn-register" name="register"><b>register</b></button>

	</form>

	<p> Sudah punya akun?<a href="login.php" id="login"> MASUK</a></p>

	<footer>
		<div class="container">
			<h3>CREATOR</h3>
			<p>@michaelasheren</p>
			<p>@bryanimanuel</p>
			<p>@feliciakiani</p>
			<p>@rayjo</p>
		</div>

		<div class="container">
			<h3>About Company</h3>
			<p>_____</p>
			<p>Address : Jalan AskFM </p>
			<p>Social Links : </p>
			<a href="https://instagram.com/michaelasheren_?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="michaelasheren_ ig" width="20" height="20"></a>
			<a href="https://instagram.com/bryanimanuell17?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="bryanimanuell17 ig" width="20" height="20"></a>
			<a href="https://instagram.com/feliciakiani?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="feliciakiani ig" width="20" height="20"></a>
			<a href="https://instagram.com/_rayjoo?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="rayjo ig" width="20" height="20"></a>
		</div>

		<div class="container emailUs">
			<div class="left">
				<h3>Contact Us</h3>
			</div>
			<div class="right">
				<form>
					<input type="email" name="emailContactUs" id="emailContactUs" placeholder="Enter your email" /> <br>
					<textarea name="message" id="message" rows="2" cols="50"> Enter message :</textarea> <br>
					<input type="submit" value="Send Email" name="sendEmail" />
				</form>
			</div>
		</div>
	</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
	<script>
		function submitRegister() { // agar tidak auto load
			$(document).ready(function() {

				$(".btn-register").click(function() {

					var email = $(".email").val();
					var username = $(".username").val();
					var password = $(".password").val();

					if (email.length == "") {

						Swal.fire({
							type: 'warning',
							title: 'Oops...',
							text: 'Email Wajib Diisi !'
						});

					} else if (username.length == "") {

						Swal.fire({
							type: 'warning',
							title: 'Oops...',
							text: 'Username Wajib Diisi !'
						});

					} else if (password.length == "") {

						Swal.fire({
							type: 'warning',
							title: 'Oops...',
							text: 'Password Wajib Diisi !'
						});

					} else if (password.length < 8) {

						Swal.fire({
							type: 'warning',
							title: 'Oops...',
							text: 'Password Minimal 8 karakter !'
						});

					} else {

						//ajax
						$.ajax({
							url: "./submit-register.php",
							type: "POST",
							data: {
								"email": email,
								"username": username,
								"password": password
							},

							success: function(response) {
								if (response == "success") {
									Swal.fire({
										type: 'success',
										title: 'Register Berhasil!',
										text: 'silahkan login!'
									});

									$("#email").val('');
									$("#username").val('');
									$("#password").val('');

									window.location.replace("/tubes/login");
								} else if (response == "cannot") {

									Swal.fire({
										type: 'error',
										title: 'Register Gagal!',
										text: 'username sudah digunakan orang lain! silahkan coba lagi!'
									});

								} else {

									Swal.fire({
										type: 'error',
										title: 'Register Gagal!',
										text: 'silahkan coba lagi!'
									});

								}

							},

							error: function(response) {
								Swal.fire({
									type: 'error',
									title: 'Opps!',
									text: 'server error!'
								});
							}

						})

					}

				});

			});
			return false; //untuk memastikan halaman ga ke reload walau sudah submit
		};

		function showHint(str, pageTo, pTo) {
			if (str.length == 0) {
				document.getElementById(pTo).innerHTML = "";
				return;
			}
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById(pTo).innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", pageTo + "?q=" + str, true);
			xmlhttp.send();
		}
	</script>
</body>




</html>