<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use CodeIgniter\Database\Query;
use Config\Services;

class Login extends BaseController
{

    // HOME LOGIN
    public function index()
    {
        $db = \Config\Database::connect();

        //        CHECK TOKEN
        if (session()->getTempdata()) {
//                                ENCRYPT KHUSUS SESSION AUTH TOKEN
            $config         = new \Config\Encryption();
            $config->key = "fcec5b64d296469dba27aa9b84d2a8cb17d0551b030f2b29c0543a3a2b708144";
            $encrypter = \Config\Services::encrypter($config);

            $bytes = bin2hex(random_bytes(32));
            $emailAuth = session()->getTempdata()["emailAuth"];
            $email = $encrypter->decrypt($emailAuth);
            $token = session()->getTempdata()["tokenAuth"];

            $db = \Config\Database::connect();

            //            UPDATE TOKEN
            $pQuery2 = $db->prepare(function($db)
            {
                $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $pQuery2->execute($bytes, $email);
            session()->removeTempdata('tokenAuth');
            session()->removeTempdata('emailAuth');
            session()->removeTempdata('timeAfter');
        }

//                            ENCRYPT
        $config         = new \Config\Encryption();
        $config->key    =  "f66be40453c70467a7c97ec308d400742e19b65c65e12b24d11ff77aa8b5c32f";
        $encrypter = \Config\Services::encrypter($config);

//        COOKIE
        helper('cookie');
        if (get_cookie('login_token')) {
            $getUsernameOne = get_cookie('login_token');
            $decrypKeyUsername = $encrypter->decrypt($getUsernameOne);
            return redirect()->to("/main");
        }

//        SESSION
        if (session()->has('username')) {
            session()->destroy();
        }
        if (session()->getTempdata('reset_password')) {
            session()->removeTempdata('reset_password');
        }

//        LOGIN
        if ($this->request->getPost('submit') === "") {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                    'username' => [
                        'label'  => 'Username',
                        'rules'  => 'required|alpha_numeric_space',
                        'errors' => [
                            'required' => '{field} Wajib Diisi',
                            'alpha_numeric_space' => '{field} Harus Mengandung Huruf atau Angka'
                        ]
                    ],
                    'password' => [
                        'label'  => 'Password',
                        'rules'  => 'required|min_length[10]',
                        'errors' => [
                            'min_length' => '{field} Minimal 10 Character',
                            'required' => '{field} Wajib Diisi'
                        ]
                    ]
                ]
            );
            if ($validation->withRequest($this->request)->run()) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $pQuery = $db->prepare(function($db)
                {
                    $sql = "SELECT username,password FROM account WHERE username = ?";

                    return (new Query($db))->setQuery($sql);
                });
                $results = $pQuery->execute($username);
                if ($results->getResultArray()) {
                    $resultQuery = $results->getResultArray();
                    $verifyPassword = password_verify($password,$resultQuery[0]["password"]);
                    if ($verifyPassword) {
                        $ciphertext = $encrypter->encrypt($resultQuery[0]["username"]);
                        $data = [
                            'username' => $ciphertext,
                            'statusLogin' => true
                        ];
                        if ($this->request->getPost('checkbox')) {
                            helper('cookie');
                            setcookie('login_token',$ciphertext,time()+3600,'/');
                        }
                        session()->set($data);
                        $pQuery->close();
                        return redirect()->to("/main");
                    } else {
                        session()->setFlashdata('passwordWrong','Password Salah');
                        return redirect()->back()->withInput();
                    }
                } else {
                    session()->setFlashdata('usernameWrong','Username Tidak Ditemukan');
                    return redirect()->back()->withInput();
                }

            } else {
                $messageError = [
                  'username' => $validation->getError('username'),
                  'password' => $validation->getError('password'),
                ];
                session()->setFlashdata($messageError);
                return redirect()->back()->withInput();
            }
        }
       return view("Login/index");
    }


    // SIGNUP
    public function signup() {
        //        SESSION
        if (session()->has('username')) {
            session()->destroy();
        }
        if (session()->getTempdata('reset_password')) {
            session()->removeTempdata('reset_password');
        }

        //        CHECK TOKEN
        if (session()->getTempdata()) {
            //                    ENCRYPT KHUSUS SESSION AUTH TOKEN
            $config         = new \Config\Encryption();
            $config->key = "fcec5b64d296469dba27aa9b84d2a8cb17d0551b030f2b29c0543a3a2b708144";
            $encrypter = \Config\Services::encrypter($config);

            $bytes = bin2hex(random_bytes(32));

            $email = $encrypter->decrypt(session()->getTempdata()["emailAuth"]);
            $token = session()->getTempdata()["tokenAuth"];

            $db = \Config\Database::connect();

            //            UPDATE TOKEN
            $pQuery2 = $db->prepare(function($db)
            {
                $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $pQuery2->execute($bytes, $email);
            session()->removeTempdata('tokenAuth');
            session()->removeTempdata('emailAuth');
            session()->removeTempdata('timeAfter');
        }

//        DATABASE
        $db = \Config\Database::connect();

//        VALIDATION
        $validation =  \Config\Services::validation();
        $validation->setRules([
                'email' => [
                    'label'  => 'Email',
                    'rules'  => 'required|is_unique[account.email]|valid_email',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        'is_unique' => '{field} Sudah Ada',
                        'valid_email' => '{field} Harus Berupa Email',
                    ]
                ],
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required|is_unique[account.username]|alpha_numeric',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        'is_unique' => '{field} Sudah Ada',
                        'alpha_numeric' => '{field} Harus Berupa Angka Dan Huruf',
                    ]
                ],
                'password' => [
                    'label'  => 'Password',
                    'rules'  => 'required|min_length[10]',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        'min_length' => '{field} Minimal 10 Character'
                    ]
                ],
                'confirm_password' => [
                    'label'  => 'Confirm Password',
                    'rules'  => 'required|min_length[10]|matches[password]',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        'min_length' => '{field} Minimal 10 Character',
                        'matches' => '{field} Tidak Sama',
                    ]
                ]
            ]
        );

        if ($this->request->getPost('submit') === "") {
            if ($validation->withRequest($this->request)->run()) {
                $email = $this->request->getPost('email');
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

//                HASHING PASSWORD
                $hashPassword = password_hash($password,PASSWORD_BCRYPT);

//                INSERT DATA TO DATABASE ACCOUNT
                $pQuery = $db->prepare(function($db)
                {
                    $sql = "INSERT INTO account(email, username, password) VALUES (?, ?, ?)";

                    return (new Query($db))->setQuery($sql);
                });
                $pQuery->execute($email, $username, $hashPassword);

                if ($db->affectedRows()) {
                    $bytes = random_bytes(32);

 //                INSERT DATA TOKEN TO DATABASE AUTH TOKEN
                    $pQuery2 = $db->prepare(function($db)
                    {
                        $sql = "INSERT INTO auth_token(email, token) VALUES (?, ?)";

                        return (new Query($db))->setQuery($sql);
                    });

                    $pQuery2->execute($email, bin2hex($bytes));

                    if ($db->affectedRows()) {
                        session()->setFlashdata('login','Silahkan Login');
                        return redirect()->to("/login/signup");
                    } else {
                        d("Please Try Again Later");
                    }
                }
            } else {
//                SEND NOTIFICATIONS ERROR VALIDATIONS
                session()->setFlashdata([
                    'email' => $validation->getError('email'),
                    'username' => $validation->getError('username'),
                    'password' => $validation->getError('password'),
                    'confirm_password' => $validation->getError('confirm_password'),
                ]);
                return redirect()->to("/login/signup")->withInput();
            }
        }


        if ($this->request->getPost('cancel') === "") {
            return redirect("/");
        }
        return view("Login/signup");
    }


    // FORGOT
    public function forgot() {
        //        SESSION
        if (session()->has('username')) {
            session()->destroy();
        }
        if (session()->getTempdata('reset_password')) {
            session()->removeTempdata('reset_password');
        }

//                    ENCRYPT EMAIL
        $config         = new \Config\Encryption();
        $config->key = "fcec5b64d296469dba27aa9b84d2a8cb17d0551b030f2b29c0543a3a2b708144";
        $encrypter = \Config\Services::encrypter($config);

        //        CHECK TOKEN
        if (session()->getTempdata()) {
            $bytes = bin2hex(random_bytes(32));

            $email = $encrypter->decrypt(session()->getTempdata()["emailAuth"]);
            $token = session()->getTempdata()["tokenAuth"];

            $db = \Config\Database::connect();

            //            UPDATE TOKEN
            $pQuery2 = $db->prepare(function($db)
            {
                $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $pQuery2->execute($bytes, $email);
            session()->removeTempdata('tokenAuth');
            session()->removeTempdata('emailAuth');
            session()->removeTempdata('timeAfter');
        }

        if ($this->request->getPost('cancel') === "") {
            return redirect("/");
        }

        if ($this->request->getPost('next') === "") {
//          VALIDATION
            $validation =  \Config\Services::validation();
            $validation->setRules([
                    'emailAuth' => [
                        'label'  => 'Email',
                        'rules'  => 'required|valid_email|valid_emails',
                        'errors' => [
                            'required' => '{field} Wajib Diisi',
                            'valid_email' => 'Harus Wajib Berupa {field}',
                            'valid_emails' => 'Jumlah {field} Harus Satu',
                        ]
                    ]
                ]
            );
            if ($validation->withRequest($this->request)->run()) {
                $emailAuth = $this->request->getPost('emailAuth');

//                CHECK EMAIL EXIST IN DATABASE ACCOUNT
                $db = \Config\Database::connect();
                $pQuery = $db->prepare(function($db)
                {
                    $sql = "SELECT email FROM account WHERE email = ?";

                    return (new Query($db))->setQuery($sql);
                });
                $result = $pQuery->execute($emailAuth)->getResultArray();

                if (count($result) > 0) {
                    $pQuery2 = $db->prepare(function($db)
                    {
                        $sql = "SELECT email,token FROM auth_token WHERE email = ?";

                        return (new Query($db))->setQuery($sql);
                    });

                    $result2 = $pQuery2->execute($emailAuth)->getResultArray();

//                    EMAIL & TOKEN
                    $email = $result2[0]["email"];
                    $token = $result2[0]["token"];
                    $encryptEmail = $encrypter->encrypt($email);


                    session()->setTempdata('emailAuth',$encryptEmail,360);
                    session()->setTempdata('tokenAuth',$token,360);
                    session()->setTempdata('timeAfter',date('i',time()+240),360);
                    return redirect()->to("/auth/" . bin2hex($encryptEmail));
                } else {
                    session()->setFlashdata('emailNotFound', 'Email Tidak Terdaftar');
                    return redirect()->back()->withInput();
                }

            } else {
                session()->setFlashdata('emailAuth', $validation->getError('emailAuth'));
                return redirect()->back()->withInput();
            }
        }
        return view("Login/forgot");
    }

    public function auth() {

        //        SESSION
        if (session()->has('username')) {
            session()->destroy();
        }
        if (session()->getTempdata('reset_password')) {
            session()->removeTempdata('reset_password');
        }

//        DATABASE
        $db = \Config\Database::connect();

//                    ENCRYPT EMAIL
        $config         = new \Config\Encryption();
        $config->key = "fcec5b64d296469dba27aa9b84d2a8cb17d0551b030f2b29c0543a3a2b708144";
        $encrypter = \Config\Services::encrypter($config);

//        CHECK TIME
        $minutes = date("i", time());
        if ((int) $minutes === (int) session()->getTempdata('timeAfter') ||
            (int) $minutes > (int) session()->getTempdata('timeAfter')) {
            $email =  $encrypter->decrypt(session()->getTempdata()["emailAuth"]);
            $bytes = bin2hex(random_bytes(32));

//            UPDATE TOKEN
            $pQuery = $db->prepare(function($db)
            {
                $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $pQuery->execute($bytes, $email);
            if ($db->affectedRows()) {
                session()->removeTempdata('tokenAuth');
                session()->removeTempdata('emailAuth');
                session()->removeTempdata('timeAfter');
                return redirect()->to("/");
            }
        }

//        CHECK TOKEN
        if (session()->getTempdata()) {
            $email = session()->getTempdata()["emailAuth"];
            $token = session()->getTempdata()["tokenAuth"];
        } else {
            return redirect()->to("/login/forgot");
        }

//        CANCEL BUTTON
        if ($this->request->getPost('cancel') === "") {
            $bytes = bin2hex(random_bytes(32));

            $email1 = $encrypter->decrypt(session()->getTempdata()["emailAuth"]);

//            UPDATE TOKEN
            $pQuery2 = $db->prepare(function($db)
            {
                $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $pQuery2->execute($bytes, $email1);

            if ($db->affectedRows()) {
                session()->removeTempdata('tokenAuth');
                session()->removeTempdata('emailAuth');
                session()->removeTempdata('timeAfter');
                return redirect()->to("/login/forgot");
            }
        }

//        NEXT BUTTON
        if ($this->request->getPost('next') === "") {
           $token = $this->request->getPost('token');

            $pQuery = $db->prepare(function($db)
            {
                $sql = "SELECT email FROM auth_token WHERE token = ?";

                return (new Query($db))->setQuery($sql);
            });

            $results = $pQuery->execute($token)->getResultArray();
            if (count($results) > 0) {
                $emaill = $encrypter->encrypt($results[0]["email"]);

                $bytes = bin2hex(random_bytes(32));
                $pQuery2 = $db->prepare(function($db)
                {
                    $sql = "UPDATE auth_token SET token = ? WHERE email = ?";

                    return (new Query($db))->setQuery($sql);
                });

                $pQuery2->execute($bytes, $results[0]["email"]);

                if ($db->affectedRows()) {
                    session()->setTempdata('reset_password',$emaill,86400);
                    return redirect()->to("/login/changePassword/" . bin2hex(random_bytes(64)));
                }
            } else {
                return redirect()->to("/auth/" . bin2hex(random_bytes(64)));
            }
        }
        return view("Login/auth");
    }

    public function changePassword($get = false) {
//        DATABASE
        $db = \Config\Database::connect();

//        CHECK SESSION
        if (!session()->getTempdata('reset_password')) {
            return redirect()->to("/");
        }
//        DATABASE
        $db = \Config\Database::connect();
//                    ENCRYPT EMAIL
        $config         = new \Config\Encryption();
        $config->key = "fcec5b64d296469dba27aa9b84d2a8cb17d0551b030f2b29c0543a3a2b708144";
        $encrypter = \Config\Services::encrypter($config);

//        CHECK EMAILS IF EXISTS
        $encryEmail = $encrypter->decrypt(session()->getTempdata('reset_password'));

        $pQuery = $db->prepare(function($db)
        {
            $sql = "SELECT * FROM account WHERE email = ?";

            return (new Query($db))->setQuery($sql);
        });
        $results = $pQuery->execute($encryEmail)->getResultArray();

        if ($this->request->getPost('batal') === "") {
            session()->removeTempdata('reset_password');
            return redirect()->to("/");
        }

        if ($this->request->getPost('submit') === "") {
            $validation =  \Config\Services::validation();

            $validation->setRules([
                    'password' => [
                        'label'  => 'Password',
                        'rules'  => 'required|min_length[10]',
                        'errors' => [
                            'required' => '{field} Wajib Diisi',
                            'min_length' => '{field} Minimal 10 Character'
                        ]
                    ],
                    'retry_password' => [
                        'label'  => 'Password',
                        'rules'  => 'required|min_length[10]|matches[password]',
                        'errors' => [
                            'required' => '{field} Wajib Diisi',
                            'min_length' => '{field} Minimal 10 Character',
                            'matches' => '{field} Harus Sama'
                        ]
                    ],
                ]
            );

            if ($validation->withRequest($this->request)->run()) {
                $password = $this->request->getPost('password');

                //                HASHING PASSWORD
                $hashPassword = password_hash($password,PASSWORD_BCRYPT);

//                UPDATE PASSWORD
                $pQuery = $db->prepare(function($db)
                {
                    $sql = "UPDATE account SET password = ? WHERE email = ?";

                    return (new Query($db))->setQuery($sql);
                });

                $pQuery->execute($hashPassword, $results[0]["email"]);
                if ($db->affectedRows()) {
                    session()->setFlashdata('succesReset','Password Berhasil Diubah Silahkan Kembali Halaman ');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata([
                    'password' => $validation->getError('password'),
                    'retry_password' => $validation->getError('retry_password'),
                ]);
                return redirect()->back()->withInput()->withInput();
            }
        }
        return view("Login/reset");
    }
}
