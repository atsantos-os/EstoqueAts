<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Configurações</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
	<link rel="stylesheet" href="{{ asset('css/configuracoes.css') }}">
</head>
<body>
	
	@include('components.sidebar')
	<div class="main-content">
	<div class="container">
			<h2 class="configuracoes-title">Configurações</h2>
			<div class="logout-container logout-right">
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
					@csrf
					<button type="submit" class="logout-btn">
						<span class="logout-icon">
							<!-- SVG logout moderno -->
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
								<path d="M16 17l1.41-1.41L13.83 12H21v-2h-7.17l3.58-3.59L16 7l-5 5 5 5z"/>
								<path d="M19 19H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7z"/>
							</svg>
						</span>
						Sair
					</button>
				</form>
			</div>
			<div class="configuracoes-logs">
				<h3 class="configuracoes-logs-title">@if(isset($usuario) && $usuario->is_admin) Todas as ações @else Minhas ações @endif</h3>
				@if(isset($usuario) && $usuario->is_admin)
				<form method="GET" action="" class="filtro-logs-form">
					<select name="usuario_id" class="filtro-usuario">
						<option value="">Todos os usuários</option>
						@foreach($usuarios as $u)
							<option value="{{ $u->id }}" @if(request('usuario_id') == $u->id) selected @endif>{{ $u->nome }}</option>
						@endforeach
					</select>
					<select name="acao" class="filtro-acao">
						<option value="">Todas as ações</option>
						@foreach($acoes as $acao)
							<option value="{{ $acao }}" @if(request('acao') == $acao) selected @endif>{{ $acao }}</option>
						@endforeach
					</select>
					<button type="submit" class="btn-filtrar">Filtrar</button>
				</form>
				@endif
				<table class="tabela-logs">
					<thead>
						<tr>
							<th>Data</th>
							<th>Usuário</th>
							<th>Ação</th>
							<th>Detalhes</th>
							<th>IP</th>
						</tr>
					</thead>
					<tbody>
					@forelse($logs as $log)
						<tr>
							<td>{{ date('d/m/Y H:i', strtotime($log->created_at)) }}</td>
							<td>{{ $log->usuario->nome ?? '-' }}</td>
							<td>{{ $log->acao }}</td>
							<td>{{ $log->detalhes }}</td>
							<td>{{ $log->ip }}</td>
						</tr>
					@empty
						<tr><td colspan="5" class="nenhuma-acao" style="text-align:center;">Nenhuma ação registrada.</td></tr>
					@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
