<?php require_once '../middleware/is_not_login.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/login.css">
	<title>Login</title>
	<link rel="icon" href="../assets/logo.png" type="image/icon type">
</head>

<body>

	<main>
		<br>

		<h2 class="f_line"> <b>Selamat datang kembali</b> </h2>
		<p class="s_line"> Lakukan login agar dapat mengajukan pertanyaan dan memberikan jawaban </p>
		<br><br>

		<form name="formLogin" method="post" onsubmit="return submitLogin()">

			<input type="text" name="username" id="username" placeholder="username" />
			<br><br>

			<input type="password" name="password" id="password" placeholder="password" />
			<br><br>

			<input type="submit" class="btn-login" value="MASUK" name="masuk" /> <br><br>

			<input type="checkbox" name="remember" value="yes" checked="checked"> Remember Me
		</form>
		<br>

		<p> Belum punya akun ?
			<a href="../register"> <strong> DAFTAR !</strong> </a>
		</p>
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
			<a href="https://instagram.com/michaelasheren_?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="michaelasheren_ ig" width="20" height="20"></a>
			<a href="https://instagram.com/bryanimanuell17?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="bryanimanuell17 ig" width="20" height="20"></a>
			<a href="https://instagram.com/feliciakiani?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="feliciakiani ig" width="20" height="20"></a>
			<a href="https://instagram.com/_rayjoo?igshid=YmMyMTA2M2Y= " target="_blank"> <img src="../assets/ig_icon.png" alt="rayjo ig" width="20" height="20"></a>


		</div>

		<div class="container emailUs">
			<div class="left">
				<h2>Contact Us</h2>
			</div>
			<div class="right">
				<form>
					<input type="email" name="emailContactUs" id="emailContactUs" placeholder="Enter your email" /> <br>
					<textarea name="message" id="message" rows="4" cols="70"> Enter message :</textarea> <br>
					<input type="submit" value="Send Email" name="sendEmail" />
				</form>
			</div>
		</div>

	</footer>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
	<script>
		function submitLogin() { // agar tidak auto load
			var username = $("#username").val();
			var password = $("#password").val();

			if (username.length == "") {
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

			} else {
				$.ajax({
					url: "../login/cek-login.php",
					type: "POST",
					data: {
						"username": username,
						"password": password
					},
					success: function(response) {
						console.log(response);
						if (response == "success") {

							Swal.fire({
									type: 'success',
									title: 'Login Berhasil!',
									text: 'Anda akan di arahkan dalam 3 Detik',
									timer: 3000,
									showCancelButton: false,
									showConfirmButton: false
								})
								.then(function() {
									setTimeout(() => {
										window.location.href = "/tubes/main";
									}, 3000)

								});

						} else {

							Swal.fire({
								type: 'error',
								title: 'Login Gagal!',
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

						console.log(response);

					}

				});

			}
			return false;
		};
	</script>
</body>

</html>