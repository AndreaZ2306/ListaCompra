<?php

class ListaCompra
{
    private array $productos = [];

    public function procesar(string $instruccion): string
    {
        $instruccion = strtolower(trim($instruccion));
        $partes = preg_split('/\s+/', $instruccion);

        if (count($partes) === 0) {
            return $this->formatearLista();
        }

        $comando = $partes[0];

        if ($comando === "añadir") {
            if (count($partes) < 2) return $this->formatearLista();
            $nombre = $partes[1];
            $cantidad = isset($partes[2]) ? intval($partes[2]) : 1;

            if (isset($this->productos[$nombre])) {
                $this->productos[$nombre] += $cantidad;
            } else {
                $this->productos[$nombre] = $cantidad;
            }

            return $this->formatearLista();
        }

        if ($comando === "eliminar") {
            if (count($partes) < 2) return $this->formatearLista();
            $nombre = $partes[1];

            if (isset($this->productos[$nombre])) {
                unset($this->productos[$nombre]);
                return $this->formatearLista();
            } else {
                return "El producto seleccionado no existe";
            }
        }

        if ($comando === "vaciar") {
            $this->productos = [];
            return "";
        }

        return $this->formatearLista();
    }

    //Función para formatear
    private function formatearLista(): string
    {
        if (empty($this->productos)) return "";

        // Ordenar alfabéticamente (ignorando mayúsculas)
        uksort($this->productos, function ($a, $b) {
            return strcasecmp($a, $b);
        });

        $items = [];
        foreach ($this->productos as $nombre => $cantidad) {
            $items[] = "{$nombre} x{$cantidad}";
        }

        return implode(", ", $items);
    }
}

//Correr programa
$lista = new ListaCompra();

echo $lista->procesar("añadir pan") . "\n";          // pan x1
echo $lista->procesar("añadir leche 2") . "\n";      // leche x2, pan x1
echo $lista->procesar("añadir Pan 2") . "\n";        // leche x2, pan x3
echo $lista->procesar("eliminar arroz") . "\n";      // El producto seleccionado no existe
echo $lista->procesar("eliminar pan") . "\n";        // leche x2
echo $lista->procesar("vaciar") . "\n";              // (cadena vacía)