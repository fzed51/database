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

use PDO;
use PDOStatement;
use RuntimeException;

/**
 * Description of DbAccess
 *
 * @author fabien.sanchez
 */
class DbAccess
{

    /**
     * @var PDO
     */
    private $Pdo;

    /**
     * @var string
     */
    private $Type;

    /**
     * @var array
     */
    protected $Options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    /**
     * @param ConnextionInterface $connexion
     * @param array $options
     */
    public function __construct(ConnexionInterface $connexion, array $options = [])
    {
        $this->Options = self::mergeOption($this->Options, $options);
        $this->Pdo = new PDO($connexion->getDns(), $connexion->getUserName(), $connexion->getPassWord(), $this->Options);
    }

    static private function mergeOption(array $option1, array $option2)
    {
        $option = [];
        foreach ($option1 as $key => $value) {
            $option[$key] = $value;
        }
        foreach ($option2 as $key => $value) {
            $option[$key] = $value;
        }
        return $option;
    }

    /**
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setOption($attribute, $value)
    {
        return $this->Pdo->setAttribute($attribute, $value);
    }

    /**
     * @param string $typeName
     * @return DbAccess
     * @throws RuntimeException
     */
    public function setType($typeName)
    {
        $className = $typeName;
        if (!class_exists($className, true)) {
            throw new RuntimeException("Le type de donnée '$typeName' n'existe pas.");
        }
        $clone = clone $this;
        $clone->Type = $className;
        return $clone;
    }

    /**
     * @param string $rqSQL
     * @param array $param
     * @return PDOStatement
     */
    public function query($rqSQL, array $param = [])
    {
        if (!empty($param)) {
            $req = $this->Pdo->prepare($rqSQL);
            if ($req !== false) {
                $req->execute($param);
            }
        } else {
            $req = $this->Pdo->query($rqSQL);
        }
        if ($this->Type) {
            $req->setFetchMode(PDO::FETCH_CLASS, $this->Type);
        }
        return $req;
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->Pdo->lastInsertId();
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->Pdo;
    }

}
