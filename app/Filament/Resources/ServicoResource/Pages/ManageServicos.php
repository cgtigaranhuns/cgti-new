<?php

namespace App\Filament\Resources\ServicoResource\Pages;

use App\Filament\Resources\ServicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageServicos extends ManageRecords
{
    protected static string $resource = ServicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar Serviço')
                ->modalHeading('Adicionar Serviço')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}