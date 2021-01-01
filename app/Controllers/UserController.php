<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use UserModel;

use function PHPSTORM_META\map;

class UserController extends ResourceController
{

    protected $modelDataUser;

    public function __construct()
    {
        $this->modelDataUser = new UserModel();
    }



    public function index()
    {
        $query = $this->modelDataUser->findAll();

        if($query == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'data not found!'
            ]);
        } else {
            return $this->respond([
                'status' => 'success',
                'data' => $query
            ]);
        }
    }


    public function indexid()
    {
        $id = $this->request->getRawInput();

        if(isset($id['id'])) {
            $query = $this->modelDataUser->find($id['id']);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'data not found!'
                ]);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => $query
                ]);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        }
    }



    public function username()
    {
        $username = $this->request->getVar('username');

        if($username == null) {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an username!'
            ]);
        } else {
            $query = $this->modelDataUser->cariPegawai($username);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'username not found!'
                ]);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => $query
                ]);
            }
        }
    }


    public function insertData()
    {
        helper('form');

        $rules = [
            'username' => 'required|is_unique[user.username]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'name' => 'required',
            'password' => 'required',
            'user_type' => 'required'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        $datainputan = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'user_type' => $this->request->getVar('user_type')
        ];

        $this->modelDataUser->insert($datainputan);

        return $this->respond([
            'status' => 'success',
            'data' => $datainputan
        ]);
    }



    public function editData()
    {
        $id = $this->request->getRawInput();

        if(isset($id['id'])) {
            $query = $this->modelDataUser->find($id['id']);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'data not found!'
                ]);
            } else {
                // data ada
                $dataedit = [
                    'username' => isset($id['username']) ? $id['username'] : $query['username'],
                    'email' => isset($id['email']) ? $id['email'] : $query['email'],
                    'name' => isset($id['name']) ? $id['name'] : $query['name'],
                    'password' => isset($id['password']) ? password_hash($id['password'], PASSWORD_DEFAULT) : $query['password'],
                    'user_type' => isset($id['user_type']) ? $id['user_type'] : $query['user_type']
                ];

                $this->modelDataUser->update($id['id'], $dataedit);

                return $this->respond([
                    'status' => 'success',
                    'messages' => 'data has been updated!',
                    'data' => $dataedit
                ]);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        }
    }



    public function deleteData()
    {
        $id = $this->request->getRawInput();

        if(isset($id['id'])) {
            // delete lah skrg
            $query = $this->modelDataUser->find($id['id']);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found!'
                ]);
            } else {

                $this->modelDataUser->delete($id['id']);

                return $this->respond([
                    'status' => 'success',
                    'messages' => 'success deleted data with id ' . $id['id']
                ]);
            }
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        }
    }

}

?>