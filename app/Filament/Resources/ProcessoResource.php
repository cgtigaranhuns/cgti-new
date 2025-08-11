<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessoResource\Pages;
use App\Filament\Resources\ProcessoResource\RelationManagers;
use App\Models\Processo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessoResource extends Resource
{
    protected static ?string $model = Processo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descricao')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('categoria')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('arquivo_path')
                    ->maxLength(255),
                Forms\Components\TextInput::make('arquivo_nome')
                    ->maxLength(255),
                Forms\Components\TextInput::make('arquivo_tamanho')
                    ->numeric(),
                Forms\Components\TextInput::make('arquivo_tipo')
                    ->maxLength(255),
                Forms\Components\Toggle::make('ativo')
                    ->required(),
                Forms\Components\TextInput::make('downloads')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria')
                    ->searchable(),
                Tables\Columns\TextColumn::make('arquivo_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('arquivo_nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('arquivo_tamanho')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('arquivo_tipo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('downloads')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProcessos::route('/'),
        ];
    }    
}
