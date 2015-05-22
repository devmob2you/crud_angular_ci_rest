<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Chamando biblioteca REST
require_once APPPATH."/libraries/REST_Controller.php";

class Books extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('books_model');
	}

	public function index_get($id = NULL)	{
		if(is_null($id)){
			$books = $this->books_model->get();
			if(!is_null($books)){
				$this->response(array("response" => $books), 200);
			}else{
				$this->response(array("error" => "Nenhum livro encontrado"), 404);
			}
		}else{
			$this->response(array("error" => "Passando ID onde não deveria"), 404);
		}
	}

	public function find_get($id){
		$book = $this->books_model->get($id);

			if(!is_null($book)){
				$this->response(array("response" => $book), 200);
			}else{
				$this->response(array("error" => "Livro não encontrado"), 404);
			}
	}

	public function index_post()	{
		if(!$this->post("book")){
			$this->response(array("error" => "Nenhum livro informado"), 404);
		}

		$bookId = $this->books_model->save($this->post("book"));

		if(!is_null($bookId)){
			$this->response(array("response" => $bookId), 200);
		}else{
			$this->response(array("error" => "Erro ao inserir registro"), 400);
		}
	}

	public function index_put($id)	{
		if(!$this->put("book") || !$id){
			$this->response(array("error" => "Nenhum livro informado"), 400);
		}

		$update = $this->books_model->update($id, $this->put("book"));

		if(!is_null($update)){
			$this->response(array("response" => "Livro registro atualizado com sucesso!"), 200);
		}else{
			$this->response(array("error" => "Erro ao inserir registro"), 400);
		}
	}

	public function index_delete($id)	{
		if(!$id){
			$this->response(array("error" => "ID não informado"), 400);
		}

		$delete = $this->books_model->delete($id);

		if(!is_null($delete)){
			$this->response(array("response" => "Registro {$delete} excluído com sucesso!"), 200);
		}else{
			$this->response(array("error" => "Erro ao excluir registro"), 400);
		}
	}
}
