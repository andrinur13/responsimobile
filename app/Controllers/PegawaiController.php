<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PegawaiModel;

class PegawaiController extends ResourceController
{
    protected $modelPegawai;

    public function __construct()
    {
        $this->modelPegawai = new PegawaiModel();
    }



    public function index()
    {
        $query = $this->modelPegawai->findAll();

        if ($query != null) {
            return $this->respond([
                'status' => 'success',
                'data' => $query
            ]);
        } else {
            return $this->respond([
                'status' => 'failed',
                'messages' => 'data not found!'
            ]);
        }
    }



    public function indexid()
    {
        $id = $this->request->getRawInput('id');

        if (isset($id['id'])) {
            $query = $this->modelPegawai->find($id['id']);

            if ($query != null) {
                return $this->respond([
                    'status' => 'success',
                    'data' => $query
                ]);
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'data not found!'
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
            'email' => 'required|valid_email|is_unique[pegawai.email]',
            'name' => 'required',
            'alamat' => 'required'
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->respond([
                'status' => 'failed',
                'errors' => $validation->getErrors()
            ], 400);
        }

        $datainputan = [
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
            'alamat' => $this->request->getVar('alamat')
        ];

        $this->modelPegawai->insert($datainputan);

        return $this->respond([
            'status' => 'success',
            'messages' => 'success added data!',
            'data' => $datainputan
        ]);
    }



    public function editData()
    {
        $datareq = $this->request->getRawInput();

        if (isset($datareq['id'])) {
            $query = $this->modelUserType->find($datareq['id']);

            helper('form');

            $datainputan = [
                'email' => isset($datareq['email']) ? $datareq['email'] : $query['email'],
                'name' => isset($datareq['name']) ? $datareq['name'] : $query['name'],
                'alamat' => isset($datareq['alamat']) ? $datareq['alamat'] : $query['alamat']
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
        $id = $this->request->getRawInput();

        if (isset($id['id'])) {
            $query = $this->modelPegawai->find($id['id']);

            if ($query == null) {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => 'id not found!'
                ]);
            } else {
                $this->modelPegawai->delete($id['id']);

                return $this->respond([
                    'status' => 'success',
                    'messages' => 'success deleted with id ' . $id['id'],
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
