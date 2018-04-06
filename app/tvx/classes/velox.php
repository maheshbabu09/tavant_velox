<?php
class Velox {

    private $_db;

    function __construct($db){
    	$this->_db = $db;
    }

	public function get_velox_page($page_id){
		try {
			$stmt = $this->_db->prepare('SELECT * FROM velox_page WHERE id = :id');
			$stmt->execute(array('id' => $page_id));
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	public function get_velox_pages(){
		try {
			$stmt = $this->_db->prepare('SELECT id,title FROM velox_page');	
			$stmt->execute();
			return $stmt->fetchAll();
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	public function create_page($form_data){
		try {
			$stmt = $this->_db->prepare("INSERT INTO `velox_page` (`title`, `content`, `url_alias`) VALUES (:title, :content, :url_alias)");
			$stmt->execute(array(
							':title' => $form_data['title'],
							':content' => $form_data['content'],
							':url_alias' => $form_data['url_alias']
						));
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	public function update_page($form_data,$page_id){	
		try {
			$stmt = $this->_db->prepare("UPDATE `velox_page` 
								SET title = :title, 
								content = :content,
								url_alias = :url_alias,
								last_revision = :last_revision
								WHERE id = :id");
			$stmt->execute(array(
					':title' => $form_data['title'],
					':content' => $form_data['content'],
					':url_alias' => $form_data['url_alias'],
					':last_revision' => $form_data['last_revision'],
					':id' => $page_id,
				));
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	public function remove_page($page_id) {
		try {
			$stmt = $this->_db->prepare('DELETE FROM velox_page WHERE id = :id');
			if($stmt->execute(array('id' => $page_id))) return true; else return false;
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
}
?>
