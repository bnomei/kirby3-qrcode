<?php

declare(strict_types=1);

namespace Bnomei;

use Kirby\Cms\Html;
use Kirby\Http\Header;
use Kirby\Toolkit\A;

final class QRCode
{
    /** @var \Endroid\QrCode\QrCode */
    private $qrCode;

    /** @var array */
    private $options;

    /**
     * QRCode constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;

        $text = A::get($this->options, 'Text');
        $this->qrCode = new \Endroid\QrCode\QrCode($text);

        foreach ($options as $option => $value) {
            $setterName = 'set' . $option;
            if ($option === 'Text' || method_exists($this->qrCode, $setterName) === false) {
                continue;
            }

            if (in_array($option, ['Label', 'LogoSize'])) {
                // call function with params instead of array
                call_user_func_array([$this->qrCode, $setterName], $value);
            } else {
                $this->qrCode->{$setterName}($value);
            }
        }
    }

    /**
     * @return \Endroid\QrCode\QrCode
     */
    public function qrcode()
    {
        return $this->qrCode;
    }

    /**
     * @param string $name
     * @param array $attrs
     * @return string
     * @throws \Endroid\QrCode\Exception\UnsupportedExtensionException
     */
    public function html(string $name, array $attrs = []): string
    {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $this->qrCode->setWriterByExtension($extension);
        $data = $this->qrCode->writeString();
        return Html::tag('img', null, array_merge($attrs, [
            'src' => 'data:image/' . $extension . ';base64,' . base64_encode($data)
        ]));
    }

    /**
     * @param string $name
     * @throws \Endroid\QrCode\Exception\UnsupportedExtensionException
     */
    public function download(string $name)
    {
        Header::download([
            'mime' => $this->qrCode->getContentType(),
            'name' => $name,
        ]);
        // @codeCoverageIgnoreStart
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $this->qrCode->setWriterByExtension($extension);
        echo $this->qrCode->writeString();
        // @codeCoverageIgnoreEnd
    }
}
