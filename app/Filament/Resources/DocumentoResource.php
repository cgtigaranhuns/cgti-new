<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentoResource\Pages;
use App\Filament\Resources\DocumentoResource\RelationManagers;
use App\Models\Documento;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentoResource extends Resource
{
    protected static ?string $model = Documento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Documentos';
    protected static ?string $slug = 'documentos';
    protected static ?string $modelLabel = 'Documento';
    protected static ?string $pluralModelLabel = 'Documentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Documento')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('descricao')
                            ->label('Descrição')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\Select::make('categoria')
                            ->label('Categoria')
                            ->required()
                            ->options(Documento::getCategorias())
                            ->native(false),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Arquivo')
                    ->schema([
                        Forms\Components\FileUpload::make('arquivo_path')
                            ->label('Arquivo')
                            ->required()
                            ->directory('documentos')
                            ->preserveFilenames()
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
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
               Tables\Columns\IconColumn::make('arquivo_icone')
                    ->label('')
                    ->icon(fn (Documento $record) => match(strtolower(pathinfo($record->arquivo_nome, PATHINFO_EXTENSION))) {
                        'pdf' => 'heroicon-o-document-text',
                        'doc', 'docx' => 'heroicon-o-document',
                        'xls', 'xlsx' => 'heroicon-o-table-cells',
                        'ppt', 'pptx' => 'heroicon-o-presentation-chart-bar',
                        default => 'heroicon-o-document',
                    })
                    ->size('lg')
                    ->color(fn (Documento $record) => match(strtolower(pathinfo($record->arquivo_nome, PATHINFO_EXTENSION))) {
                        'pdf' => 'danger',
                        'doc', 'docx' => 'primary',
                        'xls', 'xlsx' => 'success',
                        'ppt', 'pptx' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn (Documento $record) => Str::limit($record->descricao, 50)),
                    
                Tables\Columns\TextColumn::make('categoria')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Documento::getCategorias()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'guias' => 'info',
                        'normas' => 'primary',
                        'legislacao' => 'warning',
                        'formularios' => 'success',
                        'procedimentos' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('arquivo_tamanho')
                    ->label('Tamanho')
                    ->formatStateUsing(fn ($state, Documento $record) => $record->arquivo_tamanho_formatado)
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('downloads')
                    ->label('Downloads')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->options(Documento::getCategorias())
                    ->label('Categoria'),
                    
                Tables\Filters\TernaryFilter::make('ativo')
                    ->label('Status')
                    ->trueLabel('Ativos')
                    ->falseLabel('Inativos')
                    ->native(false),
                    
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Responsável')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('')
                    ->tooltip('Baixar Documento')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Documento $record) => $record->arquivo_url)
                    ->openUrlInNewTab(),
                    
                Tables\Actions\EditAction::make()
                    ->label('')->modalHeading('Editar Documento')->tooltip('Editar'),
                    
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Tem certeza?')
                    ->modalDescription('Essa ação não pode ser desfeita.')
                    ->modalButton('Excluir')
                    ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
                    ->label('')
                    ->tooltip('Excluir')
                    ->requiresConfirmation(), // Se deseja confirmação antes de excluir*/
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
            'index' => Pages\ManageDocumentos::route('/'),
        ];
    }
}