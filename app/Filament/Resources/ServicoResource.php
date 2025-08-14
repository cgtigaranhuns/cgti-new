<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicoResource\Pages;
use App\Filament\Resources\ServicoResource\RelationManagers;
use App\Models\Servico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicoResource extends Resource
{
    protected static ?string $model = Servico::class;

    protected static ?string $navigationIcon = 'heroicon-s-cursor-arrow-ripple';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Serviços';
    protected static ?string $slug = 'servicos';
    protected static ?string $pluralModelLabel = 'Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Serviço/Sistema')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
        
                Forms\Components\TextInput::make('url')
                    ->label('Link')
                    ->url()
                    ->required()
                    ->maxLength(255),
                // Campo de upload do ícone
                Forms\Components\FileUpload::make('icon')
                    ->label('Ícone')
                    ->directory('img/icons')
                    ->disk('public')
                    ->preserveFilenames()
                    ->image()
                    ->maxSize(1024)
                    ->required(false)
                    ->helperText('Envie um arquivo PNG ou SVG para o ícone'),
                Forms\Components\TextInput::make('category')
                    ->label('Categoria')
                    ->required()
                    ->maxLength(255)
                    ->default('geral'),
                Forms\Components\Toggle::make('active')
                    ->label('Status')
                    ->default(true)
                    ->required(),
                Forms\Components\Select::make('internal')
                    ->label('Tipo de acesso')   
                    ->options([
                        0 => 'Público',
                        1 => 'Interno',
                        2 => 'Institucional',
                        3 => 'Governamental',
                    ])
                    ->required(),
               /* Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Serviço/Sistema')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('Link')
                    ->limit(35)
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('internal')
                    ->label('Tipo')
                    ->formatStateUsing(function ($state) {
                        // Converta para inteiro se necessário
                        $state = is_numeric($state) ? (int)$state : $state;
                        
                        return match($state) {
                            0 => 'Público',
                            1 => 'Interno',
                            2 => 'Institucional',
                            3 => 'Governamental',
                            default => 'Desconhecido (Valor: ' . json_encode($state) . ')',
                        };
                    })
                    ->searchable(),
               
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->modalHeading('Editar Serviço')
                ->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()->label('')
                ->tooltip('Excluir'),
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
            'index' => Pages\ManageServicos::route('/'),
        ];
    }    
}