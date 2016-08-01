<?php

use Illuminate\Database\Seeder;
use App\Models\Anime;
use App\Models\Episode;

class AnimeTableSeeder extends Seeder {

	public function run() {
		Anime::create([
			'title' => 'Shigatsu wa Kimi no Uso',
			'japanese' => '四月は君の嘘',
			'episodes' => '22',
			'premiered' => 'Outono 2014',
			'synopsis' => '<p>Arima Kousei é um ex-prodígio musical que perdeu a
habilidade de tocar piano depois que sua mãe, que também era sua
instrutora, faleceu.
</p>
<p>Sua vida agora é monótona, mas ela começa a ganhar
cor quando ele conhece uma violinista por acaso. Miyazono Kaori é uma
garota audaciosa e determinada cuja personalidade transborda.
</p>
<p>Encantado
pela garota, Kousei, nos seus 14 anos, começa a seguir em frente com
suas próprias pernas.
</p>',
			'status' => 'Concluído',
		]);

		Anime::create([
			'title' => 'Sword Art Online',
			'synopsis' => '<p>Escapar é impossível até o jogo ser completado, um <em>
	game over </em>significa uma verdadeira morte. Sem saber a verdade da
misteriosa nova geração do RPG, Sword Art Online, aproximadamente 10 mil
 jogadores logaram juntos, abrindo as cortinas para essa cruel batalha
mortal.
</p>
<p>Jogando sozinho, o protagonista Kirito imediatamente aceitou a
verdade desse RPG, e no mundo do jogo, em um castelo flutuante gigante
chamado Aincrad, ele se distinguiu como um jogador solitário. Buscando
completar o jogo alcançando o andar mais alto, Kirito arriscadamente
continua sozinho. Por causa de um convite agressivo de uma guerreira e
especialista em esgrima, Asuna, ele se juntou a ela.
</p>
<p>Esse encontro
trouxe uma oportunidade para chamar pelo destinado Kirito.
</p>',
			'status' => 'Concluído',
		]);

		$ep = 1;
		$ep_titles = [
			'Monotone/Colorful', 'Friend A', 'Inside Spring', 'The Journey', 'Gray Skies', 'On the Way Home', 'The Shadows Whisper', 'Let It Ring', 'Resonance', 'The Scenery I Shared with You', 'Light of Life', 'Twinkle Little Star', 'Love\'s Sorrow', 'Footprints', 'Liar', 'Two of a Kind', 'Twilight', 'Hearts Come Together', 'Goodbye, Hero', 'Hand in Hand', 'Snow', 'Spring Wind',
		];

		foreach($ep_titles as $title) {
			Episode::create([
				'anime' => 'shigatsu-wa-kimi-no-uso',
				'type' => 'Episódio',
				'num' => $ep++,
				'title' => $title
			]);
		}

		Episode::create([
			'anime' => 'shigatsu-wa-kimi-no-uso',
			'type' => 'Especial',
			'num' => 1,
			'title' => 'Moments'
		]);

		//factory(Anime::class, 10)->create();
	}
}
