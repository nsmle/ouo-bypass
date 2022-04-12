<?php

/**
 * ouo-bypass
 *
 * @see        https://github.com/nsmle/ouo-bypass/ The ouo-bypass GitHub project
 * @author     Fiki Pratama (nsmle) <fikiproductionofficial@gmail.com>
 */

declare(strict_types=1);

namespace Nsmle\OuoBypass\Utils;

use Nsmle\OuoBypass\Exception\OuoException;

class HtmlParse
{
    /**
     * @param string htmlContent
     */
    public static function parseInputDataForm(string $htmlContent): array
    {
        if (preg_match('/LINK NOT FOUND/i', $htmlContent)) {
            throw new OuoException('Link Not found,
                please double check and enter valid link from domain host ouo.io or ouo.press.');
        }

        preg_match_all('/<input (.*?)>/i', $htmlContent, $inputs);
        $data = array();
        foreach ($inputs[0] as $input) {
            $input = preg_replace('/"/', '', $input);

            preg_match('/name=(.*?)\s/', $input, $inputName);
            preg_match('/value=(.*?)>/', $input, $inputValue);

            $data = array_merge($data, array(
                $inputName[1] => $inputValue[1],
            ));
        }

        return $data;
    }
}
