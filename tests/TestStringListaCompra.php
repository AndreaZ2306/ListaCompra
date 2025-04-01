<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../ListaCompra.php';

class ListaCompraTest extends TestCase
{
    /**
     * @test
     */
    public function testAñadirProductoSinCantidad()
    {
        $lista = new ListaCompra();
        $this->assertEquals("pan x1", $lista->procesar("añadir pan"));
    }

    /**
     * @test
     */
    public function testAñadirProductoConCantidad()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir leche 2");
        $this->assertEquals("leche x2", $lista->procesar("añadir leche 0"));
    }

    /**
     * @test
     */
    public function testAñadirProductoYaExistente()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir pan");
        $this->assertEquals("pan x3", $lista->procesar("añadir pan 2"));
    }

    /**
     * @test
     */
    public function testAñadirProductoConDistintoCase()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir Pan 2");
        $this->assertEquals("pan x5", $lista->procesar("añadir pan 3"));
    }

    /**
     * @test
     */
    public function testListaOrdenadaAlfabeticamente()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir pan");
        $lista->procesar("añadir leche 2");
        $this->assertEquals("leche x2, pan x1", $lista->procesar("añadir nada 0"));
    }

    /**
     * @test
     */
    public function testEliminarProductoExistente()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir pan");
        $this->assertEquals("", $lista->procesar("eliminar pan"));
    }

    /**
     * @test
     */
    public function testEliminarProductoInexistente()
    {
        $lista = new ListaCompra();
        $this->assertEquals("El producto seleccionado no existe", $lista->procesar("eliminar arroz"));
    }

    /**
     * @test
     */
    public function testVaciarLista()
    {
        $lista = new ListaCompra();
        $lista->procesar("añadir leche 2");
        $this->assertEquals("", $lista->procesar("vaciar"));
    }

    /**
     * @test
     */
    public function testCadenaVaciaSiNoHayProductos()
    {
        $lista = new ListaCompra();
        $this->assertEquals("", $lista->procesar(""));
    }
}