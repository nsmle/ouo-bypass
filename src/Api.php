<?php

/**
 * ouo-bypass
 *
 * @see        https://github.com/nsmle/ouo-bypass/ The ouo-bypass GitHub project
 * @author     Fiki Pratama (nsmle) <fikiproductionofficial@gmail.com>
 */

declare(strict_types=1);

namespace Nsmle\OuoBypass;

use Nsmle\OuoBypass\Exception\OuoException;
use Nsmle\OuoBypass\Utils\HtmlParse;
use Nsmle\OuoBypass\Utils\Request;
use Nsmle\OuoBypass\Utils\UrlHelper;

class Api extends Request
{
    /**
     * @var originUrl
     */
    private $originUrl;

    /**
     * @var destinationUrl
     */
    private $destinationUrl;

    /**
     * @param string $originUrl|null
     */
    public function __construct(string $originUrl = null)
    {
        parent::__construct();
        $this->originUrl = $originUrl;
    }

    /**
     * @throws OuoException
     */
    public function bypass(): array
    {
        if (empty($this->originUrl)) {
            throw new OuoException('Empty originUrl or unset originUrl.
                see https://github.com/nsmle/ouo-bypass/#usage');
        }

        $tempUrl = UrlHelper::getTempUrl($this->originUrl);
        $nextUrl = UrlHelper::getNextUrl('go', $tempUrl);

        $res         = $this->fetchData($tempUrl);
        $htmlContent = (string) $res;

        $data = HtmlParse::parseInputDataForm($htmlContent);

        for ($i = 0; $i <= 2; ++$i) {
            $res = $this->postData($nextUrl, $data, array('allow_redirects' => false));

            if (!empty($res->getHeaderLine('Location'))) {
                break;
            }

            $nextUrl = UrlHelper::getNextUrl('xreallcygo', $tempUrl);
        }

        $this->destinationUrl = $res->getHeaderLine('Location');

        return array(
            'origin-url'      => $this->originUrl,
            'destination-url' => $this->destinationUrl,
        );
    }

    /**
     * @param string originUrl
     */
    public function setOriginUrl(string $originUrl): void
    {
        $this->originUrl = $originUrl;
    }

    public function getOriginUrl(): string
    {
        return $this->originUrl;
    }

    public function getDestinationUrl(): string
    {
        return $this->destinationUrl;
    }
}
