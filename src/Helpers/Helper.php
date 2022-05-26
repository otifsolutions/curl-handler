<?php

namespace OTIFSolutions\CurlHandler\Helpers;

/**
 * Class Helper
 * @package OTIFSolutions\CurlHandler\Helpers
 */
class Helper
{
    /**
     * @param $string
     * @return bool
     */
    public static function isJson($string): bool
    {
        json_decode($string);
        try{
            return (json_last_error() == JSON_ERROR_NONE);
        }catch (\Exception $ex){
            return FALSE;
        }
    }

    /**
     * @param $string
     * @return bool
     */
    public static  function isDomDocument($string): bool
    {
        $xml = new \DOMDocument();
        try{
            return $xml->loadXML($string) !== FALSE;
        }catch (\Exception $ex){
            return FALSE;
        }
    }

    /**
     * @param $node
     * @return mixed
     */
    public static  function domToArray($node) {
        $output = [];
        if (is_string($node)){
            $xml = new \DOMDocument();
            $xml->loadXML($node);
            $output[$xml->documentElement->tagName] = self::domToArray($xml->documentElement);
            return $output;
        }
        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
                $output['@cdata'] = trim($node->textContent);
                break;

            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;

            case XML_ELEMENT_NODE:
                // for each child node, call the covert function recursively
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = self::domToArray($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        // assume more nodes of same kind are coming
                        if (!array_key_exists($t, $output)) {
                            $output[$t] = [];
                        }
                        $output[$t][] = $v;
                    } else {
                        //check if it is not an empty text node
                        if ($v !== '') {
                            $output = $v;
                        }
                    }
                }

                if (is_array($output)) {
                    // if only one node of its kind, assign it directly instead if array($value);
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) === 1) {
                            $output[$t] = $v[0];
                        }
                    }
                    if (count($output) === 0) {
                        //for empty nodes
                        $output = '';
                    }
                }

                // loop through the attributes and collect them
                if ($node->attributes->length) {
                    $a = [];
                    foreach ($node->attributes as $attrName => $attrNode) {
                        $a[$attrName] = (string)$attrNode->value;
                    }
                    // if its an leaf node, store the value in @value instead of directly storing it.
                    if (!is_array($output)) {
                        $output = ['@value' => $output];
                    }
                    $output['@attributes'] = $a;
                }
                break;
        }

        return $output;
    }
}
