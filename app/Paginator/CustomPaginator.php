<?php
namespace App\Paginator;

use Illuminate\Pagination\BootstrapThreePresenter;

class CustomPaginator extends BootstrapThreePresenter {

	public function render() {
		if($this->hasPages()) {
			return sprintf(
				'<ul class="pagination">%s %s %s</ul>',
				$this->getPreviousButton('<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button>'),
				$this->getLinks(),
				$this->getNextButton('<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button>')
			);
		}

		return '';
	}
}