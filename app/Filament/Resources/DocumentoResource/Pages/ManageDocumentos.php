<?php

namespace App\Filament\Resources\DocumentoResource\Pages;

use App\Filament\Resources\DocumentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentos extends ManageRecords
{
    protected static string $resource = DocumentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Adicionar Documento')
                ->modalHeading('Adicionar Documento')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}