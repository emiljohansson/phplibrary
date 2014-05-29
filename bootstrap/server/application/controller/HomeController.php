<?php

class HomeController extends Controller {
	public function initView() {
		$this->view = new View();
		$this->view->add(new Label("Hello World"));
	}
}