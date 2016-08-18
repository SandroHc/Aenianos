@extends('card')

<?php $current_section = "FAQ" ?>

@section('title', 'Perguntas frequentes')

@section('text')
	<section>
		<h4>Dúvidas gerais</h4>
		<nav>
			<ol>
				<li><a href="#gerais_1">Não consigo fazer downloads pelo link direto. O que fazer?</a></li>
				<li><a href="#gerais_2">Como faço downloads via Torrent?</a></li>
				<li><a href="#gerais_3">Vocês aceitam doações?</a></li>
				<li><a href="#gerais_4">Vocês aceitam parcerias?</a></li>
				<li><a href="#gerais_5">Posso mandar e-mails ou comentar cobrando alguma coisa e/ou reclamando de atrasos?</a></li>
				<li><a href="#gerais_6">Vocês aceitam sugestões?</a></li>
				<li><a href="#gerais_7">Vocês recrutam novas pessoas pra equipe frequentemente?</a></li>
				<li><a href="#gerais_8">Não consigo reproduzir o MQ. Qual o problema?</a></li>
			</ol>
		</nav>

		<h5><a name="gerais_1">Não consigo fazer downloads pelo link direto. O que fazer?</a></h5>
		<p>Geralmente, isso se deve ao navegador usado. Mozilla Firefox não demonstra problemas com o nosso link direto, mas o Google Chrome costuma verificar a origem, e é isso que faz com que a “tela preta com o play” apareça. Nesse caso, existem duas opções: No Google Chrome, seria dar um clique direto no tal botão de play, clicar em “Salvar vídeo como”, escolher qualquer local pra salvar e salvar, ou já dar esse clique diretamente sobre o link na página onde os episódios estão listados. A outra opção é usar outro navegador pra baixar.</p>

		<h5><a name="gerais_2">Como faço downloads via Torrent?</a></h5>
		<p>Nós usamos o Fansubber 2.0, que é um tracker privado, logo, é necessário que você tenha cadastro no tracker pra efetuar downloads. Faça um cadastro e baixe o arquivo torrent, e não se esqueça de ser seed também (upar o arquivo pra quem também for baixar depois), pois o tracker impede que usuários com ratio menor que 0,3 façam downloads (quanto mais você upar o episódio, sejam os nossos ou quaisquer outros, maior é o seu ratio, e ele diminui sempre que você faz algum download).</p>

		<h5><a name="gerais_3">Vocês aceitam doações?</a></h5>
		<p>Sim, aceitamos. Qualquer valor é bem vindo. O nosso servidor é pago, o nosso domínio também, e às vezes essa ajuda pode nos livrar na hora do aperto.</p>

		<h5><a name="gerais_4">Vocês aceitam parcerias?</a></h5>
		<p>Sim, aceitamos. Seja troca de botões ou lançamentos em conjunto. Qualquer oferta é só entrar em contato.</p>

		<h5><a name="gerais_5">Posso mandar e-mails ou comentar cobrando alguma coisa e/ou reclamando de atrasos?</a></h5>
		<p>Pode. Claro que pode. Só não espere resposta. Comentários desse tipo quase sempre serão deletados. Temos a política de sempre avisar se algo for atrasar além da conta e quando postamos costumamos dizer por quais motivos ocorreu o atraso do que está sendo lançado, caso tenha mesmo atrasado. Não temos data fixa para nada, fazemos e lançamos quando podemos, e, por esse motivo, perguntas desse tipo não serão respondidas a menos que seja sobre algo muito, muito antigo. Não deixamos ninguém no branco esperando por nada, por isso sequer nos damos ao trabalho de responder cobranças.</p>

		<h5><a name="gerais_6">Vocês aceitam sugestões?</a></h5>
		<p>Sim, e às vezes até pedimos. Podem sugerir à vontade, mas entendam que não vamos poder fazer tudo o que nos sugerirem, mas às vezes, dependendo do que nos é sugerido, pode acontecer.</p>

		<h5><a name="gerais_7">Vocês recrutam novas pessoas pra equipe frequentemente?</a></h5>
		<p>Sim, estamos sempre de portas abertas. Caso surja um interesse, basta procurar um dos três projetistas do site (Chrono, Gabe ou Sales), cujos e-mails estão disponíveis no menu “Contato” ali em cima, dizendo o que sabe fazer ou no que está disposto a ajudar, e aí uma avaliação será feita.</p>

		<h5><a name="gerais_8">Não consigo reproduzir o MQ. Qual o problema?</a></h5>
		<p>Bom, após termos nossos arquivos em MQ deletados do servidor que costumamos usar para eles, o mediafire, decidimos tomar uma medida diferente com esses arquivos. Basicamente, nossos arquivos em MQ estão em um arquivo compactado sem extensão, ou seja, ao baixá-los, o windows não os reconhecerá pois eles não possuem extensão alguma. Assim que o episódio for baixado, vocês devem renomeá-lo, adicionando a extensão “.rar” ao arquivo. Por exemplo, se for baixar um arquivo nomeado “I”, você deve renomeá-lo para “I.rar”. Ao fazer isso, o arquivo se “transformará” em um arquivo zipado e você poderá abrir e reproduzir o episódio normalmente.</p>
	</section>

	<hr>

	<section>
		<h4>Dúvidas técnicas</h4>
		<nav>
			<ol>
				<li><a href="#tecnicas_1">Estou com problemas com o vídeo/áudio/legendas. Falhas aparecem na imagem durante a reprodução/está sem áudio/legendas não aparecem</a></li>
				<li><a href="#tecnicas_2">Uso o KMPLayer mas as legendas não aparecem direito</a></li>
			</ol>
		</nav>

		<h5><a name="tecnicas_1">Estou com problemas com o vídeo/áudio/legendas. Falhas aparecem na imagem durante a reprodução/está sem áudio/legendas não aparecem</a></h5>
		<p>Normalmente, isso é codec desatualizado ou com conflito. Tente atualizar os seus codecs, caso isso não funcione, desinstale todos os codecs instalados no seu computador e instale o <a href="http://www.cccp-project.net/" target="_blank">CCCP</a> ou o <a href="http://www.codecguide.com/" target="_blank">K-Lite Codec Pack</a>.</p>

		<h5><a name="tecnicas_2">Uso o KMPLayer mas as legendas não aparecem direito</a></h5>
		<p>KMPLayer é um player problemático nesse sentido, já que reproduz as legendas softsub de uma forma própria, e não como os fansubs as estilizam.</p>
		<p><b><a href="http://www.anbient.net/faq/como-exibir-legendas-estilizadasass-no-kmplayer" target="_blank">Aqui</a></b> tem um tutorial que mostra como resolver esse problema.</p>
	</section>
@endsection