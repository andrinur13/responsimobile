<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use UserTypeModel;

class UserTypeController extends ResourceController
{

    private $modelUserType;

    public function __construct()
    {
        $this->modelUserType = new UserTypeModel();
    }

    public function index()
    {
        $query = $this->modelUserType->findAll();

        if ($query != null) {
            return $this->respond([
                'status' => 'success',
                'data' => $query
            ]);
        } else {
            return $this->respond([
                'status' => 'false',
                'messages' => 'data not found!'
            ]);
        }
    }


    public function indexid()
    {
        $id = $this->request->getRawInput();

        if(isset($id['id'])) {
            $query = $this->modelUserType->find($id);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found!'
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


    public function insertData()
    {
        helper('form');

        $rules = [
            'type' => 'required|min_length[1]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        $datainputan = [
            'type' => $this->request->getVar('type')
        ];

        $this->modelUserType->insert($datainputan);

        return $this->respond([
            'status' => 'success',
            'messages' => 'success added data!',
            'data' => $datainputan
        ]);
    }


    public function editData()
    {
        $datareq = $this->request->getRawInput();

        if(isset($datareq['id'])) {
            $query = $this->modelUserType->find($datareq['id']);

            helper('form');
    
            $datainputan = [
                'type' => isset($datareq['type']) ? $datareq['type'] : $query['type']
            ];

            $this->modelUserType->update($datareq['id'], $datainputan);


            return $this->respond([
                'status' => 'success',
                'data' => $datainputan
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        }
    }


    public function deleteData()
    {
        $datareq = $this->request->getRawInput();

        if(isset($datareq['id'])) {
            $query = $this->modelUserType->find($datareq['id']);

            if($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found!'
                ]);
            } else {
                // delete datanya
                $this->modelUserType->delete($datareq['id']);
                return $this->respond([
                    'status' => 'success',
                    'messages' => 'deleted with id ' . $datareq['id']
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
