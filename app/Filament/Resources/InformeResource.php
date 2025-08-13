<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformeResource\Pages;
use App\Filament\Resources\InformeResource\RelationManagers;
use App\Models\Informe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InformeResource extends Resource
{
    protected static ?string $model = Informe::class;

    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Informes';
    protected static ?string $slug = 'informes';
    protected static ?string $pluralModelLabel = 'Informes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->label('Conteúdo')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Resumo')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('featured_image')
                    ->label('Imagem Destacada')
                    ->directory('img/informes')
                    ->disk('public')
                    ->preserveFilenames()
                    ->image(),
                Forms\Components\Toggle::make('published') 
                    ->label('Publicado')
                    ->default(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Data de Publicação')
                    ->default(now())
                    ->required(),
               /* Forms\Components\TextInput::make('views')
                    ->label('Visualizações')
                    ->required()
                    ->numeric()
                    ->default(0),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('featured_image'),
                Tables\Columns\IconColumn::make('published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
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
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->modalHeading('Editar Informe'),
                Tables\Actions\DeleteAction::make()->label(''),
                
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
            'index' => Pages\ManageInformes::route('/'),
        ];
    }    
}