<?php
namespace App\Exports;

use App\Models\Movimentacao;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RelatorioExport implements FromCollection, WithHeadings
{
    protected $movimentacoes;

    public function __construct($movimentacoes)
    {
        $this->movimentacoes = $movimentacoes;
    }

    public function collection()
    {
        return collect($this->movimentacoes)->map(function($mov) {
            $usuarioNome = '-';
            if ($mov->usuario) {
                $usuarioNome = $mov->usuario->nome ?? $mov->usuario->id;
            } elseif ($mov->retirada_por) {
                $usuarioNome = 'ID: ' . $mov->retirada_por;
            }
            return [
                'Data' => date('d/m/Y', strtotime($mov->data_solicitacao)),
                'Produto' => $mov->produto->nome_produto ?? '-',
                'Categoria' => $mov->produto->categoria->nome_categoria ?? '-',
                'Fornecedor' => $mov->produto->fornecedor->nome_fantasia ?? '-',
                'Tipo' => ucfirst($mov->tipo_movimentacao),
                'Quantidade' => $mov->quantidade,
                'Usuário' => $usuarioNome,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Data', 'Produto', 'Categoria', 'Fornecedor', 'Tipo', 'Quantidade', 'Usuário'
        ];
    }
}
