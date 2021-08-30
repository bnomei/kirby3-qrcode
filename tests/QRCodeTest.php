<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bnomei\QRCode;
use PHPUnit\Framework\TestCase;

final class QRCodeTest extends TestCase
{
    private $text;

    public function setUp(): void
    {
        $this->text = 'https://github.com/bnomei/kirby3-qrcode';
    }

    public function testConstruct()
    {
        $qrcode = new QRCode([
            'Text' => $this->text,
        ]);

        $this->assertInstanceOf(QRCode::class, $qrcode);
    }

    public function testParent()
    {
        $qrcode = new QRCode([
            'Text' => $this->text,
        ]);

        $this->assertInstanceOf(\Endroid\QrCode\Builder\Builder::class, $qrcode->qrcode());
    }

    public function testHtml()
    {
        $qrcode = new QRCode([
            'Text' => $this->text,
        ]);
        $html = $qrcode->html('qrcode.png', [
            'alt' => 'example qr code',
        ]);
        $this->assertMatchesRegularExpression('/^<img alt="example qr code" src="data:image\/png;base64,.*">$/', $html);
    }

    public function testDownload()
    {
        $this->expectExceptionMessageMatches('/^Cannot modify header information/');
        $qrcode = new QRCode([
            'Text' => $this->text,
        ]);
        $qrcode->download('qrcode.png');
        $this->assertTrue(true);
    }

    public function testAdvanced()
    {
        $qrcode = new QRCode([
            'Text' => $this->text,
            'LogoSize' => [300, 300],
        ]);
        $html = $qrcode->html('qrcode.png', [
            'alt' => 'example qr code',
        ]);
        $this->assertMatchesRegularExpression('/^<img alt="example qr code" src="data:image\/png;base64,.*">$/', $html);
    }
}
