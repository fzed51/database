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

/**
 * Description of SqliteConnexion
 *
 * @author fabien.sanchez
 */
class ConnexionOracle implements ConnexionInterface
{

    private $tnsName;
    private $password;
    private $schema;

    use ExtensionDetector;

    /**
     * @param string $schema
     * @param string $password
     * @param string $tnsName
     */
    public function __construct($schema, $password, $tnsName = null)
    {
        if (!$this->extensionIsFind('pdo_oci')) {
            throw new Exception\DriverNotFound("L'extension PDO_OCI n'est pas chargée");
        }

        $this
                ->setSchema($schema)
                ->setPassword($password)
                ->setTnsName($tnsName);
    }

    /**
     * Génère une decription de tns pour une connexion oracle
     * @param string $host
     * @param string $port
     * @param string $service
     * @return string
     */
    public static function makeTnsDescription($host, $port, $service = "ORCL")
    {
        return "(DESCRIPTION = "
                . "  (ADDRESS_LIST = "
                . "    (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))"
                . "  )"
                . "  (CONNECT_DATA = "
                . "    (SERVICE_NAME = $service)"
                . "  )"
                . ")";
    }

    /**
     *
     * @param string $schema
     * @return ConnexionSqlite
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
        return $this;
    }

    /**
     *
     * @param string $schema
     * @return ConnexionSqlite
     */
    public function setPassword($schema)
    {
        $this->password = $password;
        return $this;
    }

    /**
     *
     * @param string $schema
     * @return ConnexionSqlite
     */
    public function setTnsName($schema)
    {
        $this->tnsName = $tnsName;
        return $this;
    }

    public function getDns()
    {
        return 'oci:dbname=' . $this->tnsName;
    }

    public function getPassWord()
    {
        return $this->password;
    }

    public function getUserName()
    {
        return $this->schema;
    }

}
