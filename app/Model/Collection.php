<?php

class Collection extends AppModel {

	//     public $useTable = 'game_info';
	public $primaryKey = 'id';

	//     public $belongsTo = array(
	//         'User' => array(
	//             'className' => 'User',
	//             'foreignKey' => 'user_id'
	//         )
	//     );


	public function isOwnedBy($id, $user) {
		return $this->field('id', array(
				'id' => $id,
				'user_id' => $user
			)) !== false;
	}


}

;


?>


