<?php
namespace Application\Security\DataFilters;

use Application\Configuration\Configuration;

class PreDatabaseSave
{
    use Configuration;

    /**
    * Filter
    * 
    * @param string $string
    * @return string
    */
    public function filter($string, $restricted_characters)
    {
        if($restricted_characters === true) {
            $string = $this->normalizeString($string);
        }

        // Remove evil characters
        $string = str_replace(chr(0), '', $string);
        
        return $string;
    }

    /**
    * Remove prohibited characters
    * 
    * @param string $string
    * @return string
    */
    private function normalizeString($string)
    {
        return preg_replace('/[^A-Za-z0-9' . $this->config()->accented_characters . '_\-!?]+/', ' ', $string);
    }
}