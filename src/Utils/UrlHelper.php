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

class UrlHelper
{
    /**
     * @throws OuoException
     */
    public static function getTempUrl(string $url): string
    {
        if (!preg_match('/(ouo.press|ouo.io)/', $url)) {
            throw new OuoException('This short link is not from ouo.press nor ouo.io, please check and try again.');
        }

        return str_replace('ouo.press', 'ouo.io', $url);
    }

    /**
     * @throws OuoException
     */
    public static function getNextUrl(string $path, string $url): string
    {
        if (!preg_match('/(ouo.press|ouo.io)/', $url)) {
            throw new OuoException('This short link is not from ouo.press nor ouo.io, please check and try again.');
        }

        $uriParse = parse_url($url);
        $id       = str_replace('/', '', $uriParse['path']);

        return "{$uriParse['scheme']}://{$uriParse['host']}/{$path}/{$id}";
    }
}
