<?php

/*
 * The MIT License
 *
 * Copyright 2016 fabien.sanchez.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace fzed51\Database;

use fzed51\Database\Exception;

/**
 * Description of SqliteConnexion
 *
 * @author fabien.sanchez
 */
class ConnexionSqlite implements ConnexionInterface
{

    private $fileFullName;

    use ExtensionDetector;

    /**
     * @param string $fileFullName
     */
    public function __construct($fileFullName)
    {
        if (!$this->extensionIsFind('pdo_sqlite')) {
            throw new Exception\DriverNotFound("L'extension PDO_sqlite n'est pas chargée");
        }

        $this->setFile($fileFullName);
    }

    public function setFile($fileFullName)
    {
        if (!is_file($fileFullName)) {
            throw new Exception\FileNotFound("le fichier '$fileFullName' n'existe pas.");
        }
        $this->fileFullName = $fileFullName;
    }

    public function getDns()
    {
        return 'sqlite:' . $this->fileFullName;
    }

    public function getPassWord()
    {
        return null;
    }

    public function getUserName()
    {
        return null;
    }

}
