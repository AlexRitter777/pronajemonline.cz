<?php

namespace app\controllers\user;

use app\controllers\AppController;
use Exception;
use RedBeanPHP\R;

class DataController extends AppController
{


    /**
     * @throws Exception
     */
    public function getselectitemslistAction(){

        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'GET') {

                if (!is_user_logged_in()) {
                    die();
                }
                $userID = $_SESSION['user_id'];
                $result = [];
                $request = $_GET['term'];
                $table = $_GET['table'];

                if (isset($request)) {

                    if($table === 'property'){

                        $records = R::getAll("SELECT id,address FROM {$table} WHERE (address LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

                            foreach ($records as $k => $v) {
                            $result[] = [
                                "id" => $v['address'],
                                "text" => $v['address'],
                                "record_id" => $v['id']
                            ];
                        }
                     } else {
                        $records = R::getAll("SELECT id,name FROM {$table} WHERE (name LIKE '%" . $_GET['term']['term'] . "%') AND (user_id = :user_id)", [':user_id' => $userID]);

                        foreach ($records as $k => $v) {
                            $result[] = [
                                "id" => $v['name'],
                                "text" => $v['name'],
                                "record_id" => $v['id']
                            ];
                        }


                    }

                    echo json_encode($result);
                    die();
                }

                return null;
            }
        }

        throw new Exception('Stránka není nalezená', 404);

    }

    public function getitemvalueAction(){

        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                if (!is_user_logged_in()) {
                    die();
                }
                $userID = $_SESSION['user_id'];
                $value='';
                if(!empty($_POST['id']) && !empty($_POST['field']) && !empty($_POST['table'])) {
                    $id = $_POST['id'];
                    $field = $_POST['field'];
                    $table = $_POST['table'];

                    $item = R::findOne($table, 'id=? AND user_id=?', [$id, $userID]);
                    $value = $item->$field;

                }


                    echo json_encode($value);
                    die();


                //return null;
            }
        }

        throw new Exception('Stránka není nalezená', 404);


    }

    /**
     * @throws Exception
     */
    public function getuniqvaluesAction(){

        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method GET
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                if (!is_user_logged_in()) {
                    die();
                }
                $userID = $_SESSION['user_id'];
                $uniqueValues = null;
                if(!empty($_POST['table']) && !empty($_POST['column'])) {

                    $table = $_POST['table'];
                    $column = $_POST['column'];

                    // Vytvoření dotazu
                    $query = 'SELECT DISTINCT ' . $column . ' FROM ' . $table . ' WHERE user_id = :userid';

                    // Vykonání dotazu s parametrem
                    $uniqueValues = R::getAll($query, [ ':userid' => $userID ]);

                }


                echo json_encode($uniqueValues);
                die();


                //return null;
            }
        }

        throw new Exception('Stránka není nalezená', 404);


    }

}