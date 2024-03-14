<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\ProductResource\Pages;
use App\Filament\Resources\Product\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $slug = "product/lists";


    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Product';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Product Name')->maxLength(255)->required(),
            TextInput::make('price')->numeric()->prefix('Rp')->maxValue(42949672.95)->required(),
            Select::make('category_id')
                ->label('Product Category')
                ->relationship('category', 'name')
                ->preload()
                ->searchable()
                ->createOptionForm([TextInput::make('name')->label('Category Name')->required()])
                ->columnSpanFull(),
            Textarea::make("description")->label("Product Desctiption")->default("-")->columnSpanFull(),
            FileUpload::make('img_url')->label("Product Photo")->required()->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('img_url')->label('Product Photo'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('description')->default('-'),
                TextColumn::make('price')->money('IDR')->sortable(),
                TextColumn::make("category.name"),
                TextColumn::make("flows.amount")->label("Stocks Avaible")->getStateUsing(function ($record) {
                    $in = $record->flows()->where("type", "IN")->sum("amount");
                    $out = $record->flows()->where("type", "OUT")->sum("amount");
                    return $in - $out;
                })
            ])
            ->filters([
                SelectFilter::make('category_id')->label("Product Category")->relationship('category', 'name')
            ])
            ->actions([Tables\Actions\ViewAction::make(),Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
