<?php

namespace fzed51\Database;

/**
 * Description of ExtensionDetector
 *
 * @author fabien.sanchez
 */
Trait ExtensionDetector
{

    public function extensionIsFind($extension)
    {
        $extensions = get_loaded_extensions();
        $extensions = array_map(function($extension) {
            return strtolower($extension);
        }, $extensions);
        if (array_search('pdo_oci', $extensions)) {
            return true;
        }
        return false;
    }

}
