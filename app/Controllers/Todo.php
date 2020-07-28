<?php namespace App\Controllers;
    use App\Models\Mtodo;
    use CodeIgniter\RESTful\ResourceController;

    class Todo extends ResourceController
    {
    protected $format = 'json';
    protected $modelName = 'use App\Models\Mtodo';

    public function __construct()
    {
        $this->mtodo = new Mtodo();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    }

    public function index()
    {
        $mtodo = $this->mtodo->getTodo();

        foreach ($mtodo as $row) {
            $mtodo_all[] = [
                'id' => intval($row['id']),
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'no_telepon' => $row['no_telepon'],
            ];
        }

        return $this->respond($mtodo_all, 200);
    }

    public function create()
    {
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $no_telepon = $this->request->getPost('no_telepon');

        $data = [
            'nama' => $nama,
            'alamat' => $alamat,
            'no_telepon' => $no_telepon
        ];

        $simpan = $this->mtodo->insertTodo($data);

        if ($simpan == true) {
            $output = [
                'status' => 200,
                'message' => 'Berhasil menyimpan data',
                'data' => ''
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Gagal menyimpan data',
                'data' => ''
            ];
            return $this->respond($output, 400);
        }
    }

    public function show($id = null)
    {
        $mtodo = $this->mtodo->getTodo($id);

        if (!empty($mtodo)) {
            $output = [
                'id' => intval($mtodo['id']),
                'nama' => $mtodo['nama'],
                'alamat' => $mtodo['alamat'],
                'no_telepon' => $mtodo['no_telepon'],
            ];

            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Data tidak ditemukan',
                'data' => ''
            ];

            return $this->respond($output, 400);
        }
    }

    public function edit($id = null)
    {
        $mtodo = $this->mtodo->getTodo($id);

        if (!empty($mtodo)) {
            $output = [
                'id' => intval($mtodo['id']),
                'nama' => $mtodo['nama'],
                'alamat' => $mtodo['alamat'],
                'no_telepon' => $mtodo['no_telepon'],
            ];

            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Data tidak ditemukan',
                'data' => ''
            ];
            return $this->respond($output, 400);
        }
    }

    public function update($id = null)
    {
        // menangkap data dari method PUT, DELETE
        $data = $this->request->getRawInput();

        // cek data berdasarkan id
        $mtodo = $this->mtodo->getTodo($id);

        //cek todo
        if (!empty($mtodo)) {
            // update data
            $updateTodo = $this->mtodo->updateTodo($data, $id);

            $output = [
                'status' => true,
                'data' => '',
                'message' => 'sukses melakukan update'
            ];

            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => false,
                'data' => '',
                'message' => 'gagal melakukan update'
            ];

            return $this->respond($output, 400);
        }
    }

    public function delete($id = null)
    {
        // cek data berdasarkan id
        $mtodo = $this->mtodo->getTodo($id);

        //cek todo
        if (!empty($mtodo)) {
            // delete data
            $deleteTodo = $this->mtodo->deleteTodo($id);

            $output = [
                'status' => true,
                'data' => '',
                'message' => 'sukses hapus data'
            ];

            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => false,
                'data' => '',
                'message' => 'gagal hapus data'
            ];

            return $this->respond($output, 400);
        }
    }
    }