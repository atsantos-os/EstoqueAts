<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="{{ asset('css/login.css') }}">
	<script>
	// Máscara para CPF
	function mascaraCPF(input) {
		let value = input.value.replace(/\D/g, "");
		value = value.replace(/(\d{3})(\d)/, "$1.$2");
		value = value.replace(/(\d{3})(\d)/, "$1.$2");
		value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
		input.value = value;
	}
	</script>
</head>
<body>
	<div class="login-main-container">
		<div class="login-left">
			<div class="login-container">

				<h2 style="margin-bottom:0.3rem;">Controle de Estoque</h2>
				<div style="text-align:center;margin-bottom:1.1rem;">
					<span style="display:inline-block;font-size:1.05rem;color:#222;font-weight:500;line-height:1.3;">Acesse sua conta para gerenciar o estoque<br><span style='color:#3c97c1;font-weight:400;'>Realize o login para continuar</span></span>
				</div>
				<form method="POST" action="{{ url('/login') }}">
					@csrf
					<div class="form-group">
						<label for="cpfUsuario">CPF</label>
						<div class="input-icon">
							<i class="fa-solid fa-id-card"></i>
							<input type="text" id="cpfUsuario" name="cpfUsuario" maxlength="14" placeholder="000.000.000-00" required oninput="mascaraCPF(this)">
						</div>
					</div>
					<div class="form-group">
						<label for="senha">Senha</label>
						<div class="input-icon" style="position:relative;">
							<i class="fa-solid fa-lock"></i>
							<input type="password" id="senha" name="senha" placeholder="Digite sua senha" required style="padding-right:2.2rem;">
							<button type="button" id="toggleSenha" style="background:none;border:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;padding:0;">
								<i class="fa-regular fa-eye" id="eyeIcon"></i>
							</button>
						</div>
					</div>
					<button type="submit" class="btn-login">Entrar</button>
					@if($errors->any())
						<div class="login-error">
							{{ $errors->first('msg') }}
						</div>
					@endif
				</form>
			</div>
		</div>
		<div class="login-right">
			<img src="https://atsantos.com.br/wp-content/uploads/2025/09/15639931-conceito-de-sistema-de-controle-de-estoque-gerente-profissional-verificando-mercadorias-e-estoque-gerenciamento-de-estoque-com-demanda-de-mercadorias-vetor.jpg" alt="imagem ats" class="login-image">
		</div>
	</div>
<script>
	const senhaInput = document.getElementById('senha');
	const toggleSenha = document.getElementById('toggleSenha');
	const eyeIcon = document.getElementById('eyeIcon');
	toggleSenha.addEventListener('click', function() {
		if (senhaInput.type === 'password') {
			senhaInput.type = 'text';
			eyeIcon.classList.remove('fa-eye');
			eyeIcon.classList.add('fa-eye-slash');
		} else {
			senhaInput.type = 'password';
			eyeIcon.classList.remove('fa-eye-slash');
			eyeIcon.classList.add('fa-eye');
		}
	});
</script>
</body>
</html>
