<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;
use CodeIgniter\Database\Query;

class Main extends BaseController
{
    public function index()
    {

//        Database
        $db = \Config\Database::connect();

//        Encryption
        $config         = new \Config\Encryption();
        $config->key = "f66be40453c70467a7c97ec308d400742e19b65c65e12b24d11ff77aa8b5c32f";
        $encrypter = \Config\Services::encrypter($config);

//        SESSION
        helper('cookie');
        if (session()->has('username')) {
            $getUsername = session()->get('username');
            $decrypKeyUsername = $encrypter->decrypt($getUsername);
        } else {
            return redirect()->to("/");
        }

//        COOKIE
        helper('cookie');
        if ( get_cookie('login_token')) {
            $getUsernameOne = get_cookie('login_token');
            $decrypKeyUsername = $encrypter->decrypt($getUsernameOne);
        }

//        CHECK USERNAME
        $pQuery = $db->prepare(function($db)
        {
            $sql = "SELECT username FROM account WHERE username = ?";

            return (new Query($db))->setQuery($sql);
        });
        $results = $pQuery->execute($decrypKeyUsername)->getResultArray();

        if (count($results) !== 0) {
            $pQuery2 = $db->prepare(function($db)
            {
                $sql = "SELECT * FROM list WHERE username = ?";

                return (new Query($db))->setQuery($sql);
            });
            $result2 = $pQuery2->execute($decrypKeyUsername)->getResultArray();
        }

        $pQuery->close();

        if ($this->request->getPost('submit') === "") {
            helper('cookie');
            setcookie('login_token',true,time()-1000,'/');
            session()->destroy();
            return redirect()->to("/");
        }
        $data = [
            'record' => $result2
        ];


//        DELETE BUTTON
        if ($this->request->getPost('delete') === "") {
            $getIDList = $this->request->getPost('_delete');

            $pQuery = $db->prepare(function($db)
            {
                $sql = "DELETE FROM list WHERE id = ?";

                return (new Query($db))->setQuery($sql);
            });

            $pQuery->execute($getIDList);

            if ($db->affectedRows()) {
                session()->setFlashdata('deleteMessage','Data Berhasil Dihapus');
                return redirect()->to("/main");
            } else {
                d("Gagal Dihapus");
            }
        }

//        CHANGE BUTTON
        if ($this->request->getPost('change') === "") {
            $getIDList = $this->request->getPost('_change');
            $pQuery = $db->prepare(function($db)
            {
                $sql = "SELECT * FROM list WHERE id = ?";

                return (new Query($db))->setQuery($sql);
            });

            $result3 = $pQuery->execute($getIDList)->getResultArray();
            session()->setTempdata('dataChange', $result3[0]["text"],3600);
            session()->setTempdata('idChange', $result3[0]["id"],3600);
            session()->setTempdata('expiredTime', 'Anda Diberikan Waktu 1 Jam Untuk Mengubah Data',3600);
            return redirect()->to("/main");
        }

//        CANCEL BUTTON
        if ($this->request->getPost('cancel') === "") {
            session()->removeTempdata('dataChange');
            session()->removeTempdata('expiredTime');
            return redirect()->to("/main");
        }

//        CHANGE BUTTON
        if ($this->request->getPost('ubah') === "") {
            $idList = $this->request->getPost('id');
            $valueID = $this->request->getPost('valueText');

            $pQuery = $db->prepare(function($db)
            {
                $sql = "UPDATE list SET text = ? WHERE id = ?";

                return (new Query($db))->setQuery($sql);
            });

            $pQuery->execute($valueID, $idList);
            if ($db->affectedRows()) {
                session()->setFlashdata('updateMessage','Data Berhasil Diupdate');
                session()->removeTempdata('dataChange');
                session()->removeTempdata('expiredTime');
                return redirect()->to("/main");
            } else {
                d("DATA GAGAL DIUBAH");
            }
        }

//        CREATE NEW DATA
        if ($this->request->getPost('create') === "") {
            $valueData = $this->request->getPost('valueText');

            $pQuery = $db->prepare(function($db)
            {
                $sql = "INSERT INTO list (text, username) VALUES (?,?)";

                return (new Query($db))->setQuery($sql);
            });

            $pQuery->execute($valueData, $decrypKeyUsername);
            if ($db->affectedRows()) {
                session()->setFlashdata('createMessage','Data Berhasil Ditambahkan');
                return redirect()->to("/main");
            } else {
                d("Data Gagal Ditambahkan");
            }
        }

        return view("Main/index",$data);
    }
}
