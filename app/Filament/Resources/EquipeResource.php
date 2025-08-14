<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipeResource\Pages;
use App\Filament\Resources\EquipeResource\RelationManagers;
use App\Models\Equipe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipeResource extends Resource
{
    protected static ?string $model = Equipe::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Equipe';
    protected static ?string $slug = 'equipe';
    protected static ?string $pluralModelLabel = 'Equipe';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome Completo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cargo')
                    ->label('Cargo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto do Perfil')
                    ->image()
                    ->directory('equipe-fotos') // Pasta onde as fotos serão armazenadas
                    ->imageResizeTargetWidth('300') // Redimensiona a imagem
                    ->imageResizeTargetHeight('300')
                    ->imageResizeMode('cover')
                    ->maxSize(2048) // Tamanho máximo em KB (2MB)
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bio')
                    ->label('Biografia')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('conhecimentos')
                    ->label('Conhecimentos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('ativo')
                    ->label('Status')
                    ->default(true) 
                    ->required(),
                Forms\Components\TextInput::make('ordem')
                    ->label('Sequência de Exibição')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome Completo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cargo')
                    ->label('Cargo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->defaultImageUrl(url('/image/default-avatar.png')) // URL de imagem padrão
                    ->size(40) // Tamanho alternativo (substitui width/height)
                    ->grow(false) // Não expandir a imagem
                    ->square() // Forçar formato quadrado
                    ->visibility('public'), // Visibilidade do arquivo
                
                Tables\Columns\IconColumn::make('ativo')
                    ->label('Status')
                    ->boolean(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->modalHeading('Editar Membro')->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()->label('')->tooltip('Excluir'),
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
            'index' => Pages\ManageEquipes::route('/'),
        ];
    }    
}