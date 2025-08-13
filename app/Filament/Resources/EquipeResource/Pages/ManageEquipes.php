<?php

namespace App\Filament\Resources\EquipeResource\Pages;

use App\Filament\Resources\EquipeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEquipes extends ManageRecords
{
    protected static string $resource = EquipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar Membro')
                ->modalHeading('Adicionar Membro da Equipe')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}