<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessoResource\Pages;
use App\Filament\Resources\ProcessoResource\RelationManagers;
use App\Models\Processo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProcessoResource extends Resource
{
    protected static ?string $model = Processo::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Processo';
    protected static ?string $pluralModelLabel = 'Processos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Processo')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título/Processo')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('descricao')
                            ->label('Descrição')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\Select::make('categoria')
                            ->label('Setor')
                            ->required()
                            ->options(Processo::getCategorias())
                            ->native(false),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Diagrama do Processo')
                    ->schema([
                        Forms\Components\FileUpload::make('arquivo_path')
                            ->label('Arquivo do Diagrama')
                            ->required()
                            ->directory('processos-diagramas')
                            ->preserveFilenames()
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml',
                            ])
                            ->downloadable()
                            ->openable()
                            ->previewable(false)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('arquivo_nome', $state->getClientOriginalName());
                                    $set('arquivo_tipo', $state->getClientMimeType());
                                    $set('arquivo_tamanho', $state->getSize());
                                }
                            }),
                            
                        Forms\Components\Hidden::make('arquivo_nome'),
                        Forms\Components\Hidden::make('arquivo_tipo'),
                        Forms\Components\Hidden::make('arquivo_tamanho'),
                    ]),
                    
                Forms\Components\Section::make('Configurações')
                    ->schema([
                        Forms\Components\Toggle::make('ativo')
                            ->label('Status')
                            ->required()
                            ->default(true),
                            
                        Forms\Components\Select::make('user_id')
                            ->label('Responsável')
                            ->relationship('user', 'name')
                            ->default(Auth::id())
                            ->required()
                            ->searchable()
                            ->preload(),
                            
                        Forms\Components\Hidden::make('downloads')
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Processo')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn (Processo $record) => Str::limit($record->descricao, 50)),
                    
                Tables\Columns\TextColumn::make('categoria')
                    ->label('Setor')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Processo::getCategorias()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'cgti' => 'primary',
                        'cgpe' => 'success',
                        'aspe' => 'info',
                        'ccli' => 'warning',
                        'crat' => 'danger',
                        'cpgd' => 'secondary',
                        default => 'gray',
                    })
                    ->searchable(),
                    /*
                Tables\Columns\TextColumn::make('arquivo_tamanho')
                    ->label('Tamanho')
                    ->formatStateUsing(fn ($state, Processo $record) => $record->arquivo_tamanho_formatado)
                    ->sortable(),
                    */
                Tables\Columns\ImageColumn::make('arquivo_path')
                    ->label('Diagrama')
                    ->size(40)/*
    ->getStateUsing(function (Processo $record) {
        // Lógica para gerar ou retornar o caminho da miniatura
        return $record->gerarMiniatura(); // ou qualquer lógica você tenha
    })
    ->extraImgAttributes(['class' => 'rounded'])*/
                  //  ->circular()
                   // ->roundedFull()
                    ->default('https://via.placeholder.com/40'),
                Tables\Columns\IconColumn::make('ativo')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->options(Processo::getCategorias())
                    ->label('Coordenação'),
                    
                Tables\Filters\TernaryFilter::make('ativo')
                    ->label('Status')
                    ->trueLabel('Ativos')
                    ->falseLabel('Inativos')
                    ->native(false),
            ])
            ->actions([
                
                    
                Tables\Actions\Action::make('download')
                    ->label('')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Processo $record) => $record->arquivo_url)
                    ->openUrlInNewTab()
                    ->tooltip('Baixar Diagrama'),
                    
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar')
                    ->label(''),
                    
                Tables\Actions\DeleteAction::make()
                ->tooltip('Excluir')
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProcessos::route('/'),
        ];
    }
}