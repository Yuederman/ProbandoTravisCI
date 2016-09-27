<?php

namespace Poli\Tarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

    public function testCargaSaldo() {
        $tarjeta = new Sube;
        $tarjeta->recargar(272);
        $this->assertEquals($tarjeta->saldo(), 320, "Cuando cargo 272 deberia tener finalmente 320");
    }


    public function testPagarViaje() {
        $tarjeta = new Sube;
        $tarjeta->recargar(20);
        $colectivo = new Colectivo("35/9", "Rosario Bus");
        $tarjeta->pagar($colectivo, "2016/06/30 22:50");
        $this->assertEquals($tarjeta->saldo(), 20 - 2.64, "Vo so pelotudo?");
    }

    public function testPagarViajeSinSaldo() {
        $tarjeta = new Sube;
        $colectivo = new Colectivo("35/9", "Rosario Bus");
        $this->assertFalse($tarjeta->pagar($colectivo, "2016/06/30 22:50"), "Vo so pelotudo?");
    }

    public function testTransbordo() {
        $tarjeta = new Sube;
        $tarjeta->recargar(20);
        $colectivo = new Colectivo("35/9", "Rosario Bus");
        $tarjeta->pagar($colectivo, "2016/06/30 22:00");
        $tarjeta->pagar($colectivo, "2016/06/30 22:45");
        $this->assertEquals($tarjeta->saldo(), 20 - 4.64, "Transgordo");
    }

    public function testNoTransbordo() {
        $tarjeta = new Sube;
        $tarjeta->recargar(20);
        $colectivo = new Colectivo("35/9", "Rosario Bus");
        $tarjeta->pagar($colectivo, "2016/06/30 22:00");
        $tarjeta->pagar($colectivo, "2016/06/30 23:42");
        $this->assertEquals($tarjeta->saldo(), 20 - 2.64 - 2.64, "NO Transgordo");
    }

}
