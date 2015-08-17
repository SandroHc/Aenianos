<?php

use App\Models\News;

class NewsTest extends TestCase {

	public function testExample() {
		$news = new News();

		$news->title = "The title";
		$news->text = "The article.";
		$news->id_category = 1;

		$this->assertSame('The title', $news->title);
		$this->assertSame('the-title', $news->slug);
		$this->assertSame('The article.', $news->text);
		$this->assertSame(1, $news->id_category);
	}

	public function testCapitalizedTitle() {
		$news = new News();

		$news->title = "título de teste";

		$this->assertSame('Título de teste', $news->title);
	}

	public function testSlugURL() {
		$news = new News();

		$news->title = "título de teste";

		$this->assertSame('titulo-de-teste', $news->slug);
	}
}
