<?php

namespace App\Filament\Resources\ProcessoResource\Pages;

use App\Filament\Resources\ProcessoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessos extends ManageRecords
{
    protected static string $resource = ProcessoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Adicionar Processo')
                ->modalHeading('Adicionar Processo')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}